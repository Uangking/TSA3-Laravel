<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;

class PagesController extends Controller
{
    public function index(): View
    {
        $today = CarbonImmutable::today('Asia/Manila');
        $tasks = Task::whereDate('task_date', $today->toDateString())->get();

        return view('pages.home', [
            'tasks' => $tasks,
            'todayDate' => $today->toDateString(),
            'todayLabel' => $today->format('F j, Y'),
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }
}
