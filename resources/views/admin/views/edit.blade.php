@extends('layouts.admin-app')

@section('title', 'View - '.$view->name)

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
                    <h5>{{ $view->name }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.views.update', $view) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ $view->name }}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary mr-4">Edit View</button>
                        <a href="{{ route('admin.views.index') }}" class="btn btn-primary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection