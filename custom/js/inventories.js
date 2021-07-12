var table;
$(document).ready(function () {
    // top nav bar
    $('#nav-link-inventory').addClass('active');

    bindingInventories(new Date().getFullYear());

    $('#btnFilterInventories')
        .unbind('click')
        .bind('click', function () {
            var currentYear = $('#year-selection').val();
            bindingInventories(currentYear);
        });

    $('#product-selection').select2({
        placeholder: 'Chọn sản phẩm',
        ajax: {
            url: '/psi/php_action/productSearch.php',
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
                url: '/psi/php_action/inventoryCreate.php',
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
                    $('#table_inventories').DataTable({
                    destroy: true,
                    responsive: true,
                    ordering: false
                });

                $('#table_inventories tbody tr td:not(.not-editable)').editable({
                    send: 'always',
                    type: 'text',
                    url: '/psi/php_action/inventoryUpdate.php',
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
                        } else {
                            toastr.error('Cập nhật không thành công!');
                        }
                    },
                    ajaxOptions: {
                        type: 'POST',
                        dataType: 'json'
                    }
                });
});

function bindingInventories(year) {
	var userId = $("#user_id").val();
    var levelId = $("#level_id").val();
    $.ajax({
        url: '/psi/php_action/inventoryFetch.php',
        type: 'get',
        data: {
            userId: userId,
            levelId:levelId,
            year: year
        },
        dataType: 'json',
        success: function (response) {
            var { inventories, year } = response || {};

            if (year) {
                $('#year-selection option, #year-selection_create option').each(function () {
                    if ($(this).val() == year) {
                        $(this).attr('selected', 'selected');
                    }
                });
            }

            if (inventories) {
                var table = $('#table_inventories tbody');
                table.empty();

                $.each(inventories, function (idx, elem) {
                    var td = ``;
                    var d = new Date();
                    var n = d.getMonth();
                    for (var i = n; i < 12; i++) {
                        td += `
                    <td data-type="text" data-state="purchase" data-name="${i + 1}" data-pk="${_.get(
                            elem,
                            `${i + 1}.product_id`
                        )}">
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

                    <td data-type="text" data-state="inventory" data-name="${i + 1}" data-pk="${_.get(
                            elem,
                            `${i + 1}.product_id`
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

                    table.append(`
                <tr>
                    <td class="not-editable">${_.get(elem, '0.product_id', '')} </th>
                    <td class="not-editable">${_.get(elem, '0.model') || 0} </th>
                    ${td}
                </tr>
              `);
                });
            }
        } // /success function
    });
}
