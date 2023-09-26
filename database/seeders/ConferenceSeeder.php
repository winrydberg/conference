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
            'title' => 'First Annual Engineering Conference - 2023',
            'startdate' => date('2023-09-29'),
            'enddate' => date('2023-09-29'),
            'venue' => 'ISSER Conference Centre and School of Engineering Sciences ',
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
                'UG Engineering Conference Abstract Template.docx'
            ])
        ]);


    }
}
