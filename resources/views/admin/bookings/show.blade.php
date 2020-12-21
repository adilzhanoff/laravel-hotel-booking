@extends('layouts.admin-app')

@section('title', 'Booking '.$booking->id)

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
                        <h5>Booking Info</h5>
                    </div>
                    <div class="card-body">
                            <div class="form-group">
                                <label>ID</label>
                                <input type="text" name="number" value="{{ $booking->id }}" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>User ID</label>
                                <input type="text" name="number" value="{{ $booking->user_id }}" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Room ID</label>
                                <input type="text" name="number" value="{{ $booking->room_id }}" class="form-control" disabled>
                            </div>
                            <label class="mb-2">Start</label>
                            <div class="input-group mb-4">
                                <input class="form-control" type="datetime-local" name="start" value="{{ join('T', explode(' ', $booking->start)) }}" disabled>
                            </div>
                            <label class="mb-2">Finish</label>
                            <div class="input-group mb-4">
                                <input class="form-control" type="datetime-local" name="finish" value="{{ join('T', explode(' ', $booking->finish)) }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Hours</label>
                                <input type="text" name="number" value="{{ $booking->hours }}" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Total Price</label>
                                <input type="text" name="number" value="{{ $booking->total_price }}" class="form-control" disabled>
                            </div>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary"><i class="fa fa-backward" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection