<?php

namespace App\Imports;

use App\Jobs\InviteChunkUsers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UsersInvitation implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public $format;
    private $companyId;

    public function __construct($companyId)
    {
        $this->companyId = $companyId;
        $this->format = [
            'birthday'      => 'm-d',
            'anniversary'   => 'Y-m-d',
        ];
    }

    public function birthdayFormat()
    {
        return data_get($this->format, 'birthday');
    }

    public function anniversaryFormat()
    {
        return data_get($this->format, 'anniversary');
    }

    public function collection(Collection $rows)
    {
        $rows->transform(function ($user) {
            if (isset($user['birthday_ddmm'])) {
                $user['birthday'] = is_string($user['birthday_ddmm'])
                    ? $user['birthday_ddmm']
                    : Date::excelToDateTimeObject($user['birthday_ddmm'])->format($this->birthdayFormat());
            }

            if (isset($user['anniversary_ddmmyyyy'])) {
                $user['anniversary'] = is_string($user['anniversary_ddmmyyyy'])
                    ? $user['anniversary_ddmmyyyy']
                    : Date::excelToDateTimeObject($user['anniversary_ddmmyyyy'])->format($this->anniversaryFormat());
            }

            return $user;
        });

        Validator::make($rows->toArray(), [
            '*.name'        => ['string', 'required_without_all:*.first_name,*.last_name', 'min:5', 'max:255'],
            '*.first_name'  => ['alpha_num', 'required_without:*.name', 'min:3', 'max:255'],
            '*.last_name'   => ['alpha_num', 'required_without:*.name', 'min:1', 'max:255'],
            '*.email'       => ['required', 'email:rfc,dns'],
            '*.title'       => ['string', 'nullable', 'max:255'],
            '*.role'        => [Rule::in(['editor', 'admin'])],
            '*.level'       => [Rule::in(['level 1', 'level 2', 'level 3', 'level 4', 'level 5'])],
            '*.birthday'    => ['nullable', "date_format:{$this->birthdayFormat()}"],
            '*.anniversary' => ['nullable', 'date', "date_format:{$this->anniversaryFormat()}"],
        ])->validate();

        foreach ($rows->unique('email')->chunk(20) as $users) {
            dispatch(new InviteChunkUsers($this->companyId, $users, auth()->id()));
        }
    }
}
