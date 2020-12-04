@extends('layouts.admin-app')

@section('title', 'Users Page')

@section('content')
<div style="margin-left: 130px; margin-right: 130px; margin-top: 30px; margin-bottom: 90px">
    <div class="row">
        <div class="col-md-9">
            @foreach($roles as $role)
                <a class="btn btn-primary mr-3" href="{{ route('admin.users.role', $role->id) }}">{{ $role->name }}</a>
            @endforeach
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
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach(collect($users)->sortBy('id') as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="table-buttons">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                        <form class="form-delete" action="{{ route('admin.users.destroy', $user) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this User?')" type="submit">
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
