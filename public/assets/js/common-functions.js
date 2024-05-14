/* Submit form by aJax */
function submit_ajax_form(form) {
    var url = $(form).attr("action"),
        method = $(form).attr("method"),
        body = new FormData(form),
        submit_button = $(form).find(".ajax-submit-button");
    if (!$(form).find(".ajax-response").length)
        $(form).prepend("<div class='ajax-response'></div>");
    submit_button.append(' <i class="fa fa-spinner fa-spin"></i>').attr("disabled", true);
    return handleAjaxRequest(url, method, body).then(function (data) {
        $(form).find(".ajax-response").html('<div class="d-none alert alert-success alert-dismissible fade show" role="alert">' + data.message + '</div>');
        if ('data' in data && 'redirect_to' in data.data && data.data.redirect_to) {
            location.href = data.data.redirect_to;
        } else
            location.reload();
        return data;
    }, function (error) {
        $(form).find(".ajax-response").html('<div class="alert alert-danger alert-dismissible fade show backendError" role="alert">' + error.message + '</div>');
        submit_button.attr("disabled", false);
        throw error;
    }).finally(function () {
        submit_button.find('i').remove();
        // submit_button.attr("disabled", false);
    });
}
// { { --searching Button Submit-- } }
document.addEventListener('DOMContentLoaded', function () {
    const formSubmitBtn = document.getElementById('form_submit'); // anchor
    const searchForm = document.getElementById('searchdata');

    formSubmitBtn.addEventListener('click', function (e) {
        e.preventDefault();
        // Submit the form
        searchForm.submit();
    });
});


function handleAjaxRequest(url, method, body) {
    if (typeof body == 'object' && !(body instanceof FormData) && method.toUpperCase() == 'POST') {
        let formData = new FormData();
        // Append each key-value pair from the object to the FormData
        for (let key in body)
            if (body.hasOwnProperty(key))
                formData.append(key, body[key]);
        body = formData;
    }
    console.log(url, method, body);
    return ajaxPromise(url, method, body)
        .then(async function (response) {
            if (response.status) {
                return response;
            } else {
                throwError(response);
            }
        })
        .catch(function (error) {
            // Log the error and rethrow it
            console.error('Error in handleAjaxRequest:', error);
            throwError(error);
        });

}




function throwError(response) {
    var errorMessage = 'Something went wrong';
    if (typeof response == 'object' && 'message' in response)
        errorMessage = response.message;
    // console.log( errorMessage );
    throw new Error(errorMessage);
}

function ajaxPromise(url, method, body) {
    return new Promise((resolve, reject) => {
        let ajaxConfigurations = {
            url: url,
            type: method,
            data: body,
            contentType: false,
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            }
        };
        if (method.toUpperCase() == 'POST')
            ajaxConfigurations['processData'] = false;
        $.ajax(ajaxConfigurations);
    });
}

// function setValuesInForm(form, data) {
//     for (var variable in data) {
//         var input = form.find(`[name=${variable}]`);

//         if (variable === 'description') {
//             // Special handling for Summernote textarea
//             // Assuming you have initialized Summernote on a textarea with the ID "summernote"
//             $('textarea#summernote').summernote('code', data[variable]);
//         } else if (input.is(':radio')) {
//             // For radio buttons, check the one with the corresponding value
//             form.find(`[name=${variable}][value=${data[variable]}]`).prop('checked', true);
//         } else {
//             // For other input types, set the value
//             input.val(data[variable]);
//         }
//     }
// }

// updated function
function setValuesInForm(form, data) {
    var baseUrl = window.location.origin;
    for (var variable in data) {
        var input = form.find(`[name=${variable}]`);
        var anchor = form.find(`a.dynamic-anchor[data-link-variable=${variable}]`);

        if (variable === 'description' || variable === 'content') {
            // Special handling for Summernote textarea
            // Assuming you have initialized Summernote on a textarea with the ID "summernote"
            $('textarea#summernote').summernote('code', data[variable]);
        } else if (input.is(':radio')) {
            // For radio buttons, check the one with the corresponding value
            form.find(`[name=${variable}][value=${data[variable]}]`).prop('checked', true);
        } else if (anchor.length > 0) {
            // For anchor tags, set the href attribute
            // anchor.attr('href', baseUrl + '/storage/' + data[variable]);
            var hrefValue = baseUrl + '/storage/' + data[variable];
            anchor.attr('href', data[variable] ? hrefValue : '#');
            anchor.text(data[variable] ? hrefValue : '');
        }
        else {
            // For other input types, set the value
            input.val(data[variable]);
        }
    }
}

// for resetting modal an blocking close on clicking body
function blockModal() {
    $('.modal').modal({ backdrop: 'static', keyboard: false }, 'show');
    $('.popup-btn-close').on('click', function () {
        var form = $(this).closest('.modal-body').find('form');
        form.get(0).reset();
        // form.find('.hidden-input').val('');
        // form.find('input[type="hidden"]').not('').val('');
        form.find('input[type="hidden"]').each(function () {
            if ($(this).attr('name') !== '_token') {
                $(this).val('');
            }
        })

        form.find('textarea#summernote').summernote('code', '');
        $(form).data("validator").resetForm();/* Reset validation errors */
        $(form).find(".ajax-response").empty(); // Remove any error messages
        $(form).find(".ajax-submit-button").text($(form).find(".ajax-submit-button").data("add-text"));
        var summernoteTextarea = form.find('.summernote');
        if (summernoteTextarea.length) {
            summernoteTextarea.summernote('code', ''); // Reset Summernote content to an empty string
        }
    });

}

//* for csv import
function importCsv(element) {
    var form = $(element).closest('form'); // Find the form
    form.find('[name="import_file"]').click(); // Trigger file input click
}
//* for import csv
function submitForm(element) {
    var form = $(element).closest('form');
    var input = form.find('[name="import_file"]');

    // Check if the file extension is csv or xlsx (adjust as needed)
    var fileName = input.val().split('\\').pop(); // Get the file name
    var extension = fileName.split('.').pop().toLowerCase();
    console.log(extension);

    if (extension === 'csv' || extension === 'xlsx') {
        form.submit(); // Submit the form
    } else {
        // Handle invalid file type
        alert('Invalid file type. Please select a CSV or Excel file.');
        // Reset the file input to clear the selection
        input.val('');
    }
}


$(document).ready(function () {

    blockModal();
    /* $('#dispatchersManagementPopup').on('show.bs.modal', function (event) {
        var triggeringElement = $(event.relatedTarget);
        $('#dispatchersManagementPopup').find('.login-header h4').text(triggeringElement.data('title'));
        $('#dispatchersManagementPopup').find('.ajax-submit-button').text(triggeringElement.data('buttontext'));
    }); */

    $(".close").on("click", function () {
        $(this).closest('.flash-message').remove();
    });
});

// format string to a certain length
function formatStringLength(str, length) {
    if (str.length > length) {
        str = str.substring(0, length - 3) + '...';
    }
    return str;
}
