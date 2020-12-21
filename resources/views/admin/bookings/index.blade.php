@extends('layouts.admin-app')

@section('title', 'Bookings Page')

@section('content')
    <div class="container" style="margin-left: 130px; margin-right: 130px; margin-top: 30px; margin-bottom: 90px">
        <div class="row">
            @if (session()->get('success'))
                <div class="alert alert-success mt-3">
                    {{ session()->get('success') }}
                    <button type="button" class="ml-1 close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

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
                    {{-- {{ dd($bookings) }} --}}
                    @foreach($bookings as $booking)
                        <tr>
                            <th scope="row">{{ $booking->id }}</th>
                            <td>{{ $booking->user_id }}</td>
                            <td>{{ $booking->room_id }}</td>
                            <td>{{ $booking->start }}</td>
                            <td>{{ $booking->finish }}</td>
                            <td>{{ $booking->hours }}</td>
                            <td>{{ $booking->total_price }}</td>
                            <td class="table-buttons">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                <form class="form-delete" action="{{ route('admin.bookings.destroy', $booking->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this booking?')" type="submit">
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
@endsection