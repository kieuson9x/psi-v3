var table;
$(document).ready(function () {
    bindingAgenciesTable();

    $('#nhanvien-selection').select2({
        placeholder: 'Chọn nhân viên',
        ajax: {
            url: '/php_action/AgencyAdd.php',
            dataType: 'json',
            delay: 250,
            type: 'POST',
            data: function (data) {
                return {
                    query: data.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            }
        }
    });

    $('#add_agency_btn').on('click', function (e) {
        e.preventDefault();

        //Fetch form to apply custom Bootstrap validation
        var form = $('form[name=add_agency]');
        var formData = form.serialize();
        var data = $.deparam(formData);

        var { months } = data || {};

        if (form[0].checkValidity() === false) {
            e.stopPropagation();
        }
        form.addClass('was-validated');
        if (form[0].checkValidity()) {
            $.ajax({
                url: '/php_action/agencyCreate.php',
                type: 'POST',
                data: data,
                success: function (response) {
                    console.log('resp', response);
                    var response = JSON.parse(response);
                    if (response.success) {
                        location.reload();
                        toastr.success('Cập nhật thành công!');
                        $('form[name=add_agency_sales]').trigger('reset');
                    } else {
                        toastr.error('Cập nhật không thành công!');
                    }
                }
            });
        }
    });
});

function bindingAgenciesTable() {
    var userId = $('#user_id').val();
    var levelId = $('#level_id').val();

    $.ajax({
        url: '/php_action/agencyFetch.php?user_id=' + userId + '&levelId=' + levelId,
        type: 'get',
        dataType: 'json',
        success: function (response) {
            var { agencies } = response || {};

            if (agencies) {
                var table = $('#table_agencies tbody');
                table.empty();

                $.each(agencies, function (idx, elem) {
                    var td = ``;

                    table.append(`
                        <tr>
                            <td>${_.get(elem, 'id', '')} </th>
                            <td>${_.get(elem, 'name') || ''} </th>
                            <td>${_.get(elem, 'province') || ''} </th>
                            <td>${_.get(elem, 'full_name') || ''} </th>
                        </tr>
                    `);
                });

                $('#table_agencies').DataTable({
                    destroy: true,
                    responsive: true,
                    ordering: false
                });
            }
        } // /success function
    });
}
