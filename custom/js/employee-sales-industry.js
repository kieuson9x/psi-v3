var table;
$(document).ready(function () {
    // top nav bar
    $('#nav-link-employee-sales').addClass('active');
    var userId = $('#user_id').val();
    bindingEmployeeSaleIndustry(new Date().getFullYear());

    $('#filter').on('click', function () {
        var currentYear = new Date().getFullYear();
        bindingEmployeeSaleIndustry(currentYear);
    });
});

function bindingEmployeeSaleIndustry(year) {
    var userId = $('#user_id').val();
    var levelId = $('#level_id').val();
    var channel_id = $('#channel_id').val();
    var employee_level = $('#employee_level').val();
    var industry_id = $('#industry_id').val();
    var channel_name = $('#channel_name').val();
    var business_unit_id = $('#business-unit-selection').val();

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
        cache: false,
        dataType: 'json',
        success: function (response) {
            var { agency_sales, year, sum_agency_sales, businessUnitOptions, business_unit_id } = response || {};
            var formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });

            var businessUnitSelection = $('#business-unit-selection');
            businessUnitSelection.empty();

            if (!_.isEmpty(businessUnitOptions)) {
                $.each(businessUnitOptions, function (idx, option) {
                    if (business_unit_id === option.value) {
                        businessUnitSelection.append(
                            '<option value="' + option.value + '" selected>' + option.title + '</option>'
                        );
                    } else {
                        businessUnitSelection.append(
                            '<option value="' + option.value + '">' + option.title + '</option>'
                        );
                    }
                });
            }

            if ($.fn.DataTable.isDataTable('#table_agency_sales_industry')) {
                $('#table_agency_sales_industry').DataTable().destroy();
            }

            var table = $('#table_agency_sales_industry tbody');
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

                    $('#table_agency_sales_industry tbody').append(`
                            <tr>
                                <td class="not-editable">${_.get(sale, '0.product_id', '')} </td>
                                <td class="not-editable">${_.get(sale, '0.product_code', '')} </td>
                                <td class="not-editable">${_.get(sale, '0.model') || 0} </td>
                                <td class="not-editable">${_.get(sale, '0.business_unit_name') || 0} </td>
                                <td class="not-editable">${_.get(sale, '0.industry_name') || 0} </td>
                                <td class="not-editable">${_.get(sale, '0.product_type_name') || 0} </td>
                                <td class="not-editable">${_.get(sale, '0.agency_name') || 0} </td>
                                ${td}
                            </tr>
                    `);
                });

                $('#table_agency_sales_industry').DataTable({
                    destroy: true,
                    responsive: true,
                    ordering: false
                });
            }

            var sumTable = $('#table_total_agency_sales_industry tbody');
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
