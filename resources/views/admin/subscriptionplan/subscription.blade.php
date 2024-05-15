@extends('layouts.main')
@section('title')
    Subscription Page
@endsection
@push('css')
@endpush

@section('content')
    <div class="db-heading-bx">
        <h2>Subscription Management</h2>
        <div class="right-db-head">
            
            <a href="#" type="button" class="button primary-btn" data-bs-toggle="modal"
                data-bs-target="#subscriptionModal"><i class="fa-solid fa-plus"></i>Add subscription
            </a>

        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-center" id="successAlert">
            {{ session('success') }}
        </div>
    @endif



    @if ($users->total() > 0)
        {{-- Display user data --}}
        <div class="db-table-box">
            <div class="tb-table subscriptionTable">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Month</th>
                            {{-- <th>Description</th> --}}
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $details)
                            <tr>

                                <td>
                                    <div class="table-data">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        {{ $details->name ?? 'NA' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="table-data">
                                        {{-- <i class="fa-solid fa-comments-dollar"></i> --}}
                                        <i class="fas fa-dollar-sign"></i>
                                        {{ $details->price ?? 'NA' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="table-data">
                                        {{-- <i class="fa fa-calendar" aria-hidden="true"></i> --}}
                                        <i class='far fa-calendar-alt'></i>
                                        {{ $details->interval ?? 'NA' }}

                                    </div>
                                </td>
                                {{-- <td>
                                    <div class="table-data">
                                        <i class="fa fa-file-text" aria-hidden="true"></i>
                                        {!! $details->description ?? 'NA' !!}

                                    </div>
                                </td> --}}

                                <td>
                                    <div class="table-data">
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" name="status" value="{{ $details->status ?? '1' }}" @if ($details->status == '1') checked @endif> --}}
                                            <input class="form-check-input switch-on" type="checkbox"
                                                data-model="SubscriptionPlan" data-id="{{ $details->secure_id }}"
                                                data-url="{{ route('users.status') }}"
                                                onchange="updateStatus(this,this.checked)" role="switch"
                                                id="flexSwitchCheckdishpacher" name="status" value="1"
                                                @if ($details->status) checked @endif>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <div class="table-data">
                                        <div class="table-data delete-user" data-bs-toggle="tooltip" data-bs-original-title="Delete" data-bs-placement="top">
                                            <i class="fa-solid fa-trash-can" data-model="SubscriptionPlan"
                                                data-id="{{ $details->secure_id }}" data-url="{{ route('users.delete') }}"
                                                onclick="Delete(this)" style="color: #FD5C5C;"></i>
                                        </div>
                                        
                                        {{-- <div class="table-data edit-user" >
                                            <i class="fa-solid fa-pencil"></i>
                                        </div> --}}
                                        <div class="table-data edit-user" data-subscription-id="{{ $details->id }}"  data-title="View order" data-bs-toggle="tooltip" data-bs-original-title="View" data-bs-placement="top">
                                            <i class="fa-solid fa-pencil" data-title="View order"></i>
                                        </div>

                                        {{-- <div class="table-data user-data" data-subscription-id="{{ $details->id }}"  data-title="View order" data-bs-toggle="tooltip" data-bs-original-title="View" data-bs-placement="top">
                                            <i class="fa fa-eye edit-record" data-title="View order"></i>
                                        </div> --}}

                                        {{-- <a href="" class="table-edit" data-user-id="{{ $details->id }}">
                                            <i class="fa-solid fa-pencil" data-bs-toggle="modal" data-bs-target="#dispatcherEdit"></i>
                                        </a> --}}
                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        {{-- pagination --}}
        {{-- <x-pagination :listing="$users" /> --}}
        {{ $users }}
    @else
        <div class="alert alert-info text-center no-record-found" role="alert">
            <h5>No Subscription plan added yet.</h5>
        </div>
    @endif
@endsection
@section('editcontent')
    <!-- Subscription Plan Modal Form -->
    @include('admin.subscriptionplan.popup')
    @include('admin.subscriptionplan.viewpopup')

@endsection


@section('scripts')
    {{-- <script src="{{ asset('assets/js/tinymce.js') }}"></script> --}}
    {{-- add with validation --}}
    <script>
        // subscription.js
        // previous code
        $(document).ready(function() {
            
            $.validator.addMethod("decimalMaxTwo", function(value, element) {
                return /^\d+(\.\d{1,2})?$/.test(value);
                }, "Please enter a valid number with maximum two decimal places.");
                var validator = $("#addSubscriptionForm").validate({
                rules: {{ Js::from(App\Http\Requests\SubscriptionRequest::frontendRules()) }},
                messages: {{ Js::from(App\Http\Requests\SubscriptionRequest::frontendMessages()) }},
                submitHandler: function(form) {
                    submit_ajax_form(form).then(function() {
                        console.log("LAST SUCCESS");
                    }, function() {
                        console.log("LAST ERROR");
                    });
                }
            });

            // $.validator.addMethod("decimalMaxTwo", function(value, element) {
            //     return /^\d+(\.\d{1,2})?$/.test(value);
            //     }, "Please enter a valid number with maximum two decimal places.");

            //     $.validator.addMethod("requiredSummernote", function() {
            //         return !($("#summernote").summernote('isEmpty'));
            //     }, 'Summernote field is required');

            // var validator = $("#addSubscriptionForm").validate({
            //     ignore:':hidden:not(#summernote)',
            //     rules: {{ Js::from(App\Http\Requests\SubscriptionRequest::frontendRules()) }},
            //     messages: {{ Js::from(App\Http\Requests\SubscriptionRequest::frontendMessages()) }},
            //     submitHandler: function(form) {
            //         alert('here');
            //         submit_ajax_form(form).then(function() {
            //             console.log("LAST SUCCESS");
            //         }, function() {
            //             console.log("LAST ERROR");
            //         });
            //     },
            //     errorPlacement: function (label, element) {
            //          if( jQuery(element).hasClass('summernote-textarea') ){
            //             label.insertAfter( $(element).parent() )
            //         } else {
            //             label.insertAfter(element)
            //         }
            //     }
            // });

            // Fetch Data for edit
            $('.edit-user').on('click', function(event) {
                event.preventDefault();
                var subsID = $(this).data('subscription-id');
                var url = "{{ route('subscriptions.add', ['id' => '']) }}/" + subsID;
                alert(url);
                handleAjaxRequest(url, 'GET', {
                    "subs_ID": subsID,
                }).then(function(response) {
                    setValuesInForm($("#addSubscriptionForm"), response.data);
                    $('#subscriptionModal').find(".ajax-submit-button").text($('#subscriptionModal')
                        .find(".ajax-submit-button").data("update-text"));
                    $('#subscriptionModal').modal('show');
                })
                
            });
            // View Data

            $('.user-data').on('click', function(event) {
                event.preventDefault();

                var subsID = $(this).data('subscription-id');
                var url = "{{ route('subscriptions.add', ['id' => '']) }}/" + subsID;
                handleAjaxRequest(url, 'GET', {
                    "subs_ID": subsID,
                }).then(function(response) {
                    setValuesInForm($("#ViewSubscriptionForm"), response.data);
                    $('#viewsubscriptiontModal').find(".ajax-submit-button").text($('#viewsubscriptiontModal')
                        .find(".ajax-submit-button").data("update-text"));
                    $('#viewsubscriptiontModal').modal('show');
                })
                
            });
        });
    </script>
@stop
