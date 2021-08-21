@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h3>Success!</h3>

    <div class="row">
        <div class="col-md-6">
            Order no. <br>
            Total
        </div>
        <div class="col-md-6">
            <div class="float-right">
                {{ $noOrder }} <br>
                Rp {{ $value }}
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md">
            {{ $productName }} that cost {{ $price }} will be shipped to : <br><br>
            {{ $shippingAddress }} <br><br>
            only after you pay. <br>
            {{ $createdAt }}

            <a href="{{ route('order.payPage', $noOrder) }}" class="btn btn-primary btn-lg btn-block mt-5">Pay now</a>
        </div>
    </div>
@endsection
