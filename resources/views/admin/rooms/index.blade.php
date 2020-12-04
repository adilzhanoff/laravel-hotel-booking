@extends('layouts.admin-app')

@section('title', 'Rooms Page')

@section('content')
<div style="margin-left: 130px; margin-right: 130px; margin-top: 30px; margin-bottom: 90px">
    <div class="row justify-content-between">
        {{-- <form class="col-md-3" action="{{ route('rooms.user') }}" method="get">
            @csrf
            <div class="form-group">
                <label>Filter</label>
                <select class="form-control">
                    @foreach($users as $user)
                        <option name="user" value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary" type="submit">Apply</button>
        </form> --}}

        {{-- <div class="col-md-9">
            @foreach($users as $user)
                <a class="btn btn-primary mr-3" href="{{ route('rooms.user', $user->id) }}">{{ $user->name }}</a>
            @endforeach
        </div> --}}
        <div class="col-md-3 align-self-end">
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Add Room</a>
        </div>
    </div>
    <br>
    {{-- <div class="dropdown">
        <a class="btn btn-primary dropdown-toggle" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filter
        </a>
      
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <form action="{{ route('users.filter', $role->id) }}">
                @csrf
                <div class="col">
                    <div class="form-check dropdown-item">
                        <input class="form-check-input" type="radio" name="role_radio" value="option1" checked>
                        <label class="form-check-label">
                            Admin
                        </label>
                    </div>
                    <div class="form-check dropdown-item">
                        <input class="form-check-input" type="radio" name="role_radio" value="option2">
                        <label class="form-check-label">
                            Guest
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-check dropdown-item">
                        <input class="form-check-input" type="radio" name="order_radio" value="option3" checked>
                        <label class="form-check-label">
                            Ascending
                        </label>
                    </div>
                    <div class="form-check dropdown-item">
                        <input class="form-check-input" type="radio" name="order_radio" value="option4">
                        <label class="form-check-label">
                            Descending
                        </label>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-item">
                    <button type="submit" class="col btn btn-primary">Apply</button>
                </div>
            </form>
        </div>
    </div> --}}

    @if (session()->get('success'))
        <div class="alert alert-success mt-3">
            {{ session()->get('success') }}
            <button type="button" class="ml-1 close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Number</th>
                <th scope="col">Description</th>
                <th scope="col">Category</th>
                <th scope="col">View</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach(collect($rooms)->sortBy('id') as $room)
                <tr>
                    <th scope="row">{{ $room->id }}</th>
                    <td>{{ $room->number }}</td>
                    <td>{{ $room->description }}</td>
                    <td>{{ $categories->where('id', $room->category_id)->first()->name }}</td>
                    <td>{{ $views->where('id', $room->view_id)->first()->name }}</td>
                    <td class="table-buttons">
                        <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
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
@endsection
