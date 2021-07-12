var table;
$(document).ready(function () {
    bindingAgenciesTable();

    $('#nhanvien-selection').select2({
        placeholder: 'Chọn nhân viên',
        ajax: {
            url: '/psi/php_action/selectemployee.php',
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
    $('#phongban-selection').select2({
        placeholder: 'Chọn Phòng Ban',
        ajax: {
            url: '/psi/php_action/selectphongban.php',
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
        $('#donvi-selection').select2({
        placeholder: 'Chọn đơn vị',
        ajax: {
            url: '/psi/php_action/selectdonvi.php',
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
        $('#chucvu-selection').select2({
        placeholder: 'Chọn Chức vụ',
        ajax: {
            url: '/psi/php_action/selectchucvu.php',
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
        $('#add_employee_btn').on('click', function (e) {
        e.preventDefault();

        //Fetch form to apply custom Bootstrap validation
        var form = $('form[name=add_employee]');
		$("#tennhanvien").val($("#nhanvien-selection option:selected").text());
		var tennhanvien = $("#tennhanvien").val(); 

        var formData = form.serialize() + "&tennhanvien=" + tennhanvien;
        var data = $.deparam(formData);

        if (form[0].checkValidity() === false) {
            e.stopPropagation();
        }
        form.addClass('was-validated');
        if (form[0].checkValidity()) {

            $.ajax({
                url: '/psi/php_action/EmployeeAdd.php', 
                type: 'POST',
                data: data,
                success: function (response) {
                    console.log('resp', response);
                    var response = JSON.parse(response);
                    if (response.success) {
                        location.reload();
                        toastr.success('Cập nhật thành công!');
                        $('form[name=add_employee]').trigger('reset');
                    } else {
                        toastr.error('Cập nhật không thành công!');
                    }
                }
            });
        }
    });
});


function bindingAgenciesTable() {

    $.ajax({
        url: '/psi/php_action/employeeFetch.php',
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
                            <td>${_.get(elem, 'full_name') || ''} </th>
                            <td>${_.get(elem, 'user_code') || ''} </th>
                            <td>${_.get(elem, 'donvi') || ''} </th>
                            <td>${_.get(elem, 'phongban') || ''} </th>
                            <td>${_.get(elem, 'chucvu') || ''} </th>
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
