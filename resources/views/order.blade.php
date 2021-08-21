@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h3>Product Page</h3>

    <form action="{{ route('order.store') }}" method="post">
        @csrf
        <div class="form-group mt-3">
            <div class="input-group">
                <textarea id="product" class="form-control @error('product') is-invalid @enderror" name="product" value="" placeholder="Product" required autofocus></textarea>

                @error('product')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <textarea id="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" value="" placeholder="Shipping Address" required></textarea>

                @error('shipping_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group mt-3">
            <div class="input-group">
                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="" placeholder="Price" required></textarea>

                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
    </form>
@endsection
