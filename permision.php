<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Hệ thống báo cáo  PSI");
?>
<?php
require_once 'includes/header.php';
?>
<?php if (!in_array($_SESSION['employee_level'], ['Admin'])) : ?>
    <div class="row">
        <h4>Xin lỗi , Bạn không có quyền xem mục này.</h4>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header form-group">
                    <div class="form-group row">
                        <h4 for="year" class="col-xs-2 col-form-label mr-2">Danh sách Nhân viên</h4>
                        <div class="col-xs-2">
                            <a href="#addSaleModal" class="btn btn-success d-flex align-items-center justify-content " data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Thêm nhân viên</span></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped" id="table_agencies">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Tên nhân viên</td>
                                <td>Mã nhân viên</td>
                                <td>Phòng ban</td>
                                <td>Đơn vị</td>
                                <td>Chức vụ</td>
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
    <div id="addSaleModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="add_employee" method="POST" action="/php_action/employeeSaleCreate.php" class="form-horizontal">
                    <input type="hidden" id="tennhanvien" value="" />
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm mới nhân viên</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label>Tên nhân viên</label>
                            <select id="nhanvien-selection" class="form-control" required name="nhanvien" data-live-search="true" style="width: 100%"></select>
                            <div class="invalid-feedback">
                                Trường này bắt buộc nhập!
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Phòng Ban</label>
                            <select id="phongban-selection" class="form-control" required name="phongban" data-live-search="true" style="width: 100%"></select>
                            <div class="invalid-feedback">
                                Trường này bắt buộc nhập!
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Đơn vị</label>
                            <select id="donvi-selection" class="form-control" required name="donvi" data-live-search="true" style="width: 100%"></select>
                            <div class="invalid-feedback">
                                Trường này bắt buộc nhập!
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Chức vụ</label>
                            <select id="chucvu-selection" class="form-control" required name="chucvu" data-live-search="true" style="width: 100%"></select>
                            <div class="invalid-feedback">
                                Trường này bắt buộc nhập!
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="add_employee_btn" class="btn btn-success" data-dismiss="modal">Thêm</button>
                        <button type="button" id="cancel_add_agency_sale" class="btn btn-secondary mr-1" data-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>

        <script src="custom/js/employee.js"></script>
    <?php endif; ?>

    <?php require_once 'includes/footer.php'; ?>
    <? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>