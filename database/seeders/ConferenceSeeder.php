<?php

namespace Database\Seeders;

use App\Models\Conference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * FIRST ANNUAL ENGINEERING CONFERENCE
     */
    public function run(): void
    {
        $token  = sha1(time());
        Conference::create([
            'image' => null,
            'title' => 'OMSU Congress - 2023',
            'startdate' => date('2023-10-27'),
            'enddate' => date('2023-10-29'),
            'venue' => 'Mawuli School ',
            'starttime' => '9:00',
            'endtime' => '16:00',
            'description' => 'Test',
            'regtable' => 'N/A',
            'extras' => '',
            'isopen' => true,
            'url' => url('/apply-now?cid='.$token),
            'receive_abstract' => 1,
            'token' => $token,
            'attachments' => json_encode([
                'Mawuli School.docx'
            ])
        ]);


    }
}
