@extends('shop')

@section('content')

    <div class="card border-info">
        <div class="card-header bg-info text-white">
            <h5>Check Your Total</h5>
        </div>
        <div class="card-body">
            <!--h1 class="card-title">Checkout</h1-->
            <h4 class="card-text">Your Total Is: ${{ $cartTotal }}</h4>
            <!-- Add more checkout information and forms as needed -->
        </div>
        <div class="card-footer  text-muted text-center">
            <b>Thank you for shopping with us!</b>
        </div>
    </div>
    <br>
    <td colspan="5" class="text-right">
        <a href="{{ url('/dashboard') }}" class="btn btn-dark btn-sm"><i class="fa fa-angle-left"></i> Continue Shopping</a>
    </td>

@endsection
