@extends('templates.app')

@section('content')

    {!! Form::open(['url' => route('order.post'), 'data-parsley-validate', 'id' => 'payment-form']) !!}
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Shipping address</h3>
                         
                        <hr>
                        <div class="form-group" id="address">
                            {!! Form::label(null, 'Address:') !!}
                            {!! Form::text(null, null, [
                                'class' =>  'form-control',
                                'required'  =>  'required',
                                'data-parsley-trigger' => 'change focusout',
                                'data-parsley-class-handler'    => '#address'

                            ]) !!}
                        </div>
                        <div class="form-group" id="city">
                            {!! Form::label(null, 'City:') !!}
                            {!! Form::text(null, null, [
                                'class' =>  'form-control',
                                'required'  =>  'required',
                                'data-parsley-trigger' => 'change focusout',
                                'data-parsley-class-handler'    => '#city'

                            ]) !!}
                        </div>
                        <div class="form-group" id="postal_code">
                            {!! Form::label(null, 'Postal Code:') !!}
                            {!! Form::text(null, null, [
                                'class' =>  'form-control',
                                'required'  =>  'required',
                                'data-parsley-trigger'  => 'change focusout',
                                'data-parsley-class-handler'    => '#postal_code'

                            ]) !!}
                        </div>
                    </div>   
                </div>

                <h3>Payment</h3>
                <hr>

                <div id="payment"></div>

                <div class="form-group" id="cc-group">
                {!! Form::label(null, 'Credit card number:') !!}
                {!! Form::text(null, null, [
                        'class'                         => 'form-control',
                        'required'                      => 'required',
                        'data-stripe'                   => 'number',
                        'data-parsley-type'             => 'number',
                        'maxlength'                     => '16',
                        'data-parsley-trigger'          => 'change focusout',
                        'data-parsley-class-handler'    => '#cc-group'
                    ]) !!}
            </div>

            <div class="form-group" id="ccv-group">
                {!! Form::label(null, 'Card Validation Code (3 or 4 digit number):') !!}
                {!! Form::text(null, null, [
                        'class'                         => 'form-control',
                        'required'                      => 'required',
                        'data-stripe'                   => 'cvc',
                        'data-parsley-type'             => 'number',
                        'data-parsley-trigger'          => 'change focusout',
                        'maxlength'                     => '4',
                        'data-parsley-class-handler'    => '#ccv-group'
                    ]) !!}
            </div>

            <div class="row">
                <div class="col-md-4">
                     <div class="form-group" id="exp-m-group">
                        {!! Form::label(null, 'Ex. Month') !!}
                        {!! Form::selectMonth(null, null, [
                            'class'                 => 'form-control',
                            'required'              => 'required',
                            'data-stripe'           => 'exp-month'
                        ], '%m') !!}
                    </div>
                </div>
                <div class="col-md-4">
                     <div class="form-group" id="exp-y-group">
                        {!! Form::label(null, 'Ex. Year') !!}
                        {!! Form::selectYear(null, date('Y'), date('Y') + 10, null, [
                                'class'             => 'form-control',
                                'required'          => 'required',
                                'data-stripe'       => 'exp-year'
                            ]) !!}
                    </div>
                </div>
            </div>
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
        </div>
        {{ csrf_field() }}
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
        Stripe.setPublishableKey('{!! env('STRIPE_PK') !!}');

        jQuery(function($) {
            $('#payment-form').submit(function(event) {
                var $form = $(this);

                $form.parsley().subscribe('parsley:form:validate', function(formInstance) {
                    formInstance.submitEvent.preventDefault();
                    return false;
                });

                $form.find('#submitBtn').prop('disabled', true);

                Stripe.card.createToken($form, stripeResponseHandler);

                return false;
            });
        });

        function stripeResponseHandler(status, response) {
            var $form = $('#payment-form');

            if(response.error) {
                $form.find('.payment-errors').text(response.error.message);
                $form.find('.payment-errors').addClass('alert alert-danger');
                $form.find('#submitBtn').prop('disabled', false);
                $('#submitBtn').button('reset');
            } else {
                var token = response.id;

                $form.append($('<input type="hidden" name="stripeToken" />').val(token));

                $form.get(0).submit();
            }
        };
    </script>
@endsection