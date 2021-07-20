<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Hệ thống báo cáo  PSI");
?>
<?php require_once 'includes/header.php'; ?>

<?php if (!in_array($_SESSION['employee_level'], ['Quản lý khu vực', 'Admin', "Giám đốc kênh"])) : ?>
    <div class="row">
        <h4>Xin lỗi , Bạn không có quyền xem danh sách đại lý.</h4>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    Danh sách đại lý
                </div>

                <div class="card-body">
                    <table class="table table-striped" id="table_agencies">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Tên đại lý</td>
                                <td>Tỉnh</td>
                                <td>ASM</td>
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
                <form name="add_agency" method="POST" action="/php_action/employeeSaleCreate.php" class="form-horizontal">
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm đại lý</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label>Tên đại lý</label>
                            <input type="text" class="form-control" name="tendaily" id="tendaily" required>
                            <div class="invalid-feedback">
                                Trường này bắt buộc nhập!
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Tỉnh thành</label>
                            <select class="form-control" required name="tinh" data-live-search="true" style="width: 100%">
                                <option value="Thành phố Hà Nội">Thành phố Hà Nội</option>

                                <option value="Tỉnh Hà Giang">Tỉnh Hà Giang</option>

                                <option value="Tỉnh Cao Bằng">Tỉnh Cao Bằng</option>

                                <option value="Tỉnh Bắc Kạn">Tỉnh Bắc Kạn</option>

                                <option value="Tỉnh Tuyên Quang">Tỉnh Tuyên Quang</option>

                                <option value="Tỉnh Lào Cai">Tỉnh Lào Cai</option>

                                <option value="Tỉnh Điện Biên">Tỉnh Điện Biên</option>

                                <option value="Tỉnh Lai Châu">Tỉnh Lai Châu</option>

                                <option value="Tỉnh Sơn La">Tỉnh Sơn La</option>

                                <option value="Tỉnh Yên Bái">Tỉnh Yên Bái</option>

                                <option value="Tỉnh Hoà Bình">Tỉnh Hoà Bình</option>

                                <option value="Tỉnh Thái Nguyên">Tỉnh Thái Nguyên</option>

                                <option value="Tỉnh Lạng Sơn">Tỉnh Lạng Sơn</option>

                                <option value="Tỉnh Quảng Ninh">Tỉnh Quảng Ninh</option>

                                <option value="Tỉnh Bắc Giang">Tỉnh Bắc Giang</option>

                                <option value="Tỉnh Phú Thọ">Tỉnh Phú Thọ</option>

                                <option value="Tỉnh Vĩnh Phúc">Tỉnh Vĩnh Phúc</option>

                                <option value="Tỉnh Bắc Ninh">Tỉnh Bắc Ninh</option>

                                <option value="Tỉnh Hải Dương">Tỉnh Hải Dương</option>

                                <option value="Thành phố Hải Phòng">Thành phố Hải Phòng</option>

                                <option value="Tỉnh Hưng Yên">Tỉnh Hưng Yên</option>

                                <option value="Tỉnh Thái Bình">Tỉnh Thái Bình</option>

                                <option value="Tỉnh Hà Nam">Tỉnh Hà Nam</option>

                                <option value="Tỉnh Nam Định">Tỉnh Nam Định</option>

                                <option value="Tỉnh Ninh Bình">Tỉnh Ninh Bình</option>

                                <option value="Tỉnh Thanh Hóa8">Tỉnh Thanh Hóa</option>

                                <option value="Tỉnh Nghệ An">Tỉnh Nghệ An</option>

                                <option value="Tỉnh Hà Tĩnh">Tỉnh Hà Tĩnh</option>

                                <option value="Tỉnh Quảng Bình">Tỉnh Quảng Bình</option>

                                <option value="Tỉnh Quảng Trị">Tỉnh Quảng Trị</option>

                                <option value="Tỉnh Thừa Thiên Huế">Tỉnh Thừa Thiên Huế</option>

                                <option value="Thành phố Đà Nẵng">Thành phố Đà Nẵng</option>

                                <option value="Tỉnh Quảng Nam">Tỉnh Quảng Nam</option>

                                <option value="Tỉnh Quảng Ngãi">Tỉnh Quảng Ngãi</option>

                                <option value="Tỉnh Bình Định">Tỉnh Bình Định</option>

                                <option value="Tỉnh Phú Yên">Tỉnh Phú Yên</option>

                                <option value="Tỉnh Khánh Hòa">Tỉnh Khánh Hòa</option>

                                <option value="Tỉnh Ninh Thuận">Tỉnh Ninh Thuận</option>

                                <option value="Tỉnh Bình Thuận">Tỉnh Bình Thuận</option>

                                <option value="Tỉnh Kon Tum">Tỉnh Kon Tum</option>

                                <option value="Tỉnh Gia Lai">Tỉnh Gia Lai</option>

                                <option value="Tỉnh Đắk Lắk">Tỉnh Đắk Lắk</option>

                                <option value="Tỉnh Đắk Nông">Tỉnh Đắk Nông</option>

                                <option value="Tỉnh Lâm Đồng">Tỉnh Lâm Đồng</option>

                                <option value="Tỉnh Bình Phước">Tỉnh Bình Phước</option>

                                <option value="Tỉnh Tây Ninh">Tỉnh Tây Ninh</option>

                                <option value="Tỉnh Bình Dương">Tỉnh Bình Dương</option>

                                <option value="Tỉnh Đồng Nai">Tỉnh Đồng Nai</option>

                                <option value="Tỉnh Bà Rịa - Vũng Tàu">Tỉnh Bà Rịa - Vũng Tàu</option>

                                <option value="Thành phố Hồ Chí Minh">Thành phố Hồ Chí Minh</option>

                                <option value="Tỉnh Long An">Tỉnh Long An</option>

                                <option value="Tỉnh Tiền Giang">Tỉnh Tiền Giang</option>

                                <option value="Tỉnh Bến Tre">Tỉnh Bến Tre</option>

                                <option value="Tỉnh Trà Vinh">Tỉnh Trà Vinh</option>

                                <option value="Tỉnh Vĩnh Long">Tỉnh Vĩnh Long</option>

                                <option value="Tỉnh Đồng Tháp">Tỉnh Đồng Tháp</option>

                                <option value="Tỉnh An Giang">Tỉnh An Giang</option>

                                <option value="Tỉnh Kiên Giang">Tỉnh Kiên Giang</option>

                                <option value="Thành phố Cần Thơ">Thành phố Cần Thơ</option>

                                <option value="Tỉnh Hậu Giang">Tỉnh Hậu Giang</option>

                                <option value="Tỉnh Sóc Trăng">Tỉnh Sóc Trăng</option>

                                <option value="Tỉnh Bạc Liêu">Tỉnh Bạc Liêu</option>

                                <option value="Tỉnh Cà Mau">Tỉnh Cà Mau</option>

                            </select>
                            <div class="invalid-feedback">
                                Trường này bắt buộc nhập!
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Nhân viên</label>
                            <select id="nhanvien-selection" class="form-control" required name="nhanvien" data-live-search="true" style="width: 100%"></select>
                            <div class="invalid-feedback">
                                Trường này bắt buộc nhập!
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="add_agency_btn" class="btn btn-success" data-dismiss="modal">Thêm</button>
                        <button type="button" id="cancel_add_agency_sale" class="btn btn-secondary mr-1" data-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>

        <script src="custom/js/agencies.js"></script>
    <?php endif; ?>
    <?php require_once 'includes/footer.php'; ?>
    <? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>