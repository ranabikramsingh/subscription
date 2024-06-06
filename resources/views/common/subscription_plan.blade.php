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
        <main class="main subscription-main">
            <section class="subscription-plan-section">
        <div class="container">
            <div class="subscription-plan-wrapper">
                <div class="Page-heading-box subscription-heading-box">
                    <h2>Choose a plan right for you</h2>
                    <p>Get basic plan to optimize you lead generation process</p>
                </div>
                <div class="sub-main-wrapper">
                    @foreach($plans as $plan)
                    <x-subscription-plan-box :plan="$plan" />
                    @endforeach
                </div>
            </div>
        </div>
            <img src="{{ asset('assets/images/bg-shape.svg') }}" alt="" class="bg-shape">
            </section>
        </main>

    <!--JS-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.js"></script>
    <script src="{{ asset('assets/js/common-functions.js') }}"></script>
    <script src="{{ asset('assets/js/common-jquery.js') }}"></script>
    <script src="{{ asset('js/iziToast.js') }}"></script>
    @include('vendor.lara-izitoast.toast')
    @stack('js')

</body>
</html>
