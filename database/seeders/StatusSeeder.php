<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(["name" => "Pending"]);
        Status::create(["name" => "Inprogress"]);
        Status::create(["name" => "Completed"]);
        Status::create(["name" => "Cancelled"]);
    }
}
