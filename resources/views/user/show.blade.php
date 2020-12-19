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

            @if (session()->get('info'))
                <div class="alert alert-info">
                    {{ session()->get('info') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="col-12">
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input type="number" name="rate" value="{{ $room->rate }}" class="form-control" disabled>
                        </div>
                        <a href="{{ route('user.index') }}" class="btn btn-primary"><i class="fa fa-backward" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Set the dates</h5>
                    </div>
                    <form action="{{ route('user.book', $room->id) }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="card-body">
                            <label class="mb-2">Start</label>
                            <div class="input-group mb-4">
                                <input class="form-control" type="datetime-local" name="start" value="{{ date('Y-m-d').'T'.date('H:i:s') }}" min="{{ date('Y-m-d').'T'.date('H:i:s') }}">
                            </div>
                            <label class="mb-2">Finish</label>
                            <div class="input-group mb-4">
                                <input class="form-control" type="datetime-local" name="finish" value="{{ substr(date(DATE_ATOM, strtotime('+1 hour', strtotime(date('Y-m-d H:i:s')))), 0, -6) }}" min="{{ substr(date(DATE_ATOM, strtotime('+1 hour', strtotime(date('Y-m-d H:i:s')))), 0, -6) }}">
                            </div>
                            <div class="input-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-book" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection