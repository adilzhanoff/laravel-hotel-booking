@extends('layouts.app')

@section('title', 'Room '.$room->number)

@section('content')
<div style="margin-left: 130px; margin-right: 130px; margin-top: 30px; margin-bottom: 90px">
    <div class="row">
        <div class="col-md-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection