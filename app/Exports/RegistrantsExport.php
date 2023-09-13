<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RegistrantsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public $conferenceid;

    public function __construct($conferenceid)
    {
        $this->conferenceid = $conferenceid;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Application::select('id','firstname', 'lastname', 'email', 'phone', 'institution', 'occupation', 'reg_currency', 'reg_amount','created_at')->where('conference_id', $this->conferenceid)->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'FIRST NAME',
            'LAST NAME',
            'EMAIL',
            'PHONE NO#',
            'INSTITUTION',
            'OCCUPATION / STUDENT TYPE',
            'CURRENCY',
            'AMOUNT',
            'SUBMITTED DATE',
        ];
    }
}
