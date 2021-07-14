<?php
// require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
// $APPLICATION->SetTitle("Hệ thống báo cáo  PSI");
?>
<?php require_once 'includes/header.php'; ?>

<div class="row">
    <div class="col-md-12" style="margin-bottom: 15px;">
        <div class="card ">
            <div class="card-header">
                Chức năng
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <button id="btnFilterInventories" type="button" class="btn btn-primary mr-1 w-40  d-flex align-items-center justify-content">
                        <i class="material-icons">refresh</i>
                        Đồng bộ CSDL
                    </button>

                    <div class="col-xs-4">
                        <a href="#addProductPlanModal" class="btn btn-success d-flex align-items-center justify-content " data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Thêm/Cập nhật số nhập
                                mới</span></a>
                    </div>
                </div>
            </div> <!-- /panel-body -->
        </div> <!-- /panel -->
    </div> <!-- /col-md-12 -->

    <div class="col-md-12" style="margin-bottom: 15px;">
        <div class="card ">
            <div class="card-header">
                VU1
            </div>
            <div class="card-body">
                <table class="table table-striped table_inventories" id="inventories_VU1">
                    <thead>
                        <tr>
                            <td rowspan="2">ID</td>
                            <td rowspan="2">Mã VT</td>
                            <td rowspan="2">Mã sản phẩm</td>
                            <td rowspan="2">ĐVKD</td>
                            <td rowspan="2">Tồn</td>
                            <?php $month = date('m');
                            for ($i = $month; $i <= 12; $i++) : ?>
                                <th data-editable="true" colspan="3"><?php echo "Tháng {$i}"; ?></th>

                            <?php endfor ?>
                        </tr>

                        <tr>
                            <?php $month = date('m');
                            for ($i = $month; $i <= 12; $i++) : ?>
                                <th data-editable="true">P</th>
                                <th>S</th>
                                <th data-editable="true">I</th>
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

    <div class="col-md-12" style="margin-bottom: 15px;">
        <div class="card ">
            <div class="card-header">
                DAN
            </div>
            <div class="card-body">
                <table class="table table-striped table_inventories" id="inventories_DAN">
                    <thead>
                        <tr>
                            <td rowspan="2">ID</td>
                            <td rowspan="2">Mã VT</td>
                            <td rowspan="2">Mã sản phẩm</td>
                            <td rowspan="2">ĐVKD</td>
                            <td rowspan="2">Tồn</td>
                            <?php $month = date('m');
                            for ($i = $month; $i <= 12; $i++) : ?>
                                <th data-editable="true" colspan="3"><?php echo "Tháng {$i}"; ?></th>

                            <?php endfor ?>
                        </tr>

                        <tr>
                            <?php $month = date('m');
                            for ($i = $month; $i <= 12; $i++) : ?>
                                <th data-editable="true">P</th>
                                <th>S</th>
                                <th data-editable="true">I</th>
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

    <div class="col-md-12" style="margin-bottom: 15px;">
        <div class="card ">
            <div class="card-header">
                HCM
            </div>
            <div class="card-body">
                <table class="table table-striped table_inventories" id="inventories_HCM">
                    <thead>
                        <tr>
                            <td rowspan="2">ID</td>
                            <td rowspan="2">Mã VT</td>
                            <td rowspan="2">Mã sản phẩm</td>
                            <td rowspan="2">ĐVKD</td>
                            <td rowspan="2">Tồn</td>
                            <?php $month = date('m');
                            for ($i = $month; $i <= 12; $i++) : ?>
                                <th data-editable="true" colspan="3"><?php echo "Tháng {$i}"; ?></th>

                            <?php endfor ?>
                        </tr>

                        <tr>
                            <?php $month = date('m');
                            for ($i = $month; $i <= 12; $i++) : ?>
                                <th data-editable="true">P</th>
                                <th>S</th>
                                <th data-editable="true">I</th>
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

<!-- add product plan -->
<div id="addProductPlanModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="add_inventory" method="POST" action="/php_action/inventoryCreate.php" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm/cập nhật số lượng nhập</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label>Sản phẩm</label>
                        <select id="product-selection" class="form-control" required name="product_id" data-live-search="true" style="width: 100%"></select>
                        <div class="invalid-feedback">
                            Trường này bắt buộc nhập!
                        </div>
                    </div>

                    <div class="form-group row">
                        <label>Năm</label>
                        <select id="year-selection_create" class="form-control" id="year" name="year" required>
                            <?php for ($i = date('Y'); $i <= date('Y'); $i++) : ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                            <?php endfor ?>
                        </select>
                        <div class="invalid-feedback">
                            Trường này bắt buộc nhập!
                        </div>
                    </div>

                    <div class="form-group row">
                        <label>Tháng</label>
                        <div class="form-group">
                            <?php $month = date('m');
                            for ($i = $month; $i <= 12; $i++) : ?>
                                <div id="month-selection" class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="months[]" value="<?php echo $i ?>">
                                    <label class="form-check-label" for="month_<?php echo $i ?>">Tháng <?php echo $i ?></label>
                                </div>
                            <?php endfor ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label>Số lượng nhập</label>
                        <input type="text" class="form-control" name="number_of_imported_goods" required>
                        <div class="invalid-feedback">
                            Trường này bắt buộc nhập!
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" id="add_inventory" class="btn btn-success" data-dismiss="modal">Thêm</button>
                    <button type="button" id="cancel_add_inventory" class="btn btn-secondary mr-1" data-dismiss="modal">Huỷ</button>
                </div>
            </form>
        </div>
    </div>

    <script src="custom/js/inventories.js"></script>

    <?php require_once 'includes/footer.php'; ?>
    <?php
    // require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
    ?>