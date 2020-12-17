@extends('layouts.app')

@section('title', 'Rooms Page')

@section('content')
    <div style="margin-left: 130px; margin-right: 130px; margin-top: 30px; margin-bottom: 90px">
        @if (session()->get('success'))
            <div class="col-5 alert alert-success mt-3">
                {{ session()->get('success') }}
                <button type="button" class="ml-1 close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row justify-content-between">
            <div class="card" style="width: 24.5rem;">
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.balance.update', $user->id) }}" class="mb-3">
                            @csrf
                            @method('PUT')
                            <h5 class="card-title">Current Balance</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $user->name }}</h6>
                            @if ($user->balance == 0)
                                <h5 class="card-text mb-3">0.00 $</h5>
                            @else
                                <h5 class="card-text mb-3">{{ $user->balance }} $</h5>
                            @endif
                            <label>+</label>
                            <input class="col-md-5 mb-3" type="number" name="balance" value="0.00" step="0.01" min="0">
                            <div class="row-auto mb-2">
                                <button type="submit" class="btn btn-primary mr-2">Update the balance</button>
                            </div>
                        </form>
                        <div class="btn-group">
                            <form action="{{ route('user.balance.reset', $user->id) }}" method="post" class="mr-2">
                                @csrf
                                <button type="submit" class="btn btn-primary">Reset</button>
                            </form>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('user.index', $user->id) }}" class="btn btn-primary mr-2">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection