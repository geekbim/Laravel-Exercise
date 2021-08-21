@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h3>Prepaid Balance</h3>

    <form action="{{ route('topup.store') }}" method="post">
        @csrf
        <div class="form-group mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">081</span>
                </div>
                <input id="mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" 
                value="@if($user->mobile_number != null){{ substr($user->mobile_number, 3) }}@endif" 
                placeholder="Mobile Number" required autofocus>

                @error('mobile_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <select name="value" id="value" class="form-control @error('value') is-invalid @enderror" required>
                    <option value="10000">10.000</option>
                    <option value="25000">25.000</option>
                    <option value="50000">50.000</option>
                    <option value="75000">75.000</option>
                    <option value="100000">100.000</option>
                </select>

                @error('value')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block mt-5">Submit</button>
    </form>
@endsection
