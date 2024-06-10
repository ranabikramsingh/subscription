<script src="https://js.stripe.com/v3/"></script>
<script>
// jQuery(document).ready(function($) {
    const subscriptionId = {{ $plan->id }};
    const subscriptionPrice = {{ $plan->price }};
    var totalAmount = subscriptionPrice;
    const currencyCode = "{{ config('cashier.currency') }}";
    const currencySymbol = "{{ config('cashier.symbol') }}";
    const stripeKey = "{{ config('cashier.key') }}";
    const stripe = Stripe(stripeKey);
    const elements = stripe.elements();
    // const cardElement = elements.create('card')
	// cardElement.mount('#card-element')
    var cardNumberElement = elements.create('cardNumber', {
        classes: {
            base: 'form-control', // Custom class for the outer container
            focus: 'focused', // Custom class when the element is focused
            invalid: 'invalid' // Custom class when the element is invalid
        },
    });
    cardNumberElement.mount('#cardNumberElement');
    var cardExpiryDate = elements.create('cardExpiry', {
        classes: {
            base: 'form-control', // Custom class for the outer container
            focus: 'focused', // Custom class when the element is focused
            invalid: 'invalid' // Custom class when the element is invalid
        },
    });
    cardExpiryDate.mount('#cardExpiryElement');
    var cardCvcElement = elements.create('cardCvc', {
        classes: {
            base: 'form-control', // Custom class for the outer container
            focus: 'focused', // Custom class when the element is focused
            invalid: 'invalid' // Custom class when the element is invalid
        },
    });
    cardCvcElement.mount('#cardCVCElement');
    cardNumberElement.on('change', function(event) {
        if (event.error) {
            const spanElement = `<span class="invalid-feedback" role="alert">
                                <strong>${event.error.message}</strong>
                            </span>`;
            jQuery('#cardNumberElement').addClass('is-invalid');
            jQuery(spanElement).insertAfter('#cardNumberElement');
        } else {
            jQuery('#cardNumberElement').removeClass('is-invalid');
            jQuery('#cardNumberElement').next('span.invalid-feedback').remove();
        }
    });

    cardExpiryDate.on('change', function(event) {
        if (event.error) {
            const spanElement = `<span class="invalid-feedback" role="alert">
                                <strong>${event.error.message}</strong>
                            </span>`;
            jQuery('#cardExpiryElement').addClass('is-invalid');
            jQuery(spanElement).insertAfter('#cardExpiryElement');
        } else {
            jQuery('#cardExpiryElement').removeClass('is-invalid');
            jQuery('#cardExpiryElement').next('span.invalid-feedback').remove();
        }
    });

    cardCvcElement.on('change', function(event) {
        if (event.error) {
            const spanElement = `<span class="invalid-feedback" role="alert">
                                <strong>${event.error.message}</strong>
                            </span>`;
            jQuery('#cardCVCElement').addClass('is-invalid');
            jQuery(spanElement).insertAfter('#cardCVCElement');
        } else {
            jQuery('#cardCVCElement').removeClass('is-invalid');
            jQuery('#cardCVCElement').next('span.invalid-feedback').remove();
        }
    });

    // jQuery('#cardHolderName').on('change', function(event) {
    //     const nameRegex = /^[A-Za-z\s]+$/;
    //     const errorContainer = jQuery('#cardHolderName').next('span.invalid-feedback');
    //     // Remove existing error messages
    //     errorContainer.remove();
    //     if (!this.value || !nameRegex.test(this.value.trim())) {
    //         const span = `<span class="invalid-feedback" role="alert">
    //                             <strong>Enter a valid card holder name</strong>
    //                         </span>`;
    //         jQuery('#cardHolderName').addClass('is-invalid');
    //         jQuery(span).insertAfter('#cardHolderName');
    //     } else {
    //         jQuery('#cardHolderName').removeClass('is-invalid');
    //     }
    // });

    jQuery('#cardHolderName').on('change', function(event) {
            alert('hello');
    });



    //* for submissiomn paln sucsribe
    const cardButton = document.getElementById('payButton');
    const form = document.getElementById('buySubscriptionForm');
    form.addEventListener('submit', async function(event) {
        alert("Warning!");
        event.preventDefault();
        jQuery("body").addClass("loading");
        const clientSecret = cardButton.getAttribute('data-secret');
        cardButton.setAttribute('disabled', true);
        // if (jQuery("#buySubscriptionForm").valid()) {
            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardNumberElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );


            if (error) {
                cardButton.removeAttribute('disabled');
                jQuery("body").removeClass("loading");
                const spanElement = `<span class="invalid-feedback alert alert-danger" role="alert">
                                <strong>${error.message}</strong>
                            </span>`;
                jQuery('#cardError').addClass('is-invalid');
                $('#cardError').next('.alert-danger').remove();
                jQuery(spanElement).insertAfter('#cardError');
            } else {
                jQuery("body").addClass("loading");
                cardButton.innerHTML = '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Paying..';
                jQuery('#cardError').removeClass('is-invalid');
                jQuery('#cardError').html('');
                stripeTokenHandler(setupIntent);
            }

            return;
        // }

        cardButton.removeAttribute('disabled');
    });
// });
    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        // var form = document.getElementById('buySubscriptionForm');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', token.payment_method);
        form.appendChild(hiddenInput);
        // Submit the form
        form.submit();
    }
</script>
