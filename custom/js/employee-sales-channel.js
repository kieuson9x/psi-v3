var table;
$(document).ready(function () {
    // top nav bar
    $('#nav-link-employee-sales').addClass('active');
    var userId = $('#user_id').val();
    bindingEmployeeSalesChannel(new Date().getFullYear());

    $('#filter').on('click', function () {
        var currentYear = new Date().getFullYear();
        bindingEmployeeSalesChannel(currentYear);
    });
});

function bindingEmployeeSalesChannel(year) {
    var userId = $('#user_id').val();
    var levelId = $('#level_id').val();
    var channel_id = $('#channel_id').val();
    var employee_level = $('#employee_level').val();
    var business_unit_id = $('#business_unit_id').val();
    var industry_id = $('#industry_id').val();
    var channel_name = $('#channel_name').val();
    var asmId = $('#asm-selection').val();

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
            channel_id: channel_id,
            asm_id: asmId
        },
        cache: false,
        dataType: 'json',
        success: function (response) {
            var { agency_sales, year, agencyOptions, asmOptions, asmId, sum_agency_sales } = response || {};
            var formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });

            if ($.fn.DataTable.isDataTable('#table_agency_sales_channel')) {
                $('#table_agency_sales_channel').DataTable().destroy();
            }

            var table = $('#table_agency_sales_channel tbody');
            table.empty();

            var asmSelection = $('#asm-selection');
            asmSelection.empty();

            if (!_.isEmpty(asmOptions)) {
                asmSelection.append('<option value="all">' + 'Tất cả' + '</option>');
                $.each(asmOptions, function (idx, option) {
                    if (asmId === option.value) {
                        asmSelection.append(
                            '<option value="' + option.value + '" selected>' + option.title + '</option>'
                        );
                    } else {
                        asmSelection.append('<option value="' + option.value + '">' + option.title + '</option>');
                    }
                });
            }

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

                    $('#table_agency_sales_channel tbody').append(`
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

            var sumTable = $('#table_total_agency_sales_channel tbody');
            sumTable.empty();

            if (sum_agency_sales) {
                var td = ``;
                var d = new Date();
                var n = d.getMonth();
                for (var i = n; i < 12; i++) {
                    td += `
                            <td class="not-editable">
                                ${formatter.format(_.get(sum_agency_sales, i + 1))}
                            </td>;
                    `;
                }

                sumTable.append(`
                        <tr>
                            ${td}
                        </tr>
              `);
            }
        } // /success function
    });
}
