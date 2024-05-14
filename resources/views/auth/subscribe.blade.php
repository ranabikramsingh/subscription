<html>

<head>
    <title>Subscription</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <div>
        <h2>Welcome</h2>
        <div>
            <!-- Subscribe View (subscribe.blade.php) -->
            
                <div class="container">
                    <h2>Subscribe to a Plan</h2>
                    <!-- Display any success or error messages -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Subscription Form -->
                    <form action="{{ route('subscribe') }}" method="POST" id="subscription-form">
                        @csrf

                        <!-- Plan Selection (Assuming two plans for demonstration) -->
                        <div class="form-group">
                            <label for="plan">Select Plan:</label>
                            <select name="plan" id="plan" class="form-control">
                                <option value="plan_id_from_stripe_basic">Basic Plan</option>
                                <option value="plan_id_from_stripe_premium">Premium Plan</option>
                            </select>
                        </div>

                        <!-- Payment Method Element -->
                        <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>

                        <!-- Form submission -->
                        <button id="submit-button" class="btn btn-primary mt-4">Subscribe</button>
                    </form>
                </div>
           

        </div>
    </div>
</body>

</html>
