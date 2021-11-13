@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="float-left">Tasks</h4>

                    <button class="float-right btn btn-primary" data-toggle="modal" data-target="#createTaskModal">
                        Add task
                    </button>

                    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <form action="{{route("task.store")}}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createTaskModalLabel">Add new task</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Content</label>
                                            <textarea type="password" class="form-control ckeditorContent" id="content" name="content" rows="10" placeholder="Content"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        <?php request()->session()->forget('success') ?>
                    @endif
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Task</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tasks as $task)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$task->title}}</td>
                                <td>{{ \Carbon\Carbon::parse($task->created_at)->diffForHumans() }}</td>
                                <td>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showTask{{$task->id}}"><i class="fas fa-eye mr-3 text-dark"></i></a>

                                    <div class="modal fade" id="showTask{{$task->id}}" tabindex="-1" aria-labelledby="showTask{{$task->id}}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="showTask{{$task->id}}Label">{{$task->title}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="min-height: 300px;">
                                                    {!! $task->content !!}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#updateTask{{$task->id}}"><i class="fas fa-edit mr-3 text-primary"></i></a>

                                    <div class="modal fade modal-update" id="updateTask{{$task->id}}" date-id="{{$task->id}}" tabindex="-1" aria-labelledby="updateTask{{$task->id}}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <form action="{{route("task.update", $task->id)}}" method="POST">
                                                    @csrf
                                                    @method("PUT")
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateTask{{$task->id}}Label">Update task</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="title{{$task->id}}" class="form-label">Title</label>
                                                            <input type="text" class="form-control" id="title{{$task->id}}" name="title" placeholder="Title" required value="{{$task->title}}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="content{{$task->id}}" class="form-label">Content</label>
                                                            <textarea type="password" class="form-control ckeditorContent" id="content{{$task->id}}" name="content" rows="10" placeholder="Content">{!! $task->content !!}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <form class="d-inline-block" action="{{route("task.destroy", $task->id)}}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <a href="javascript:void(0)" onclick="if (confirm('Do you want to delete this record?')) {this.parentElement.submit();}"><i class="fas fa-trash-alt mr-3 text-danger"></i></a>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No tasks.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
