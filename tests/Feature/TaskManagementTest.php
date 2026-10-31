<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_eight_tasks_and_one_user_without_duplicates(): void
    {
        $this->seed();

        $this->assertSame(8, Task::count());
        $this->assertSame(1, User::count());
        $this->assertGreaterThanOrEqual(3, Task::query()->distinct()->count('task_date'));
        $this->assertTrue(Task::whereDate('task_date', CarbonImmutable::today('Asia/Manila'))->exists());

        $this->seed();

        $this->assertSame(8, Task::count());
        $this->assertSame(1, User::count());
    }

    public function test_new_tasks_default_to_pending(): void
    {
        $task = Task::create([
            'title' => 'Task without an explicit status',
            'task_date' => CarbonImmutable::today('Asia/Manila'),
        ]);

        $this->assertSame('pending', $task->fresh()->status);
    }

    public function test_welcome_page_shows_only_tasks_dated_today_in_manila(): void
    {
        $today = CarbonImmutable::today('Asia/Manila');
        Task::create(['title' => 'Due today', 'status' => 'pending', 'task_date' => $today]);
        Task::create(['title' => 'Due yesterday', 'status' => 'completed', 'task_date' => $today->subDay()]);

        $this->get('/')
            ->assertOk()
            ->assertSeeText('Tasks for Today')
            ->assertSeeText($today->format('F j, Y'))
            ->assertSeeText('Due today')
            ->assertDontSeeText('Due yesterday');
    }

    public function test_welcome_page_shows_a_message_when_no_tasks_are_scheduled(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSeeText('No tasks are scheduled for today. Enjoy your free time!');
    }

    public function test_task_list_shows_every_task_sorted_by_date_then_id(): void
    {
        $today = CarbonImmutable::today('Asia/Manila');
        Task::create(['title' => 'Tomorrow', 'status' => 'pending', 'task_date' => $today->addDay()]);
        Task::create(['title' => 'Today first', 'status' => 'pending', 'task_date' => $today]);
        Task::create(['title' => 'Today second', 'status' => 'completed', 'task_date' => $today]);
        Task::create(['title' => 'Yesterday', 'status' => 'completed', 'task_date' => $today->subDay()]);

        $this->get('/tasks')
            ->assertOk()
            ->assertSeeText('Yesterday')
            ->assertSeeText('Today first')
            ->assertSeeText('Today second')
            ->assertSeeText('Tomorrow')
            ->assertSeeInOrder(['Yesterday', 'Today first', 'Today second', 'Tomorrow']);
    }

    public function test_profile_page_displays_the_single_user_and_handles_no_user(): void
    {
        $this->get('/profile')
            ->assertOk()
            ->assertSeeText('No user profile is available yet.');

        User::create([
            'username' => 'demo_student',
            'full_name' => 'Demo Student',
            'email' => 'demo.student@example.com',
        ]);

        $this->get('/profile')
            ->assertOk()
            ->assertSeeText('demo_student')
            ->assertSeeText('Demo Student')
            ->assertSeeText('demo.student@example.com');
    }

    public function test_about_page_and_navigation_are_available(): void
    {
        foreach (['/', '/tasks', '/profile', '/about'] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertSee(route('home'))
                ->assertSee(route('tasks.index'))
                ->assertSee(route('profile'))
                ->assertSee(route('about'));
        }

        $this->get('/about')
            ->assertSeeText('About')
            ->assertSeeText('Laravel')
            ->assertSeeText('King Gee');
    }
}
