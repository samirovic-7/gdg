<?php

namespace Database\Seeders;

use App\Models\Ledger;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeadgerSeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ledger::create([ 
             'code' => 1,
        'name' => 'sd',
        'name_loc' => 'ds',
        'type' => 'sd',
        'ledger_cat_id' => 1,
    ]);
        
}
}
