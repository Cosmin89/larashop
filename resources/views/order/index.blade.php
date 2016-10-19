@extends('templates.app')

@section('content')
     @if(Session::has('error'))
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <div id="charge-message" class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        </div>
    </div>
    @endif
    {!! Form::open(['route' => ['order.post'], 'data-parsley-validate', 'id' => 'payment-form']) !!}
    @if(count(Auth::user()->addresses) != 0)  
            @foreach(Auth::user()->addresses as $address)
             <p>
                <strong>Address: {{ $address->fullAddress() }}</strong>
                <input type="hidden" name="addressId" value="{{ $address->id }}">
            </p>
            @endforeach
    @else
    <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <h3>Shipping address</h3>
                    
                    <hr>
                    <div class="form-group" id="address_line1">
                        {!! Form::label(null, 'Address:') !!}
                        {!! Form::text('address', null, [
                            'class' =>  'form-control',
                            'required'  =>  'required',
                            'data-stripe'  => 'address_line1',
                            'data-parsley-trigger' => 'change focusout',
                            'data-parsley-class-handler'    => '#address_line1',

                        ]) !!}
                    </div>
                    <div class="form-group" id="address_city">
                        {!! Form::label(null, 'City:') !!}
                        {!! Form::text('city', null, [
                            'class' =>  'form-control',
                            'required'  =>  'required',
                            'data-stripe'  => 'address_city',
                            'data-parsley-trigger' => 'change focusout',
                            'data-parsley-class-handler'    => '#address_city',

                        ]) !!}
                    </div>
                    <div class="form-group" id="address_zip">
                        {!! Form::label(null, 'Postal Code:') !!}
                        {!! Form::text('postal_code', null, [
                            'class' =>  'form-control',
                            'required'  =>  'required',
                            'data-stripe'  => 'address_zip',
                            'data-parsley-trigger'  => 'change focusout',
                            'data-parsley-class-handler'    => '#address_zip',

                        ]) !!}
                    </div>
                </div>   
            </div>
            @endif      
            <hr>
            <h3>Payment</h3>
            @if(Auth::user()->cardType && Auth::user()->last4)
                    <p>
                        <strong>{{ Auth::user()->cardType }}</strong> | 
                        <strong>{{ Auth::user()->last4 }}</strong>
                    </p>
            @else
                <div id="dropin-container"></div>
            @endif
            
            </div>
            <div class="col-md-4">
                <div class="well">
                    <h4>Your order</h4>
                    <hr>

                    @include ('cart.partials.contents')
                    @include ('cart.partials.summary')

                    <div class="form-group">
                        {!! Form::submit('Place order!', ['class' => 'btn btn-primary btn-order', 'id' => 'submitBtn', 'style' => 'margin-bottom: 10px;']) !!}
                    </div>
                </div>
            </div>
    {!! Form::close() !!} 
@endsection

@section('scripts')
     <script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
            errorClass: 'has-error',
            successClass: 'has-success'
        };
    </script>

    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

     <script>
        // Stripe.setPublishableKey('{!! env('STRIPE_PK') !!}');

        // jQuery(function($) {
        //     $('#payment-form').submit(function(event) {
        //         var $form = $(this);

        //         $form.parsley().subscribe('parsley:form:validate', function(formInstance) {
        //             formInstance.submitEvent.preventDefault();
        //             return false;
        //         });

        //         $form.find('#submitBtn').prop('disabled', true);

        //         Stripe.card.createToken($form, stripeResponseHandler);

        //         return false;
        //     });
        // });

        // function stripeResponseHandler(status, response) {
        //     var $form = $('#payment-form');

        //     if(response.error) {
        //         $form.find('.payment-errors').text(response.error.message);
        //         $form.find('.payment-errors').addClass('alert alert-danger');
        //         $form.find('#submitBtn').prop('disabled', false);
        //         $('#submitBtn').button('reset');
        //     } else {
        //         var token = response.id;

        //         $form.append($('<input type="hidden" name="stripeToken" />').val(token));

        //         $form.get(0).submit();
        //     }
        // };
    </script>
    <script src="https://js.braintreegateway.com/js/braintree-2.29.0.min.js"></script>

        <script>
            $.ajax({
                url: '{{ route('braintree.token') }}'
            }).done(function(response) {
                braintree.setup(response.data.token, 'dropin', {
                    container: 'dropin-container',
                });
            });
        </script>
@endsection