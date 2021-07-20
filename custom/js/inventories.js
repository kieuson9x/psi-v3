var table;
$(document).ready(function () {
    // top nav bar
    $('#nav-link-inventory').addClass('active');

    $('.table_inventories').each(function (table) {
        var currentBusinessUnitCode = $(this).attr('id').replace('inventories_', '');
        bindingInventories(currentBusinessUnitCode);
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

    $('#add_inventory').on('click', function (e) {
        e.preventDefault();

        //Fetch form to apply custom Bootstrap validation
        var form = $('form[name=add_inventory]');
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
            // .setCustomValidity("Passwords must match");
        }

        form.addClass('was-validated');

        if (form[0].checkValidity() && !_.isEmpty(months)) {
            $.ajax({
                url: '/php_action/inventoryCreate.php',
                type: 'POST',
                data: data,
                success: function (response) {
                    console.log('resp', response);
                    var response = JSON.parse(response);
                    if (response.success) {
                        location.reload();
                        toastr.success('Cập nhật thành công!');
                        $('form[name=add_inventory]').trigger('reset');
                    } else {
                        toastr.error('Cập nhật không thành công!');
                    }
                }
            });
        }
    });

    $('#cancel_add_inventory').on('click', function (e) {
        e.preventDefault();
        $('form[name=add_inventory]').trigger('reset');
    });
    $('.table_inventories').DataTable({
        destroy: true,
        responsive: true,
        ordering: false
    });

    $('#exportExcel').on('click', function (e) {
        e.preventDefault();
        var userId = $('#user_id').val();
        var levelId = $('#level_id').val();
        var employee_level = $('#employee_level').val();

        $.ajax({
            url: '/php_action/inventoryExportExcel.php',
            type: 'POST',
            data: {
                userId: userId,
                levelId: levelId,
                employee_level: employee_level
            },
            dataType: 'json',
            success: function (response) {
                const { file_url, file_name, error } = response || {};
                if (file_url) {
                    var redirectWindow = window.open(file_url, '_blank');
                    redirectWindow.location;

                    $.ajax({
                        url: '/php_action/inventoryExportExcelDelete.php',
                        type: 'POST',
                        data: {
                            file_name: file_name
                        },
                        dataType: 'json',
                        success: function (response) {}
                    });
                } else {
                    toastr.error('Không có quyền truy cập');
                }
            }
        });
    });
});

function bindingInventories(currentBusinessUnitCode) {
    var userId = $('#user_id').val();
    var levelId = $('#level_id').val();
    var employee_level = $('#employee_level').val();

    $.ajax({
        url: '/php_action/inventoryFetch.php',
        type: 'get',
        data: {
            userId: userId,
            levelId: levelId,
            employee_level: employee_level,
            currentBusinessUnitCode: currentBusinessUnitCode
        },
        dataType: 'json',
        success: function (response) {
            var { inventories, year } = response || {};

            bindingInventoriesTable(currentBusinessUnitCode, inventories);
        } // /success function
    });
}

function bindingInventoriesTable(currentBusinessUnitCode, inventories) {
    var table = $('#inventories_' + currentBusinessUnitCode + ' tbody');
    table.empty();

    $.each(inventories, function (idx, elem) {
        var td = ``;
        var d = new Date();
        var n = d.getMonth();

        for (var i = n; i < 12; i++) {
            td += `
            <td data-type="text" data-state="purchase" data-name="${i + 1}" data-pk="${_.get(elem, `0.product_id`)}">
                ${
                    _.get(
                        _.find(elem, function (o) {
                            return parseInt(o.month) === i + 1;
                        }),
                        'number_of_imported_goods'
                    ) || 0
                }
            </td>

            <td class="not-editable" data-state="sale">
                ${
                    _.get(
                        _.find(elem, function (o) {
                            return parseInt(o.month) === i + 1;
                        }),
                        'number_of_sale_goods'
                    ) || 0
                }
            </td>

            <td class="not-editable" data-type="text" data-state="inventory" data-name="${i + 1}" data-pk="${_.get(
                elem,
                `0.product_id`
            )}">
                ${
                    _.get(
                        _.find(elem, function (o) {
                            return parseInt(o.month) === i + 1;
                        }),
                        'number_of_remaining_goods'
                    ) || 0
                }
            </td>
            `;
        }

        if (!_.isEmpty(elem)) {
            table.append(`
            <tr>
                <td class="not-editable">${_.get(elem, '0.product_id', '')} </th>
                <td class="not-editable">${_.get(elem, '0.product_code', '')} </td>
                <td class="not-editable">${_.get(elem, '0.model') || 0} </th>
                <td class="not-editable">${_.get(elem, '0.business_unit_name') || 0} </td>
                <td class="not-editable">${_.get(elem, '0.stock') || 0} </td>
                ${td}
            </tr>
          `);
        }
    });

    $('.table_inventories tbody tr td:not(.not-editable)').editable({
        send: 'always',
        type: 'text',
        url: '/php_action/inventoryUpdate.php',
        params: function (params) {
            var state = $(this).attr('data-state');
            params.year = 2021;
            params.state = state;

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
