var table;
$(document).ready(function () {
    // top nav bar
    $('#nav-link-employee-sales').addClass('active');
    var userId = $('#user_id').val();
    bindingEmployeeSalesChannel(new Date().getFullYear());

    $('#btnFilterEmployeeSales')
        .unbind('click')
        .bind('click', function () {
            var currentYear = $('#year-selection').val();
            bindingEmployeeSalesChannel(currentYear);
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
});

function bindingEmployeeSalesChannel(year) {
    var userId = $('#user_id').val();
    var levelId = $('#level_id').val();
    $.ajax({
        url: '/php_action/employeeSaleFetch.php',
        type: 'get',
        data: {
            userId: userId,
            levelId: levelId,
            year: year
        },
        dataType: 'json',
        success: function (response) {
            var { agency_sales, year, agencyOptions } = response || {};
            var formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
            var table = $('#table_agency_sales_channel tbody');
            table.empty();

            if (!_.isEmpty(agency_sales)) {
                $.each(agency_sales, function (idx, sale) {
                    var td = ``;
                    var d = new Date();
                    var n = d.getMonth();
                    for (var i = n; i < 12; i++) {
                        td += `
                            <td class="not-editable" data-type="text" data-state="sale" data-agency-id="${_.get(
                                sale,
                                '0.agency_id'
                            )}" data-name="${i + 1}" data-pk="${_.get(sale, '0.product_id')}">
                                ${
                                    _.get(
                                        _.find(sale, (o) => parseInt(o.month) === i + 1),
                                        'number_of_sale_goods'
                                    ) || 0
                                }
                            </td>;
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
                            <td class="not-editable">${_.get(sale, '0.full_name') || 0} </td>

                            <td class="not-editable">${_.get(sale, '0.stock') || 0} </td>
                            ${td}
                        </tr>
              `);
                });

                $('#table_agency_sales_channel').DataTable({
                    destroy: true,
                    responsive: true,
                    ordering: false
                });
            }
        } // /success function
    });
}
