<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RewardsExport implements FromCollection, WithHeadings
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
            'Recipient Name',
            'Reward Title',
            getReplacedWordOfKudos(),
            'Amount',
            'Currency',
            'Status',
            'Approval',
            'Unique Redemption Code',
            'Purchase Date',
        ];
    }
}
