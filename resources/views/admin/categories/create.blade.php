@extends('layouts.admin-app')

@section('title', 'Add Category')

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
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary"><i class="fa fa-backward" aria-hidden="true"></i></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection