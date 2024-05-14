<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Plan</title>
    <!-- CSS only -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body>

    <div style="border: 1px solid red;">
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (Session::has('successMessage'))
            <div class="alert alert-success">
                {{ Session::get('successMessage') }}
            </div>
        @endif
        @if (isset($validator))
            <div class="alert alert-success">
                {{ $validator }}
            </div>
        @endif

        <!-- Your other HTML content here -->

        <h2>Create Subscription Plan</h2>
        <form id="addSubscriptionForm" class="addnew-dis-form" action="{{ route('subscription.create') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            {{-- Subscription Name --}}
            <div class="input-box">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" id="name_detail"
                        placeholder="Subscription Name" value="{{ old('name') }}" maxlength="50">
                    @error('name')
                        <span class="invalid-txt name-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Price --}}
            <div class="input-box">
                <div class="form-group">
                    <input class="form-control" name="price" id="price" placeholder="Price"
                        value="{{ old('price') }}" maxlength="10">
                    @error('price')
                        <span class="invalid-txt price-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Interval --}}
            <div class="input-box">
                <div class="form-group">
                    <select class="form-control" name="interval" id="interval">
                        <option value="" {{ old('interval') == '' ? 'selected' : '' }}>
                            Select Month Interval
                        </option>
                        @for ($i = 1; $i <= 12; $i++)
                            @php
                                $intervalLabel = $i == 1 ? 'Month' : 'Months';
                            @endphp
                            <option value="{{ $i }}" {{ old('interval') == $i ? 'selected' : '' }}>
                                {{ $i }} {{ $intervalLabel }}
                            </option>
                        @endfor
                    </select>
                    @error('interval')
                        <span class="invalid-txt interval-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- Description --}}
            <div class="input-box">
                <div class="form-group">
                    <label><strong>Description :</strong></label>
                    <textarea class="summernote-textarea" name="description"></textarea>
                </div>

            </div>

            {{-- Submit Button --}}
            <button type="submit" class="button primary-btn full-btn edit ajax-submit-button" id="editbutton"
                data-add-text="Add" data-update-text="Update">Add</button>
        </form>
    </div>
    <br>

    <div>
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
                                                    data-url="" onchange="updateStatus(this,this.checked)"
                                                    role="switch" id="flexSwitchCheckdishpacher" name="status"
                                                    value="1" @if ($details->status) checked @endif>
                                            </div>

                                        </div>
                                    </td>

                                    <td>
                                        <div class="table-data">
                                            <div class="table-data delete-user" data-bs-toggle="tooltip"
                                                data-bs-original-title="Delete" data-bs-placement="top">
                                                <i class="fa-solid fa-trash-can" data-model="SubscriptionPlan"
                                                    data-id="" data-url="" onclick="Delete(this)"
                                                    style="color: #FD5C5C;"></i>
                                            </div>

                                            {{-- <div class="table-data edit-user" >
                                                    <i class="fa-solid fa-pencil"></i>
                                                </div> --}}
                                            <div class="table-data edit-user"
                                                data-subscription-id="{{ $details->id }}" data-title="View order"
                                                data-bs-toggle="tooltip" data-bs-original-title="View"
                                                data-bs-placement="top">
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
    </div>

    <script>
        // subscription.js
        // previous code
        $(document).ready(function() {
        
            // Fetch Data for edit
            $('.edit-user').on('click', function(event) {
                event.preventDefault();

                var subsID = $(this).data('subscription-id');
                var url = "{{ route('subscriptions.add', ['id' => '']) }}/" + subsID;
                handleAjaxRequest(url, 'GET', {
                    "subs_ID": subsID,
                }).then(function(response) {
                    setValuesInForm($("#addSubscriptionForm"), response.data);
                    $('#subscriptionModal').find(".ajax-submit-button").text($('#subscriptionModal')
                        .find(".ajax-submit-button").data("update-text"));
                    $('#subscriptionModal').modal('show');
                })
                
            });         
        });
    </script>

</body>

</html>
