@extends('layouts.app')

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

    <div class="row">
        {{-- <div class="col"> --}}
            <div class="col-6 dropright">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter
                </button>
                <form method="POST" action="{{ route('user.filter') }}" class="dropdown-menu p-3">
                    @csrf
                    <label>Search</label>
                    <input name="search" type="text" class="form-control">

                    <p class="mt-3">Price Range</p>
                    <section class="range-slider">
                        <span class="rangeValues"></span>
                        <input name="price_start" value="{{ $min_rate }}" min="{{ $min_rate }}" max="{{ $max_rate }}" step="1" type="range">
                        <input name="price_end" value="{{ $max_rate }}" min="{{ $min_rate }}" max="{{ $max_rate }}" step="1" type="range">
                    </section>

                    <div class="mt-3">
                        @foreach ($used_categories as $category)
                            <div class="form-check">
                                @if (count($category) == 3)
                                    <input class="form-check-input" type="checkbox" value="{{ $category[0] }}" name="category[]" checked>
                                @else
                                    <input class="form-check-input" type="checkbox" value="{{ $category[0] }}" name="category[]">
                                @endif
                                <label class="form-check-label">
                                    {{ $category[1] }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        @foreach ($used_views as $view)
                            <div class="form-check">
                                @if (count($view) == 3)
                                    <input class="form-check-input" type="checkbox" value="{{ $view[0] }}" name="view[]" checked>
                                @else
                                    <input class="form-check-input" type="checkbox" value="{{ $view[0] }}" name="view[]">
                                @endif
                                <label class="form-check-label">
                                    {{ $view[1] }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
        {{-- </div> --}}
    </div>

    <div class="row-auto">
        <div class="col">
            <table class="table table-striped table-bordered mt-3">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Number</th>
                        <th scope="col">Description</th>
                        <th scope="col">Category</th>
                        <th scope="col">View</th>
                        <th scope="col">Hourly Rate, $</th>
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
                            <td>{{ $room->rate }}</td>
                            <td class="table-buttons">
                                <a href="{{ route('user.show', $room->id) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                {{-- <a href="{{ route('user.reserve'), $room->id}}" class="btn btn-primary"><i class="fa fa-bed" aria-hidden="true"></i></a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
