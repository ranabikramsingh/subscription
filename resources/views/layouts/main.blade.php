<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon-pic.ico') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href={{ asset('assets/bundles/summernote/summernote-bs4.css') }}>
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/login-register.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link href="{{ asset('assets/css/iziToast.css') }}" rel="stylesheet">
    @stack('css')

</head>

<body>
    <div class="overlay"></div>
    <div class="main">
        <section class="dashboard-section">
            <div class="dashboard-wrapper">
               
                <div class="dashboard-content-wrapper">
                  
                    <div class="db-content-main">
                        @yield('content')
                    </div>
                </div>
            </div>

        </section>
    </div>
    @yield('editcontent')

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('assets/bundles/summernote/summernote-bs4.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/onscreen@1.4.0/dist/on-screen.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.js"></script>
    {{-- datetimepicker --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
    </script>
   
    {{-- ... your other scripts ... --}}
    <script src="{{ asset('assets/js/common-functions.js') }}"></script>
    <script src="{{ asset('assets/js/common-jquery.js') }}"></script>
    <script src="{{ asset('assets/bundles/upload-preview/jquery.uploadPreview.min.js') }}"></script>
    {{-- for sweet message  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" type="text/javascript"></script> --}}
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ asset('assets/js/iziToast.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/onscreen/dist/on-screen.umd.min.js"></script>
    {{-- <script src= "{{asset('assets/lib/index.js')}}"></script> --}}    
    <script>
        $(function() {
            //toggle two classes on button element
            $('.open-sidebar').on('click', function() {
                $('.dashboard-sidebar').addClass('clicked');
            });
            $('.close-dashboard').on('click', function() {
                $('.dashboard-sidebar').removeClass('clicked');
            });
        });
    </script>


    <script>
        // This assumes you want to target the third <li> element, change color on its <a> tag when clicked
        $(document).ready(function() {
            $('.dashboard-link-list li:nth-child(3) a').on('click', function() {
                $(this).css('background', '#fff');

            });
            $('#completed-order-tab').on('click', function() {
                $(this).find('i:first').removeClass('fa-circle');
                $(this).find('i:first').addClass('fa-circle-dot');
                $('#active-order-tab').find('i:first').removeClass('fa-circle-dot');
                $('#active-order-tab').find('i:first').addClass('fa-circle');


            })
            $('#active-order-tab').on('click', function() {
                $(this).find('i:first').removeClass('fa-circle');
                $(this).find('i:first').addClass('fa-circle-dot');
                $('#completed-order-tab').find('i:first').removeClass('fa-circle-dot');
                $('#completed-order-tab').find('i:first').addClass('fa-circle');

            })
        });
    </script>
    {{-- @include('vendor.lara-izitoast.toast') --}}
    @yield('scripts')
    @stack('js')

</body>

</html>
