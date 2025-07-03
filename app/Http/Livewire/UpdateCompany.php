<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Artisan;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use PragmaRX\Countries\Package\Countries;

class UpdateCompany extends Component
{
    use WithFileUploads;

    public $cname;
    public $description;
    public $photo;
    public $exists;
    public $country;
    public $show_multiple_currencies;
    public $default_currency;

    public function render()
    {
        return view('livewire.update-company', [
            'countries' => Countries::all()
                ->pluck('name.common')
                ->toArray(),
        ]);
    }

    public function mount($company = false)
    {
        if ($company && auth()->user()) {
            $this->cname = auth()->user()->company->getRawOriginal('name');
            $this->country = auth()->user()->company->country;
            $this->exists = true;
            $this->show_multiple_currencies = auth()->user()->company->show_multiple_currencies;
            $this->default_currency = auth()->user()->company->default_currency;
        }
    }

    public function submitCompany()
    {
        $currencies = \App\Models\Tango::where('disabled', 0)
            ->where('active', 1)
            ->pluck('currency')
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->all();

        $data = $this->validate(
            [
                'cname' => ['required', 'max:120'],
                'photo' => ['nullable'],
                'country' => ['required', 'string'],
                'show_multiple_currencies' => ['required', 'boolean'],
                'default_currency' => [
                    'required',
                    'string',
                    'max:6',
                    Rule::in($currencies),
                ],
            ],
            [],
            [
                'cname' => 'Company name',
                'photo' => 'Logo',
            ]
        );

        //dd($data);

        if ($this->photo != null) {
            $path = $this->photo->storePublicly('company_photos', 's3');
            if ($path != null) {
                $path = 'https://perksweet-uploads.s3.amazonaws.com/'.$path;
            }
        } else {
            $path = null;
        }

        $name = $data['cname'];
        $country = $data['country'];
        $alias = $this->clean($data['cname']);
        $alias = $this->createalise($alias, $alias, 1);
        $link_url = url('/').'/company/join/'.$alias;

        if ($this->exists && auth()->user()) {
            $company = auth()->user()->company;
        } else {
            $company = new Company();
        }

        $company->name = $name;
        $company->country = $country;
        $company->alias = $alias;
        $company->join_link = $link_url;
        $company->logo_path = $path ?? data_get($company, 'logo_path', $path);
        $company->default_currency = $data['default_currency'];
        $company->show_multiple_currencies = $data['show_multiple_currencies'];
        $result = $company->save();

        $this->emit('saved');
        if (! $this->exists) {
            return redirect()->to($link_url);
        }

        $this->emit('company_logo_updated', ['logo' => $company->logo_path]);

        //updates currency rates in case default was changed.
        dispatch(function () {
            Artisan::call('exchange-rates:update');
        });
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
