@if($plan->is_free)
<div class="subscription-plan-box">
    <div class="subsciption-top">
        <div class="subscription-header">
            <h5>{{ $plan->name }}</h5>
            <div class="header-sub-icon"><svg xmlns="http://www.w3.org/2000/svg" width="44" height="45" viewBox="0 0 44 45" fill="none">
                    <path d="M23.1836 7.84524L27.0076 15.7728C27.114 15.9934 27.2713 16.1842 27.4658 16.3288C27.6603 16.4734 27.8862 16.5674 28.1242 16.6028L36.6737 17.8742C36.9476 17.9149 37.2049 18.0332 37.4164 18.2157C37.628 18.3983 37.7854 18.6378 37.8709 18.9071C37.9564 19.1764 37.9665 19.4648 37.9001 19.7397C37.8337 20.0146 37.6934 20.265 37.4952 20.4626L31.3076 26.6332C30.9577 26.9822 30.7991 27.4844 30.8806 27.976L32.3411 36.6895C32.3878 36.9685 32.3573 37.2554 32.2531 37.5176C32.1488 37.7798 31.9749 38.0069 31.7511 38.1733C31.5273 38.3397 31.2624 38.4387 30.9865 38.459C30.7105 38.4794 30.4345 38.4204 30.1896 38.2887L22.5416 34.1739C22.3286 34.0596 22.0918 33.9999 21.8513 33.9999C21.6109 33.9999 21.374 34.0596 21.1611 34.1739L13.5131 38.2887C13.2682 38.4204 12.9922 38.4794 12.7162 38.459C12.4403 38.4387 12.1754 38.3397 11.9516 38.1733C11.7278 38.0069 11.5539 37.7798 11.4496 37.5176C11.3453 37.2554 11.3148 36.9685 11.3616 36.6895L12.8221 27.976C12.8627 27.7335 12.8451 27.4846 12.7707 27.2506C12.6963 27.0167 12.5674 26.8048 12.3951 26.6332L6.2075 20.4626C6.00925 20.265 5.86899 20.0146 5.80259 19.7397C5.73619 19.4648 5.7463 19.1764 5.83177 18.9071C5.91725 18.6378 6.07467 18.3983 6.28624 18.2157C6.49781 18.0332 6.75508 17.9149 7.02895 17.8742L15.5785 16.6028C15.8164 16.5674 16.0424 16.4734 16.2369 16.3288C16.4314 16.1842 16.5886 15.9934 16.6951 15.7728L20.5191 7.84524C21.0677 6.71793 22.6394 6.71793 23.1836 7.84524Z" fill="CurrentColor"></path>
                </svg></div>
        </div>
        <h3 class="Sub-bx-price">Freeware</h3>
        <p class="sub-txt">{{ $plan->description }}</p>
        <ul class="sub-list">
            <li>Fuel delivery subscription plans can</li>
            <li>Content for fuel delivery</li>
            <li>Include testimonials from satisfied</li>
            <li>Add Multiple dispatcher</li>
            <li>Money on fuel costs</li>
        </ul>
    </div>
    <div class="sub-btn-bx">
        <a href="" class="button primary-btn full-btn">Start</a>
    </div>
</div>
@else
<div class="subscription-plan-box sub-list sub-txt">
<div class="subsciption-top">
    <div class="subscription-header">
        <h5>{{ $plan->name }}</h5>
        <div class="header-sub-icon"><svg xmlns="http://www.w3.org/2000/svg" width="49" height="49" viewBox="0 0 49 49" fill="none">
                <path d="M22.6644 43.9582L12.8469 21.0907H3.23193L22.6644 43.9582Z" fill="CurrentColor"></path>
                <path d="M34.4317 19.5907L27.4342 9.0907H21.7792L14.7817 19.5907H34.4317Z" fill="CurrentColor"></path>
                <path d="M34.7319 21.0907H14.4819L24.6069 44.6857L34.7319 21.0907Z" fill="CurrentColor"></path>
                <path d="M36.3668 21.0907L26.5493 43.9582L45.9818 21.0907H36.3668Z" fill="CurrentColor"></path>
                <path d="M12.9817 19.5907L19.9792 9.0907H11.6242C11.5097 9.09097 11.3967 9.11748 11.294 9.16818C11.1913 9.21888 11.1016 9.29244 11.0317 9.3832L3.26172 19.5907H12.9817ZM36.2317 19.5907H45.9817L38.1817 9.3832C38.1118 9.29244 38.0221 9.21888 37.9194 9.16818C37.8167 9.11748 37.7038 9.09097 37.5892 9.0907H29.2342L36.2317 19.5907Z" fill="CurrentColor"></path>
            </svg></div>
    </div>
    <h3 class="Sub-bx-price">{{'$'.$plan->price}}<span>/ {{$plan->valid_for}}</span></h3>
    {{-- <p>Fuel delivery subscription plans can often save on fuel costs.</p>
    <ul class="">
    <h3 class="Sub-bx-price">{{'$'.$plan->price}}<span>/{{ $plan->valid_for }}</span></h3>
    {{-- <p class="sub-txt">Fuel delivery subscription plans can often save on fuel costs.</p>
    <ul class="sub-list">
        {!! $plan->description !!}
    </ul> --}}
    <div class="plans-description">
        {!! $plan->description !!}
    </div>
</div>
<div class="sub-btn-bx">
    <a href="{{ route('subscriptions.payment.method',[$plan->secure_id ]) }}" class="button primary-btn full-btn">Buy now</a>
</div>
</div>
@endif
