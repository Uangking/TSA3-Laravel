<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            User::updateOrCreate(
                ['username' => 'demo_student'],
                [
                    'full_name' => 'Demo Student',
                    'email' => 'demo.student@example.com',
                ],
            );

            $today = CarbonImmutable::today('Asia/Manila');
            $tasks = [
                ['Review project requirements', 'completed', $today->subDay()],
                ['Organize project files', 'completed', $today->subDay()],
                ["Check today's assignments", 'pending', $today],
                ['Complete CodeIgniter activity', 'pending', $today],
                ['Review database structure', 'completed', $today],
                ['Test application functionality', 'pending', $today],
                ['Prepare project documentation', 'pending', $today->addDay()],
                ['Review GitHub submission', 'pending', $today->addDay()],
            ];

            foreach ($tasks as [$title, $status, $taskDate]) {
                Task::updateOrCreate(
                    ['title' => $title],
                    [
                        'status' => $status,
                        'task_date' => $taskDate->toDateString(),
                    ],
                );
            }
        });
    }
}
