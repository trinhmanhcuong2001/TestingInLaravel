@extends('layout')
@section('content')
    <h1>Dashboard</h1>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('task.create') }}">Create Task</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('task.index') }}">List Task</a>
        </li>
    </ul>
@endsection
