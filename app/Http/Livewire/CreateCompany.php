<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Tango;
use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use PragmaRX\Countries\Package\Countries;

class CreateCompany extends Component
{
    use WithFileUploads;

    public $cname;
    public $description;
    public $photo;
    public $captcha;
    public $exists;
    public $country = 'United States';
    public $default_currency = 'USD';

    public function render()
    {
        return view('livewire.create-company', [
            'countries' => Countries::all()
                ->pluck('name.common')
                ->toArray(),
            'currencies' => Tango::all()
                ->where('disable', 0)
                ->where('active', 1)
                ->pluck('currency')
                ->flatten()
                ->unique()
                ->sort()
                ->values()
                ->all(),
        ]);
    }

    public function mount($company = false)
    {
        if ($company && Auth::user()) {
            $this->cname = Auth::user()->company->name;
            $this->country = Auth::user()->company->country;
            $this->default_currency = Auth::user()->company->default_currency;
            $this->exists = true;
        }
    }

    public function submitCompany()
    {
        $data = $this->validate(
            [
                'cname' => ['required', 'max:120'],
                'photo' => ['nullable'],
                'country' => ['required', 'string'],
                'default_currency' => ['required', 'string'],
                'captcha' => ['required', 'captcha'],
            ],
            [
                'captcha.required' => 'Please verify that you are not a robot.',
            ],
            [
                'cname' => 'Company name',
                'photo' => 'Logo',
            ]
        );

        if ($this->photo !== null) {
            $path = $this->photo->storePublicly('company_photos', 's3');
            if ($path !== null) {
                $path = 'https://perksweet-uploads.s3.amazonaws.com/'.$path;
            }
        } else {
            $path = null;
        }

        $name = $data['cname'];
        $country = $data['country'];
        $default_currency = $data['default_currency'];
        $alias = $this->clean($data['cname']);
        $alias = $this->createalise($alias, $alias, 1);
        $link_url = url('/').'/company/join/'.$alias;

        if ($this->exists && Auth::user()) {
            $company = Auth::user()->company;
        } else {
            $company = new Company();
        }

        $company->name = $name;
        $company->country = $country;
        $company->default_currency = $default_currency;
        $company->alias = $alias;
        $company->join_link = $link_url;
        $company->logo_path = $path;
        $result = $company->save();

        $this->emit('saved');
        if (! $this->exists) {
            return redirect()->to($link_url);
        }
    }

    public function clean($string)
    {
        $string = str_replace(' ', '', $string); // Removes all spaces .

        return preg_replace("/[^A-Za-z0-9\-]/", '', $string); // Removes special chars.
    }

    public function createalise($alias, $new_alias, $start)
    {
        $found_company = Company::where('alias', '=', $new_alias)->first();
        if ($found_company == null) {
            return $new_alias;
        }

        $new_alias = $alias.$start;
        $start++;

        return $this->createalise($alias, $new_alias, $start);
    }
}
