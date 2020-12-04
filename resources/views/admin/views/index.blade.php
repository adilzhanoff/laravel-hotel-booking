@extends('layouts.admin-app')

@section('title', 'Views Page')

@section('content')
<div style="margin-left: 130px; margin-right: 130px; margin-top: 30px; margin-bottom: 90px">
    <div class="row justify-content-between">
        <div class="col-md-3 align-self-end">
            <a href="{{ route('admin.views.create') }}" class="btn btn-primary">Add View</a>
        </div>
    </div>

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
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach(collect($views)->sortBy('id') as $view)
                <tr>
                    <th scope="row">{{ $view->id }}</th>
                    <td>{{ $view->name }}</td>
                    <td class="table-buttons">
                        <a href="{{ route('admin.views.show', $view) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('admin.views.edit', $view) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                        <form class="form-delete" action="{{ route('admin.views.destroy', $view) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this View?')" type="submit">
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
