<?php

namespace Database\Seeders;

use App\Models\MailTemplate;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Insert Settings
        MailTemplate::create();
    }
}
