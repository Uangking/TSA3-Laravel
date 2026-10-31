@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <h1>Profile</h1>

    @if ($user === null)
        <p>No user profile is available yet.</p>
    @else
        <dl>
            <dt>Username</dt>
            <dd>{{ $user->username }}</dd>

            <dt>Full Name</dt>
            <dd>{{ $user->full_name }}</dd>

            <dt>Email</dt>
            <dd>{{ $user->email }}</dd>

            <dt>Created At</dt>
            <dd>{{ $user->created_at->format('Y-m-d H:i:s') }}</dd>
        </dl>
    @endif
@endsection
