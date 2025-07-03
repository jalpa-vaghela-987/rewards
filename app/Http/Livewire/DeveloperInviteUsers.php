<?php

namespace App\Http\Livewire;

use App\Imports\UsersInvitation;
use App\Models\Company;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class DeveloperInviteUsers extends Component
{
    use WithFileUploads;

    public $company;
    public $companies = [];
    public $company_search;
    public $is_company_showing = 'hidden';

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $invite_sheet;

    public function render()
    {
        return view('livewire.developer-invite-users');
    }

    public function updatedCompanySearch()
    {
        if ($this->company_search) {
            $this->companies = Company::where(
                'name',
                'like',
                "$this->company_search%"
            )
                ->where('active', 1)
                ->orderBy('name')
                ->take(5)
                ->get();

            $this->is_company_showing = '';
        } else {
            $this->reset(['companies', 'company', 'is_company_showing']);
        }
    }

    public function selectCompany($company_id)
    {
        if ($company_id) {
            $this->company = Company::find($company_id);
            $this->is_company_showing = 'hidden';
            $this->company_search = $this->company->name;
            $this->company = $company_id;

            $this->reset('companies');
        }
    }

    public function sendInvitation()
    {
        $this->validate([
            'company' => ['required', Rule::exists('companies', 'id')],
            'invite_sheet' => ['required', 'file'],
        ]);

        $path = $this->invite_sheet->path();

        $pathParts = explode('livewire-tmp', $path);

        $path = 'livewire-tmp'.$pathParts[1];

        $uploadedFileMimeType = $this->invite_sheet->getMimeType();

        if (
            ! in_array(strtolower($uploadedFileMimeType), [
                'text/csv',
                'application/vnd.msexcel',
                'application/vnd.ms-excel',
                'text/comma-separated-values',
                'application/csv,application/excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheetapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
        ) {
            return $this->addError(
                'invite_sheet',
                'File format is not supported'
            );
        }

        Excel::import(
            new UsersInvitation($this->company),
            $path,
            config('filesystems.default')
        );

        $this->emit('saved');

        $this->reset([
            'company',
            'invite_sheet',
            'company_search',
            'is_company_showing',
        ]);
    }

    public function getErrorMessage($message)
    {
        $replace = ['.email', '.level', '.role', '.name'];

        foreach ($replace as $item) {
            if (str_contains($message, $item)) {
                $parts = explode($item, $message);

                if (count($parts)) {
                    $index = preg_replace('/[A-Za-z ]/', '', $parts[0]);

                    return str_replace($index, '', $parts[0]).
                        str_replace('.', '', $item).
                        ' at row '.
                        ($index + 1).
                        ' '.
                        trim($parts[1]);
                }
            }
        }

        return '';
    }
}
