<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::factory()
            ->count(500)
            ->has(Transaction::factory()->count(300))
            ->create();
    }
}
