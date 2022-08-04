//Delete confirmation
function confirmDelete(url, itemId, token) {
    Swal.fire({
        title: labels.action.confirm_action,
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK',
        cancelButtonText: labels.cancel,
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((isConfirm) => {
        if (isConfirm.value) {
            $.post(url, {
                item_id: itemId,
                _token: token
            }, function (data) {
                if (data.status === 'success') {
                    $("#row-id-" + itemId).slideUp();
                    Swal.fire(data.title + "!", data.message, "success");
                } else {
                    Swal.fire(data.title + "!", data.message, data.status);
                }
                if (typeof data.reload != 'undefined' && data.reload) {
                    window.location.reload();
                }
            }).fail((res) => {
                Swal.fire(labels.status.canceled, res.statusText, "error");
            });
        } else {
            Swal.fire(labels.status.canceled, '', "error");
        }
    });
}

//check all
//Used at role/form
$("#check-all").change(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
});
