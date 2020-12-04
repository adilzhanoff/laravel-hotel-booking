@extends('layouts.app')

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
                        <button type="submit" class="btn btn-primary mr-4">Add Room</button>
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection