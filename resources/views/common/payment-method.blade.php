<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fuel-delivery @yield('title', 'Subscription')</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon-pic.ico') }}">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">


    </head>
<body>

    <div class="overlay"></div>
    <main class="main">
        <section class="payment-method-section">
    <div class="container">
        <div class="payment-method-wrapper">
            <div class="Page-heading-box">
                <h2>Payment Method</h2>
                <p>Experience the future of payments: simple, secure, and smart.</p>
            </div>
            <div class="payment-method-box card-element">
                {{-- <x-alert/> --}}
                <div class="payment-type">
                    {{-- <a href="#" class="payment-type-tab active">Credit card</a> --}}
                    {{-- <a href="#" class="payment-type-tab">Debit card</a> --}}
                    <a href="#" class="stripe-btn">Powered by <img src="{{ asset('assets/images/stripe-logo.svg') }}" alt=""></a>
                </div>

                <div id="cardError"></div>

                <form action="{{ !is_null($type) ? route('subscriptions.upgrade', ['plan' => $plan->id]) : route('subscriptions.subscribe', ['subscription' => $plan->id]) }}" method="post" id="buySubscriptionForm">
                    {{-- <form action="{{ route('subscription.subscribe', ['subscription' => $plan->id]) }}" method="post" id="buySubscriptionForm"> --}}
                    @csrf
                <div class="payment-method-form">
                    {{-- <div  id="card-element"  class="form-group">
                        <label>Card number</label>
                        <div class="formfield" id="cardNumberElement">
                            <input type="text" class="form-control" name="card_number" placeholder="Card number">
                            <span class="form-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="20" viewBox="0 0 27 20" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.702148 2.8221V16.6402C0.702148 17.3277 0.975116 17.9866 1.46131 18.472C1.94671 18.9581 2.60564 19.2311 3.29305 19.2311H24.0202C24.7077 19.2311 25.3666 18.9582 25.852 18.472C26.3381 17.9866 26.6111 17.3276 26.6111 16.6402V2.8221C26.6111 2.13465 26.3382 1.47577 25.852 0.990359C25.3666 0.504178 24.7076 0.231201 24.0202 0.231201H3.29305C2.60559 0.231201 1.94672 0.504168 1.46131 0.990359C0.975126 1.47577 0.702148 2.1347 0.702148 2.8221ZM24.8839 8.86753V16.6402C24.8839 16.869 24.7933 17.0894 24.6307 17.2507C24.4692 17.4131 24.2491 17.5038 24.0202 17.5038H3.29305C3.06423 17.5038 2.84388 17.4132 2.68254 17.2507C2.52022 17.0892 2.42942 16.869 2.42942 16.6402V8.86753H24.8839ZM24.8839 3.68573H2.42941V2.8221C2.42941 2.59328 2.52002 2.37293 2.68253 2.21158C2.84407 2.04927 3.06422 1.95847 3.29304 1.95847H24.0202C24.249 1.95847 24.4694 2.04907 24.6307 2.21158C24.7931 2.37313 24.8839 2.59328 24.8839 2.8221L24.8839 3.68573Z" fill="#BDBDBD"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.88414 12.322H13.6568C14.1336 12.322 14.5205 11.9351 14.5205 11.4584C14.5205 10.9816 14.1336 10.5947 13.6568 10.5947H5.88414C5.40741 10.5947 5.02051 10.9816 5.02051 11.4584C5.02051 11.9351 5.40741 12.322 5.88414 12.322Z" fill="#BDBDBD"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M21.4369 14.1841C21.6337 13.9717 21.9161 13.8379 22.2288 13.8379C22.8247 13.8379 23.3084 14.3223 23.3084 14.9174C23.3084 15.5133 22.8247 15.997 22.2288 15.997C21.9161 15.997 21.6337 15.864 21.4369 15.6515C21.2401 15.864 20.9577 15.997 20.645 15.997C20.0491 15.997 19.5654 15.5133 19.5654 14.9174C19.5654 14.3223 20.0491 13.8379 20.645 13.8379C20.9576 13.8379 21.2401 13.9717 21.4369 14.1841Z" fill="#BDBDBD"></path>
                                </svg>
                            </span>
                        </div>
                    </div> --}}
                    <div class="form-group" style="position: relative;">
                        <label for="cardNumberElement">Card Number</label>
                        <div class="formfield">
                        <div id="cardNumberElement" class="form-control" style="position: relative;"></div>
                        <span class="form-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="20" viewBox="0 0 27 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.702148 2.8221V16.6402C0.702148 17.3277 0.975116 17.9866 1.46131 18.472C1.94671 18.9581 2.60564 19.2311 3.29305 19.2311H24.0202C24.7077 19.2311 25.3666 18.9582 25.852 18.472C26.3381 17.9866 26.6111 17.3276 26.6111 16.6402V2.8221C26.6111 2.13465 26.3382 1.47577 25.852 0.990359C25.3666 0.504178 24.7076 0.231201 24.0202 0.231201H3.29305C2.60559 0.231201 1.94672 0.504168 1.46131 0.990359C0.975126 1.47577 0.702148 2.1347 0.702148 2.8221ZM24.8839 8.86753V16.6402C24.8839 16.869 24.7933 17.0894 24.6307 17.2507C24.4692 17.4131 24.2491 17.5038 24.0202 17.5038H3.29305C3.06423 17.5038 2.84388 17.4132 2.68254 17.2507C2.52022 17.0892 2.42942 16.869 2.42942 16.6402V8.86753H24.8839ZM24.8839 3.68573H2.42941V2.8221C2.42941 2.59328 2.52002 2.37293 2.68253 2.21158C2.84407 2.04927 3.06422 1.95847 3.29304 1.95847H24.0202C24.249 1.95847 24.4694 2.04907 24.6307 2.21158C24.7931 2.37313 24.8839 2.59328 24.8839 2.8221L24.8839 3.68573Z" fill="#BDBDBD"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.88414 12.322H13.6568C14.1336 12.322 14.5205 11.9351 14.5205 11.4584C14.5205 10.9816 14.1336 10.5947 13.6568 10.5947H5.88414C5.40741 10.5947 5.02051 10.9816 5.02051 11.4584C5.02051 11.9351 5.40741 12.322 5.88414 12.322Z" fill="#BDBDBD"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.4369 14.1841C21.6337 13.9717 21.9161 13.8379 22.2288 13.8379C22.8247 13.8379 23.3084 14.3223 23.3084 14.9174C23.3084 15.5133 22.8247 15.997 22.2288 15.997C21.9161 15.997 21.6337 15.864 21.4369 15.6515C21.2401 15.864 20.9577 15.997 20.645 15.997C20.0491 15.997 19.5654 15.5133 19.5654 14.9174C19.5654 14.3223 20.0491 13.8379 20.645 13.8379C20.9576 13.8379 21.2401 13.9717 21.4369 14.1841Z" fill="#BDBDBD"></path>
                            </svg>
                        </span>
                    </div>
                    </div>


                    {{--  --}}
                    <div class="form-group">
                        <label>Card Holder name</label>
                        <div class="formfield">
                            <input type="text" class="form-control" id="cardHolderName" value="{{ $stripeCustomer && $stripeCustomer->name ? $stripeCustomer->name : $authUser->first_name }}" name="card_holder_name" placeholder="Card Holder name">
                            <span class="form-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="20" viewBox="0 0 27 20" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.702148 2.8221V16.6402C0.702148 17.3277 0.975116 17.9866 1.46131 18.472C1.94671 18.9581 2.60564 19.2311 3.29305 19.2311H24.0202C24.7077 19.2311 25.3666 18.9582 25.852 18.472C26.3381 17.9866 26.6111 17.3276 26.6111 16.6402V2.8221C26.6111 2.13465 26.3382 1.47577 25.852 0.990359C25.3666 0.504178 24.7076 0.231201 24.0202 0.231201H3.29305C2.60559 0.231201 1.94672 0.504168 1.46131 0.990359C0.975126 1.47577 0.702148 2.1347 0.702148 2.8221ZM24.8839 8.86753V16.6402C24.8839 16.869 24.7933 17.0894 24.6307 17.2507C24.4692 17.4131 24.2491 17.5038 24.0202 17.5038H3.29305C3.06423 17.5038 2.84388 17.4132 2.68254 17.2507C2.52022 17.0892 2.42942 16.869 2.42942 16.6402V8.86753H24.8839ZM24.8839 3.68573H2.42941V2.8221C2.42941 2.59328 2.52002 2.37293 2.68253 2.21158C2.84407 2.04927 3.06422 1.95847 3.29304 1.95847H24.0202C24.249 1.95847 24.4694 2.04907 24.6307 2.21158C24.7931 2.37313 24.8839 2.59328 24.8839 2.8221L24.8839 3.68573Z" fill="#BDBDBD"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.88414 12.322H13.6568C14.1336 12.322 14.5205 11.9351 14.5205 11.4584C14.5205 10.9816 14.1336 10.5947 13.6568 10.5947H5.88414C5.40741 10.5947 5.02051 10.9816 5.02051 11.4584C5.02051 11.9351 5.40741 12.322 5.88414 12.322Z" fill="#BDBDBD"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M21.4369 14.1841C21.6337 13.9717 21.9161 13.8379 22.2288 13.8379C22.8247 13.8379 23.3084 14.3223 23.3084 14.9174C23.3084 15.5133 22.8247 15.997 22.2288 15.997C21.9161 15.997 21.6337 15.864 21.4369 15.6515C21.2401 15.864 20.9577 15.997 20.645 15.997C20.0491 15.997 19.5654 15.5133 19.5654 14.9174C19.5654 14.3223 20.0491 13.8379 20.645 13.8379C20.9576 13.8379 21.2401 13.9717 21.4369 14.1841Z" fill="#BDBDBD"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label>Card Expiry</label>
                        <div   id="cardExpiryElement"  class="formfield">
                            <input type="text" class="form-control" name="dob" placeholder="Date of Birth">
                            <span class="form-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17" viewBox="0 0 19 17" fill="none">
                                    <path d="M17.146 0.231204H15.6147V0.666904C15.6147 1.14568 15.3594 1.58811 14.9448 1.82751C14.53 2.0669 14.0191 2.0669 13.6045 1.82751C13.1899 1.58811 12.9346 1.14569 12.9346 0.666904V0.231427L6.61893 0.231203V0.666904C6.61893 1.14568 6.36362 1.58811 5.949 1.82751C5.53416 2.0669 5.02331 2.0669 4.60869 1.82751C4.19407 1.58811 3.93876 1.14569 3.93876 0.666904V0.231427L2.35055 0.231203C1.91372 0.23053 1.49441 0.403286 1.18524 0.712002C0.876075 1.02049 0.702194 1.4396 0.702194 1.87639V4.34905H18.7944V1.87639C18.7944 1.43957 18.6205 1.02049 18.3114 0.712002C18.0022 0.403286 17.5828 0.230531 17.1461 0.231203L17.146 0.231204ZM0.702148 5.68914V15.1442C0.702148 15.581 0.876023 15.9999 1.18519 16.3086C1.49436 16.6171 1.91371 16.79 2.3505 16.7892H17.1459C17.5827 16.79 18.002 16.6171 18.3112 16.3086C18.6204 15.9999 18.7943 15.581 18.7943 15.1442V5.68914H0.702148Z" fill="#BDBDBD"></path>
                                </svg>
                            </span>
                        </div>
                    </div> --}}
                    <div class="form-group" style="position: relative;">
                        <label for="cardExpiryElement">Card Expiry</label>
                        <div class="formfield">
                            <div id="cardExpiryElement" class="form-control" style="position: relative;"></div>
                            <span class="form-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17" viewBox="0 0 19 17" fill="none">
                                    <path d="M17.146 0.231204H15.6147V0.666904C15.6147 1.14568 15.3594 1.58811 14.9448 1.82751C14.53 2.0669 14.0191 2.0669 13.6045 1.82751C13.1899 1.58811 12.9346 1.14569 12.9346 0.666904V0.231427L6.61893 0.231203V0.666904C6.61893 1.14568 6.36362 1.58811 5.949 1.82751C5.53416 2.0669 5.02331 2.0669 4.60869 1.82751C4.19407 1.58811 3.93876 1.14569 3.93876 0.666904V0.231427L2.35055 0.231203C1.91372 0.23053 1.49441 0.403286 1.18524 0.712002C0.876075 1.02049 0.702194 1.4396 0.702194 1.87639V4.34905H18.7944V1.87639C18.7944 1.43957 18.6205 1.02049 18.3114 0.712002C18.0022 0.403286 17.5828 0.230531 17.1461 0.231203L17.146 0.231204ZM0.702148 5.68914V15.1442C0.702148 15.581 0.876023 15.9999 1.18519 16.3086C1.49436 16.6171 1.91371 16.79 2.3505 16.7892H17.1459C17.5827 16.79 18.002 16.6171 18.3112 16.3086C18.6204 15.9999 18.7943 15.581 18.7943 15.1442V5.68914H0.702148Z" fill="#BDBDBD"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    {{--  --}}
                        <div  class="form-group" style="position: relative;">
                            <label>CVV</label>
                            <div class="formfield">
                                <div id="cardCVCElement" class="formfield" style="position: relative;">
                                </div>
                                <span class="form-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="20" viewBox="0 0 27 20" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.702148 2.8221V16.6402C0.702148 17.3277 0.975116 17.9866 1.46131 18.472C1.94671 18.9581 2.60564 19.2311 3.29305 19.2311H24.0202C24.7077 19.2311 25.3666 18.9582 25.852 18.472C26.3381 17.9866 26.6111 17.3276 26.6111 16.6402V2.8221C26.6111 2.13465 26.3382 1.47577 25.852 0.990359C25.3666 0.504178 24.7076 0.231201 24.0202 0.231201H3.29305C2.60559 0.231201 1.94672 0.504168 1.46131 0.990359C0.975126 1.47577 0.702148 2.1347 0.702148 2.8221ZM24.8839 8.86753V16.6402C24.8839 16.869 24.7933 17.0894 24.6307 17.2507C24.4692 17.4131 24.2491 17.5038 24.0202 17.5038H3.29305C3.06423 17.5038 2.84388 17.4132 2.68254 17.2507C2.52022 17.0892 2.42942 16.869 2.42942 16.6402V8.86753H24.8839ZM24.8839 3.68573H2.42941V2.8221C2.42941 2.59328 2.52002 2.37293 2.68253 2.21158C2.84407 2.04927 3.06422 1.95847 3.29304 1.95847H24.0202C24.249 1.95847 24.4694 2.04907 24.6307 2.21158C24.7931 2.37313 24.8839 2.59328 24.8839 2.8221L24.8839 3.68573Z" fill="#BDBDBD"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.88414 12.322H13.6568C14.1336 12.322 14.5205 11.9351 14.5205 11.4584C14.5205 10.9816 14.1336 10.5947 13.6568 10.5947H5.88414C5.40741 10.5947 5.02051 10.9816 5.02051 11.4584C5.02051 11.9351 5.40741 12.322 5.88414 12.322Z" fill="#BDBDBD"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.4369 14.1841C21.6337 13.9717 21.9161 13.8379 22.2288 13.8379C22.8247 13.8379 23.3084 14.3223 23.3084 14.9174C23.3084 15.5133 22.8247 15.997 22.2288 15.997C21.9161 15.997 21.6337 15.864 21.4369 15.6515C21.2401 15.864 20.9577 15.997 20.645 15.997C20.0491 15.997 19.5654 15.5133 19.5654 14.9174C19.5654 14.3223 20.0491 13.8379 20.645 13.8379C20.9576 13.8379 21.2401 13.9717 21.4369 14.1841Z" fill="#BDBDBD"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                </div>
                <div class="pay-met-btn-bx">
                    <a href="" class="button outline-btn">Back</a>
                    <button  id="payButton"  type="submit" data-secret="{{ $intent->client_secret }}"  class="button black-btn">{{ (request()->has('type') &&  request()['type'] == 'upgrade') ? 'Upgrade' : 'Next' }}</button>
                </div>
            </form>
            </div>
        </div>
    </div>
        </section>

    </main>

    <!--JS-->

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!--JS-->
    @include('common.js_buy_plan')

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.js"></script>
    <script src="{{ asset('assets/js/common-functions.js') }}"></script>
    <script src="{{ asset('assets/js/common-jquery.js') }}"></script>
    <script src="{{ asset('js/iziToast.js') }}"></script>
    {{-- @include('vendor.lara-izitoast.toast') --}}


</body>
</html>
