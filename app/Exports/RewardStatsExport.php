<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RewardStatsExport implements FromCollection, WithHeadings
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
            'Title',
            'Amount In '.getReplacedWordOfKudos(),
            'Stock Left',
            'Amount Redeemed',
            'Type',
            'Currency',
            'Last Redeemed By',
        ];
    }
}
