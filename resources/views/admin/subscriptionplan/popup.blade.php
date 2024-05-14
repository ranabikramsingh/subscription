<div class="modal fade cstm-modal edit-modal" id="subscriptionModal" tabindex="-1"
    aria-labelledby="DispatchersManagementPopLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="addnew-dis-box">
                    <div class="popup-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"
                            fill="none">
                            <path
                                d="M8.18921 7.8446L13.9092 2.12463C14.0417 1.98245 14.1138 1.79439 14.1104 1.60009C14.1069 1.40579 14.0283 1.22042 13.8909 1.083C13.7535 0.94559 13.5681 0.866887 13.3738 0.863459C13.1795 0.860031 12.9914 0.932151 12.8492 1.06463L7.12927 6.7846L1.40918 1.06463C1.267 0.932151 1.07907 0.860031 0.884766 0.863459C0.690464 0.866887 0.504967 0.94559 0.367554 1.083C0.230141 1.22042 0.1515 1.40579 0.148071 1.60009C0.144643 1.79439 0.216763 1.98245 0.349243 2.12463L6.06921 7.8446L0.349243 13.5646C0.208793 13.7053 0.129883 13.8958 0.129883 14.0946C0.129883 14.2934 0.208793 14.484 0.349243 14.6246C0.490964 14.7635 0.680858 14.8423 0.879272 14.8446C1.07727 14.8403 1.26633 14.7618 1.40918 14.6246L7.12927 8.9046L12.8492 14.6246C12.991 14.7635 13.1809 14.8423 13.3793 14.8446C13.5773 14.8403 13.7663 14.7618 13.9092 14.6246C14.0496 14.484 14.1285 14.2934 14.1285 14.0946C14.1285 13.8958 14.0496 13.7053 13.9092 13.5646L8.18921 7.8446Z"
                                fill="#292929" />
                        </svg></div>
                    <div class="login-header text-center">
                        <h4>Subscription Management</h4>
                    </div>
                    <div id="errorMessage"></div>
                    <form id="addSubscriptionForm" class="addnew-dis-form" action="{{route('subscriptions.add')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- id for edit --}}
                        <input type="hidden" id="editUserId" name="subs_id" value="">
                        <div class="input-box">
                            <div class="form-group">
                                <div class="formfield">
                                    <input type="text" class="form-control" name="name" id="name_detail"
                                        placeholder="Subscription Name" value="{{ old('name') }}" maxlength="50">
                                    <span class="form-icon">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                </div>
                                <span class="invalid-txt" id="name-errors"></span>
                                @error('name')
                                    <span class="invalid-txt name-error" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="formfield">
                                    <input  class="form-control" name="price" id='price'
                                        placeholder="Price" value="{{ old('price') }}" maxlength="10">
                                    {{-- <input type="number" class="form-control" id="price" name="price" required> --}}
                                    <span class="form-icon">
                                        <i class="fa-solid fa-money-bill"></i>
                                    </span>
                                </div>
                                <span class="invalid-txt" id="price-errors"></span>
                                @error('price')
                                    <span class="invalid-txt price-error" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="formfield">
                                    <select class="form-control" name="interval" id="interval">
                                        <option value="" {{ (old('interval') == '') ? 'selected' : '' }}><p style="color: #BABABA">Select Month Interval</p></option>

                                        @for ($i = 1; $i <= 12; $i++)
                                            @php
                                                $intervalLabel = ($i == 1) ? 'Month' : 'Months';
                                            @endphp

                                            <option value="{{ $i }}" {{ (old('interval') == $i) ? 'selected' : '' }}>
                                                {{ $i }} {{ $intervalLabel }}
                                            </option>
                                        @endfor
                                    </select>

                                    <span class="form-icon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <span class="invalid-txt" id="interval-errors"></span>
                                @error('interval')
                                    <span class="invalid-txt interval-error" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="formfield">
                                    <x-summer-note name="description"/>
                                    {{-- <textarea class="form-control" name="description" id="description" placeholder="Write your description">{{ old('description') }}</textarea> --}}
                                    {{-- <textarea class="form-control" id="description" name="description" rows="3" required></textarea> --}}
                                    <span class="form-icon">
                                        <i class='far fa-comment-alt' style='font-size:24px'></i>
                                    </span>
                                </div>
                                <span class="invalid-txt" id="description-errors"></span>
                                @error('description')
                                    <span class="invalid-txt description-error"
                                        role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="alert alert-success alert-dismissible fade show" role="alert" id="errorMessage"> </div> --}}
                        <button  onclick="$(this).closest('form').submit()" class="button primary-btn full-btn edit ajax-submit-button"
                            id="editbutton" data-add-text="Add" data-update-text="Update">Add</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
