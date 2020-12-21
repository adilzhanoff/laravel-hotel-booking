@extends('layouts.app')

@section('title', 'Room '.$room->number)

@section('content')
<div class="container" style="margin-left: 130px; margin-right: 130px; margin-top: 30px; margin-bottom: 90px">
    <div class="row-auto">
        <div class="col-md-6">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                        <button type="button" class="ml-1 close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endforeach
            @endif
            
            @if (session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Fill the form</h5>
                    </div>
                    <div class="card-body">
                            <div class="form-group">
                                <label>Number</label>
                                <input type="text" name="number" value="{{ $room->number }}" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3" disabled>{{ $room->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control" disabled>
                                    <option>{{ $categories->where('id', $room->category_id)->first()->name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>View</label>
                                <select name="view_id" class="form-control" disabled>
                                        <option>{{ $views->where('id', $room->view_id)->first()->name }}</option>
                                </select>
                            </div>
                            <label class="mb-2">Hourly Rate</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">$</div>
                                </div>
                                <input type="number" name="rate" value="{{ $room->rate }}" class="form-control" disabled>
                            </div>
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary"><i class="fa fa-backward" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <table class="table table-striped table-bordered mt-3">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Room ID</th>
                            <th scope="col">Start Time</th>
                            <th scope="col">Finish Time</th>
                            <th scope="col">Hours</th>
                            <th scope="col">Total Price</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $idx = 0;
                        ?>
                        @foreach($rooms as $room)
                            <?php $idx++; ?>
                            <tr>
                                <th scope="row">{{ $idx }}</th>
                                <td>{{ $room->pivot->user_id }}</td>
                                <td>{{ $room->pivot->room_id }}</td>
                                <td>{{ $room->pivot->start }}</td>
                                <td>{{ $room->pivot->finish }}</td>
                                <td>{{ $room->pivot->hours }}</td>
                                <td>{{ $room->pivot->total_price }}</td>
                                <td class="table-buttons">
                                    <form class="form-delete" action="{{ route('admin.rooms.destroy', $room) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this Room?')" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection