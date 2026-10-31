<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tasks for Today')</title>
    <style>
        body {
            max-width: 900px;
            margin: 3rem auto;
            padding: 0 1.25rem;
            color: #243047;
            font-family: system-ui, sans-serif;
            line-height: 1.6;
        }

        nav {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        a {
            color: #2457a7;
        }

        .date {
            color: #596579;
        }

        .task-list {
            padding-left: 1.25rem;
        }

        .task {
            margin: 0.75rem 0;
            padding: 0.75rem 1rem;
            border: 1px solid #d9e0ea;
            border-radius: 0.5rem;
        }

        .status {
            margin-left: 0.5rem;
            color: #596579;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th,
        td {
            padding: 0.75rem;
            border: 1px solid #d9e0ea;
        }

        th {
            background: #f2f5f9;
        }

        dl {
            display: grid;
            grid-template-columns: max-content 1fr;
            gap: 0.75rem 1.5rem;
        }

        dt {
            font-weight: 600;
        }

        dd {
            margin: 0;
        }
    </style>
</head>
<body>
    <nav aria-label="Main navigation">
        <a href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Home</a>
        <a href="{{ route('tasks.index') }}" @if (request()->routeIs('tasks.index')) aria-current="page" @endif>Task List</a>
        <a href="{{ route('profile') }}" @if (request()->routeIs('profile')) aria-current="page" @endif>Profile</a>
        <a href="{{ route('about') }}" @if (request()->routeIs('about')) aria-current="page" @endif>About</a>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
