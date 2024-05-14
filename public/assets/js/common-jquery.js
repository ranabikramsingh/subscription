//Use loder(true) & loder(false);


$(document).ready(function () {
    /* Ajax loader */
    jQuery(document).ajaxStart(function (event, request, settings) {
        jQuery("body").addClass("loading");
    });
    jQuery(document).ajaxStop(function (event, request, settings) {
        jQuery("body").removeClass("loading");
    });
    /* End ajax loader */

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
//* common function for updating status
function updateStatus(element, isChecked) {
    // var value = isChecked ? '1' : '0';
    var url = $(element).data('url');
    // var id = element.data('id');
    // var model = element.data('model');
    var data = {
        'value': isChecked ? '1' : '0',
        'id': $(element).data('id'),
        'model': $(element).data('model'),
    }
    handleAjaxRequest(url, 'POST', data).then(function (response) {
        Swal.fire('Success', response.message, 'success');
    })
        .catch(function (error) {
            Swal.fire('Error', 'Something went wrong', 'error');
        });
}

//* common function for deleting records
function Delete(element) {
    const { url, id, model } = $(element).data();

    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then(result => result.isConfirmed && handleAjaxRequest(url, 'POST', { id, model })
        .then(response => Swal.fire({
            title: 'Delete!',
            text: response.message,
            icon: 'success'
        }))
        .then(result => (result.isConfirmed || result.isDismissed) && location.reload())
        .catch(() => Swal.fire('Error', 'Something went wrong', 'error'))
    );
}

//* function for deleting invited_user by normal_user
function DeleteInvitedUser(element) {
    const { url, id, model, addedby } = $(element).data();

    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then(result => result.isConfirmed && handleAjaxRequest(url, 'POST', { id, model, addedby })
        .then(response => Swal.fire({
            title: 'Delete!',
            text: response.message,
            icon: 'success'
        }))
        .then(result => (result.isConfirmed || result.isDismissed) && location.reload())
        .catch(() => Swal.fire('Error', 'Something went wrong', 'error'))
    );
}

//* for toggle between password and text
$('.togglePassword').click(function () {
    var $input = $(this).closest('.formfield').find('input');
    $(this).toggleClass('fa-lock fa-unlock');
    $input.prop('type', function (index, oldType) {
        return oldType === 'password' ? 'text' : 'password';
    });
});

//* for tooltip title
$(document).ready(function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});

//* for active box on Dashboard listing and Product management
const trackorderBoxes = document.querySelectorAll('.stats-box');
trackorderBoxes.forEach((box, index) => {
    box.addEventListener('click', () => {
        // Remove 'active' class from all stats-box elements
        trackorderBoxes.forEach(box => {
            box.classList.remove('active');
        });

        box.classList.add('active');
    });
    // Add 'active' class to the first stats-box element by default
    if (index === 0) {
        box.classList.add('active');
    }
});
// Common function for cancel subscription
function cancelSubscription(element) {
    const { url, id, model } = $(element).data();

    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then(result => result.isConfirmed && handleAjaxRequest(url, 'POST', { id, model })
        .then(response => Swal.fire({
            title: 'Delete!',
            text: response.message,
            icon: 'success'
        }))
        .then(result => (result.isConfirmed || result.isDismissed) && location.reload())
        .catch(() => Swal.fire('Error', 'Something went wrong', 'error'))
    );
}