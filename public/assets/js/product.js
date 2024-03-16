$(function () {
    if (page == 'list') {
        getProducts();
    } else if (page == 'create' || page == 'edit') {
        formSubmission();
    }

});

function getProducts() {
	table = $('#product_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        stateSave: true,
        ajax: tableURL,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: 'Bfrtpli',
        buttons: [
        ],
        initComplete: function () {
            var exportButton = $('.dt-button');
            exportButton.removeClass('dt-button');
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'actions',
                name: 'actions'
            },
        ]
    });
}

$(document).on('click', '.add-more', function() {
    let html = $('.from-content').html();
    $('.repeat-from').append('<div class="row" id="appended-form' + formCounter + '">' + html + '</div>');
    formCounter++;
    if (formCounter == 1) {
        $('.remove').hide();
    } else {
        $('.remove').show();
    }
});

$(document).on('click', '.remove', function() {
    formCounter--;
    $("#appended-form" + formCounter).remove();
    if (formCounter == 1) {
        $('.remove').hide();
    }
    //console.log(formCounter);
});

function formSubmission() {
    $('#product_form').validate({
        rules: {
            title: {
                required: true
            },
            description: {
                required: true
            },
        },
        messages: {
            title: {
                required: 'Enter Title'
            },
            description: {
                required: 'Enter Description'
            },
        },
        submitHandler: function (form, e) {
            e.preventDefault();
            $('#cover-spin').show();
            let formData = new FormData($('#product_form')[0]);
            $.ajax({
                type: "POST",
                url: storeURL,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache:false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#cover-spin').hide();
                    if (response.status == 'success') {
                        toastr.success(response.message, 'Error');
                        window.location.replace(response.next);
                    } else if (response.status == 'validationError') {
                        $.each(response.messages, function (index, value) {
                            $("input[name='" + index + "']").after('<label class="error">' + value[0] + '</label>');
                            if (index == 'description') {
                                $("textarea[name='" + index + "']").after('<label class="error">' + value[0] + '</label>');
                            }
                        });
                    } else if(response.status == 'error') {
                        toastr.error('Something went wrong.', 'Error');
                    }
                },
                error: function (error) {
                    $('#cover-spin').hide();
                    toastr.error('Something went wrong.', 'Error');
                    $("#form_submit").prop('disabled', false);
                }
            });
        }
    });
}

$(document).on('click', '.delete-btn', function () {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $('#cover-spin').show();
            $.ajax({
                type: "DELETE",
                data: {
                    'id': $(this).attr('data-id')
                },
                url: deleteURL,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#cover-spin').hide();
                    if (response.status == "success") {
                        table.destroy();
                        Swal.fire({
                            title: "Deleted",
                            text: response.message,
                            type: "success",
                            icon: "success"
                        }).then(function () {
                            getProducts();
                        });
                    } else if (response.status == 'validationError') {
                        Swal.fire({
                            title: "Sorry!",
                            text: response.message,
                            type: "error",
                            icon: 'error'
                        });
                    } else if (response.status == 'error') {
                        Swal.fire({
                            title: "Sorry!",
                            text: "Something went wrong.",
                            type: "error",
                            icon: 'error'
                        });
                    }
                },
                error: function (error) {
                    $('#cover-spin').hide();
                    Swal.fire({
                        title: "Sorry!",
                        text: "Something went wrong.",
                        type: "error",
                        icon: 'error'
                    });
                }
            });
        }
    })
});