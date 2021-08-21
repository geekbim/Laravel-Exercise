@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h3>Pay your order</h3>

    <form action="{{ route('order.pay', $noOrder) }}" method="post">
        @csrf
        <div class="form-group mt-3">
            <div class="input-group">
                <input id="no-order" class="form-control @error('noOrder') is-invalid @enderror" name="no_order" value="{{ $noOrder }}" placeholder="Order no." required autofocus />

                @error('noOrder')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block mt-5">Pay now</button>
    </form>
@endsection
