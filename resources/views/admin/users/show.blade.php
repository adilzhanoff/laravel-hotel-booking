@extends('layouts.admin-app')

@section('title', 'User - '.$user->name)

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
                    <h5>{{ $user->name }}</h5>
                </div>
                <div class="card-body">
                        <div class="row form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $user->name }}" name="name" class="form-control" disabled>
                        </div>
                        <div class="row form-group">
                            <label>Email address</label>
                            <input type="email" value="{{ $user->email }}" name="email" class="form-control" disabled>
                        </div>
                        <div class="row form-group">
                            <label>Role</label>
                            <input type="text" value="{{ $user->role->name }}" name="role" class="form-control" disabled>
                        </div>
                        <?php
                            $room_ids = array();
                        ?>
                        <div class="row mt-3 mb-2">
                            @foreach ($rooms as $room)
                                <?php
                                    array_push($room_ids, $room->pivot->room_id);
                                ?>
                                <div class="col-auto form-check">
                                    <input type="checkbox" class="form-check-input" name="rooms[]" value="{{ $room->number }}" checked disabled>
                                    <label class="form-check-label">{{ $room->number }}</label>
                                </div>
                            @endforeach
                            @foreach ($all_rooms as $room)
                                @if (!in_array($room->id, $room_ids))
                                    <div class="col-auto form-check">
                                        <input type="checkbox" class="form-check-input" name="rooms[]" value="{{ $room->number }}" disabled>
                                        <label class="form-check-label">{{ $room->number }}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary mt-2">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection