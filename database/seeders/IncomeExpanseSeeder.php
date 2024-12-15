<?php

namespace Database\Seeders;

use App\Models\IncomeExpanse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeExpanseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IncomeExpanse::create([

            'value' =>'1000000',
            'type_id' => 'oshxonaq',
            'comment' => 'xarajat chiqqim',
            'user_id' => 1,
            'dateTime' => null,

            // 'value' => $request->value,
            // 'type_id' => $request->type_id,
            // 'comment' => $request->comment,
            // 'user_id' => Auth::user()->id,
            // 'dateTime' => now(),
        ]);
        IncomeExpanse::create([

            'value' =>'1000000',
            'type_id' => 'oshxonaq',
            'comment' => 'xarajat chiqqim',
            'user_id' => 1,
            'dateTime' => null,
        ]);
    }
}
