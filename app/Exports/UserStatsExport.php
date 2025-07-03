<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserStatsExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    /**
     * Write code on Method.
     *
     * @return response()
     */
    public function headings() :array
    {
        return [
            'Name',
            'Email',
            'Available '.getReplacedWordOfKudos().' to Spend',
            'Available '.getReplacedWordOfKudos().' to Give',
            'Last '.getReplacedWordOfKudos().' Sent At',
            'Last Login At',

        ];
    }
}
