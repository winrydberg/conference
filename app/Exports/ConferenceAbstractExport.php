<?php

namespace App\Exports;

use App\Models\ConferenceAbstract;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ConferenceAbstractExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return ConferenceAbstract::select(
            'firstname',
            'lastname',
            'institution',
            'title',
            'email',
            'phone',
            'coauthors',
            'corresponding_authorname',
            'corresponding_authoremail',
            'thematic',
            'presentationtype',
            'journal_publication',
            'comments',
            'approved'
        )->where('conference_id', $this->conferenceid)
        ->get();
    }

    public function headings(): array
    {
        return [
            'FIRST NAME',
            'LAST NAME',
            'INSTITUTION',
            'PAPER TITLE',
            'EMAIL',
            'PHONE NO#',
            'CO AUTHORS',
            'CORRESPONDING AUTHOR NAME',
            'CORRESPONDING AUTHOR EMAIL',
            'THEMATIC',
            'PRESENTATION TYPE',
            'JOURNAL PUBLICATION',
            'COMMENTS',
            'APPROVAL STATUS',
        ];
    }
}
