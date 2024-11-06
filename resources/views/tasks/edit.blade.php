@extends('layout')

@section('content')
    <h1>Update Task</h1>
    @include('alert')
    <form action="{{ route('task.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="exampleInputTitle1" class="form-label">Title</label>
            <input type="text" class="form-control" id="exampleInputTitle1" aria-describedby="titleHelp" name="title"
                value="{{ $task->title }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputDescription1" class="form-label">Description</label>
            <input type="text" class="form-control" id="exampleInputDescription1" name="description"
                value="{{ $task->description }}">
        </div>
        <div class="mb-3">
            <select name="completed" id="" class="form-control">
                <option value="Chưa hoàn thành" {{ $task->completed == 'Chưa hoàn thành' ? 'selected' : '' }}>Chưa hoàn
                    thành</option>
                <option value="Hoàn thành" {{ $task->completed == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
