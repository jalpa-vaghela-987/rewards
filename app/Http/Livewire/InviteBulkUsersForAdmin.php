<?php

namespace App\Http\Livewire;

use App\Imports\UsersInvitation;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class InviteBulkUsersForAdmin extends Component
{
    use WithFileUploads;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $invite_sheet;
    public $errorKeys = [];

    public function mount()
    {
        $this->errorKeys = [
            '.first_name', '.last_name', '.name', '.level', '.email', '.role', '.birthday', '.anniversary',
        ];
    }

    public function render()
    {
        return view('livewire.invite-bulk-users-for-admin');
    }

    public function sendInvitation()
    {
        $this->validate([
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
            return $this->addError('invite_sheet', 'File format is not supported');
        }

        Excel::import(new UsersInvitation(auth()->user()->company), $path, config('filesystems.default'));

        $this->emit('saved');

        $this->reset(['invite_sheet']);
    }

    public function getErrorMessage($message)
    {
        foreach ($this->errorKeys as $item) {
            if (str_contains($message, $item)) {
                $parts = explode($item, $message);

                if (count($parts)) {
                    $index = preg_replace('/[A-Za-z ]/', '', $parts[0]);

                    return str_replace($index, '', $parts[0]).
                        str_replace('.', '', $item).
                        ' at row '.($index + 1).' '.trim($parts[1]);
                }
            }
        }

        return '';
    }
}
