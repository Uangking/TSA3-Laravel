@extends('layouts.app')

@section('title', 'Tasks for Today')

@section('content')
    <h1>Tasks for Today</h1>
    <p class="date"><time datetime="{{ $todayDate }}">{{ $todayLabel }}</time></p>

    @if ($tasks->isEmpty())
        <p>No tasks are scheduled for today. Enjoy your free time!</p>
    @else
        <ul class="task-list">
            @foreach ($tasks as $task)
                <li class="task">
                    <strong>{{ $task->title }}</strong>
                    <span class="status">Status: {{ $task->status }}</span>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
