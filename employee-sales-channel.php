<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Hệ thống báo cáo  PSI");
?>
<?php require_once 'includes/header.php'; ?>

<?php if (!in_array($_SESSION['employee_level'], ['Giám đốc kênh', 'Admin'])) : ?>
    <div class="row">
        <h4>Xin lỗi , Bạn không có quyền xem bảng này.</h4>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    Bảng sale theo kênh
                </div>
                <div class="card-body">

                    <div class="form-inline mb-5">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">ASM</label>
                            <select id="asm-selection" class="form-control" name="asm">
                            </select>

                            <button type="button" id="filter" class="btn btn-success ml-3">Lọc</button>
                        </div>
                    </div>


                    <table class="table table-striped" id="table_agency_sales_channel">
                        <thead>
                            <tr>
                                <td rowspan="2">ID</td>
                                <td rowspan="2">Mã VT</td>
                                <td rowspan="2">Model SP</td>
                                <!-- <td>Model</td> -->
                                <td rowspan="2">ĐVKD</td>
                                <!-- <td>Ngành hàng</td> -->
                                <!-- <td>Nhóm hàng</td> -->
                                <td rowspan="2">Đại lý</td>
                                <td rowspan="2">ASM</td>
                                <td rowspan="2">Tồn</td>
                                <?php $month = date('m');
                                for ($i = $month; $i <= 12; $i++) : ?>
                                    <th colspan="2"><?php echo "Tháng {$i}"; ?></th>
                                <?php endfor ?>
                            </tr>

                            <tr>
                                <?php $month = date('m');
                                for ($i = $month; $i <= 12; $i++) : ?>
                                    <th data-editable="true">SL</th>
                                    <th data-editable="true">Tổng tiền</th>
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
                    <table class="table table-striped" id="table_total_agency_sales_channel">
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

    <script src="custom/js/employee-sales-channel.js"></script>
<?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>