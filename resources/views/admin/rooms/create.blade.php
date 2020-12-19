@extends('layouts.admin-app')

@section('title', 'Add Room')

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
                    <form method="POST" action="{{ route('admin.rooms.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Number</label>
                            <input type="text" name="number" value="{{ old('name') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>View</label>
                            <select name="view_id" class="form-control">
                                @foreach($views as $view)
                                    <option value="{{ $view->id }}">{{ $view->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="mb-2">Hourly Rate</label>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input type="number" name="rate" value="{{ old('rate') }}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary"><i class="fa fa-backward" aria-hidden="true"></i></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection