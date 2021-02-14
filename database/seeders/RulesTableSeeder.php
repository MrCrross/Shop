<?php

namespace Database\Seeders;

use App\Models\Rule;
use Illuminate\Database\Seeder;

class RulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rules = ['admin'];

        foreach($rules as $rule)
        {
            $result = Rule::create(['name' => $rule]);
        }
    }
}
