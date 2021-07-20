var table;
$(document).ready(function () {
    // top nav bar
    $('#nav-link-employee-sales').addClass('active');
    var userId = $('#user_id').val();
    bindingEmployeeSales(new Date().getFullYear());

    $('#btnFilterEmployeeSales')
        .unbind('click')
        .bind('click', function () {
            var currentYear = $('#year-selection').val();
            bindingEmployeeSales(currentYear);
        });

    $('#product-selection').select2({
        placeholder: 'Chọn sản phẩm',
        ajax: {
            url: '/php_action/productSearch.php',
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

    $('#add_agency_sale').on('click', function (e) {
        e.preventDefault();

        //Fetch form to apply custom Bootstrap validation
        var form = $('form[name=add_agency_sales]');
        var formData = form.serialize();
        var data = $.deparam(formData);

        var { months } = data || {};

        if (form[0].checkValidity() === false) {
            e.stopPropagation();
        }

        if (!months || _.isEmpty(months)) {
            $('#month-selection input').each(function (idx, obj) {
                obj.setCustomValidity('Months should be selected');
            });
            e.stopPropagation();
        }

        form.addClass('was-validated');

        if (form[0].checkValidity() && !_.isEmpty(months)) {
            $.ajax({
                url: '/php_action/employeeSaleCreate.php',
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

    $('#cancel_add_agency_sale').on('click', function (e) {
        e.preventDefault();
        $('form[name=add_agency_sales]').trigger('reset');
    });

    var userId = $('#user_id').val();

    $('#agency-selection').select2({
        placeholder: 'Chọn đại lý',
        ajax: {
            url: '/php_action/agencySearch.php',
            dataType: 'json',
            delay: 250,
            type: 'POST',
            data: function (data) {
                return {
                    query: data.term,
                    userId: userId // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            }
        }
    });
});

function bindingEmployeeSales(year) {
    var userId = $('#user_id').val();
    var levelId = $('#level_id').val();
    var channel_id = $('#channel_id').val();
    var employee_level = $('#employee_level').val();
    var business_unit_id = $('#business_unit_id').val();
    var industry_id = $('#industry_id').val();
    var channel_name = $('#channel_name').val();
    $.ajax({
        url: '/php_action/employeeSaleFetch.php',
        type: 'get',
        data: {
            userId: userId,
            levelId: levelId,
            year: year,
            employee_level: employee_level,
            channel_name: channel_name,
            industry_id: industry_id,
            business_unit_id: business_unit_id,
            channel_id: channel_id
        },
        dataType: 'json',
        success: function (response) {
            var { agency_sales, year, agencyOptions } = response || {};
            var formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
            if (year) {
                $('#year-selection option, #year-selection_create option').each(function () {
                    if ($(this).val() == year) {
                        $(this).attr('selected', 'selected');
                    }
                });
            }

            var table = $('#table_agency_sales tbody');
            table.empty();

            if (!_.isEmpty(agency_sales)) {
                $.each(agency_sales, function (idx, sale) {
                    var td = ``;
                    var d = new Date();
                    var n = d.getMonth();
                    for (var i = n; i < 12; i++) {
                        td += `
                            <td data-type="text" data-state="sale" data-agency-id="${_.get(
                                sale,
                                '0.agency_id'
                            )}" data-name="${i + 1}" data-pk="${_.get(sale, '0.product_id')}">
                                ${
                                    _.get(
                                        _.find(sale, (o) => parseInt(o.month) === i + 1),
                                        'number_of_sale_goods'
                                    ) || 0
                                }
                            </td>

                    `;
                        td += `
                    <td class="not-editable" data-type="text" data-state="price" data-agency-id="${_.get(
                        sale,
                        '0.agency_id'
                    )}" data-name="${i + 1}" data-pk="${_.get(sale, '0.product_id')}">
                        ${formatter.format(
                            _.get(
                                _.find(sale, (o) => parseInt(o.month) === i + 1),
                                'calculated_price'
                            ) || 0
                        )}
                    </td>;
                        `;
                    }

                    table.append(`
                        <tr>
                            <td class="not-editable">${_.get(sale, '0.product_id', '')} </td>
                            <td class="not-editable">${_.get(sale, '0.product_code', '')} </td>
                            <td class="not-editable">${_.get(sale, '0.model') || 0} </td>
                            <td class="not-editable">${_.get(sale, '0.business_unit_name') || 0} </td>
                            <td class="not-editable">${_.get(
                                _.find(agencyOptions, (o) => o.value === _.get(sale, '0.agency_id')),
                                'title',
                                ''
                            )} </td>
                            <td class="not-editable">${_.get(sale, '0.stock') || 0} </td>
                            ${td}
                        </tr>
              `);
                });

                $('#table_agency_sales').DataTable({
                    destroy: true,
                    responsive: true,
                    ordering: false
                });

                $('#table_agency_sales tbody tr td:not(.not-editable)').editable({
                    send: 'always',
                    type: 'text',
                    url: '/php_action/employeeSaleUpdate.php',
                    params: function (params) {
                        var state = $(this).attr('data-state');
                        var agencyId = $(this).attr('data-agency-id');
                        params.year = 2021;
                        params.state = state;
                        params.agency_id = agencyId;

                        return params;
                    },
                    validate: function (value) {
                        if (!Number.isInteger(parseFloat(value))) {
                            return 'Chỉ nhập số nguyên';
                        }
                    },
                    success: function (response, newValue) {
                        if (response && response.success) {
                            toastr.success('Cập nhật thành công!');
                            location.reload();
                        } else {
                            toastr.error('Cập nhật không thành công!');
                        }
                    },
                    ajaxOptions: {
                        type: 'POST',
                        dataType: 'json'
                    }
                });
            }
        } // /success function
    });
}
