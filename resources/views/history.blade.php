@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h3>Order History</h3>

    <form action="{{ route('history') }}" method="get">
        <div class="form-group mt-3">
            <div class="input-group">
                <input id="search" class="form-control @error('search') is-invalid @enderror" name="search" value="" placeholder="Search by Order no." />

                @error('search')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </form>
    <div class="row mt-3">
        <div class="col-md-12">
            @foreach ($histories as $history)
            <hr>
                <div class="row">
                    <div class="col-md-10">
                        @if ($history->topup != null)
                            Rp {{ $history->value }} for <span>{{ $history->topup->mobile_number }}</span>
                        @elseif ($history->order != null)
                            {{ $history->order->product }} that costs <span>Rp {{ $history->order->price }}</span>
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if ($history->topup != null && $history->status == '1')
                            <span class="text-success">Success</span>
                        @elseif ($history->topup != null && $history->status == null)
                            <span class="text-warning">Failed</span>
                        @elseif ($history->order != null && $history->status == '1')
                            <span>shipping code {{ $history->shipping_code }}</span>
                        @elseif ($history->order != null && $history->status == '2')
                            <span class="text-danger">Canceled</span>
                        @elseif ($history->order != null && $history->status == null)
                            <a href="{{ route('order.payPage', $history->no_order) }}" class="btn btn-primary">Pay now</a>
                        @endif
                    </div>
                </div>
            @endforeach
            <hr>
        </div>
    </div>
    <div>
        {{ $histories->links('pagination::bootstrap-4') }}
    </div>
@endsection
