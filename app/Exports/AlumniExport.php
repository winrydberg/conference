<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AlumniExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('id', 'title','firstname', 'lastname', 'gender', 'email', 'phone', 'house', 'yeargroup', 'status','whatsapp','created_at')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'TITLE',
            'FIRSTNAME',
            'LASTNAME',
            'GENDER',
            'EMAIL',
            'PHONE NO#',
            'HOUSE',
            'YEAR GROUP',
            'STATUS',
            'WHATSAPP NO',
            'REG DATE',
        ];
    }
}
