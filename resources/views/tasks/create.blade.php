@extends('layout')
@section('content')
    <h1>Create Task</h1>
    @include('alert')
    <form action="{{ route('task.create') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="exampleInputTitle1" class="form-label">Title</label>
            <input type="text" class="form-control" id="exampleInputTitle1" aria-describedby="titleHelp" name="title">
        </div>
        <div class="mb-3">
            <label for="exampleInputDescription1" class="form-label">Description</label>
            <input type="text" class="form-control" id="exampleInputDescription1" name="description">
        </div>
        <div class="mb-3">
            <select name="completed" id="" class="form-control">
                <option value="Chưa hoàn thành">Chưa hoàn thành</option>
                <option value="Hoàn thành">Hoàn thành</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
