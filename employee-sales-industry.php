<?
// require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
// $APPLICATION->SetTitle("Hệ thống báo cáo  PSI");
?>
<?php require_once 'includes/header.php'; ?>

<?php if (!in_array($_SESSION['employee_level'], ['Giám đốc ngành', 'Admin'])) : ?>
    <div class="row">
        <h4>Xin lỗi , Bạn không có quyền xem bảng này.</h4>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    Bảng sale theo ngành
                </div>
                <div class="card-body">
                    <div class="form-inline mb-5">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Đơn vị kinh doanh</label>
                            <select id="business-unit-selection" class="form-control" name="business-unit">
                            </select>

                            <button type="button" id="filter" class="btn btn-success ml-3">Lọc</button>
                        </div>
                    </div>
                    <table class="table table-striped" id="table_agency_sales_industry">
                        <thead>
                            <tr>
                                <td rowspan="2">ID</td>
                                <td rowspan="2">Mã VT</td>
                                <td rowspan="2">Model SP</td>
                                <td rowspan="2">ĐVKD</td>
                                <td rowspan="2">Ngành hàng</td>
                                <td rowspan="2">Nhóm hàng</td>
                                <td rowspan="2">Đại lý</td>
                                <?php $month = date('m');
                                for ($i = $month; $i <= 12; $i++) : ?>
                                    <th colspan="2"><?php echo "Tháng {$i}"; ?></th>
                                <?php endfor ?>
                            </tr>

                            <tr>
                                <?php $month = date('m');
                                for ($i = $month; $i <= 12; $i++) : ?>
                                    <th data-editable="true">SL</th>
                                    <th data-editable="true">Tiền</th>
                                <?php endfor ?>
                            </tr>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <!-- /table -->

                </div> <!-- /panel-body -->
            </div> <!-- /panel -->
        </div> <!-- /col-md-12 -->
    </div> <!-- /row -->

    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    Tổng tiền
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table_total_agency_sales_industry">
                        <thead>
                            <tr>
                                <?php $month = date('m');
                                for ($i = $month; $i <= 12; $i++) : ?>
                                    <th data-editable="false"><?php echo "Tháng" . $i ?></th>
                                <?php endfor ?>
                            </tr>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <!-- /table -->

                </div> <!-- /panel-body -->
            </div> <!-- /panel -->
        </div> <!-- /col-md-12 -->
    </div> <!-- /row -->

    <script src="custom/js/employee-sales-industry.js"></script>
<?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
<?
// require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>