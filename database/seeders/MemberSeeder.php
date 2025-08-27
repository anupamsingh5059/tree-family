<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $anupam = Member::create([
        //     'name' => 'Anupam',
        //     'relation' => 'self',
        //     'parent_id' => 0
        // ]);
         $anupam = Member::create([
            'name' => 'Gajendra',
            'relation' => 'self',
            'parent_id' => 2
        ]);

        Member::create([
            'name' => 'Anupam',
            'relation' => 'child',
            'parent_id' => 2
        ]);

        Member::create([
            'name' => 'Sita',
            'relation' => 'spouse',
            'parent_id' => 2
        ]);

        Member::create([
            'name' => 'Priya',
            'relation' => 'child',
            'parent_id' => 2
        ]);

        Member::create([
            'name' => 'Adity',
            'relation' => 'child',
            'parent_id' => 2
        ]);

        Member::create([
            'name' => 'Jita',
            'relation' => 'sibling',
            'parent_id' => 2
        ]);
    }
}
