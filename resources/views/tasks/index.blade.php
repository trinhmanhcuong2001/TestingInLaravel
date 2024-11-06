@extends('layout')
@section('content')
    <h1 class="text-center">Danh sách công việc</h1>
    @include('alert')
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Descriptiton</th>
                <th>Completed</th>
                <th>Features</th>
            </tr>
        </thead>
        <tbody>
            @if (count($tasks) > 0)
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->completed }}</td>
                        <td class="d-flex">
                            <a href="{{ route('task.update', $task->id) }}" class="btn btn-primary me-2">Update</a>
                            <form action="{{ route('task.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Bạn có chắc muốn xóa không!')"
                                    class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">Không có công việc nào!</td>
                </tr>
            @endif

        </tbody>
    </table>
@endsection
