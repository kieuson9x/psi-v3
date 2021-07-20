<?php

require_once 'core.php';
require_once 'Inventory.php';
include_once($_SERVER['DOCUMENT_ROOT'] . "xlsxwriter.class.php");

$userId = $_SESSION['user_id'] ?? $_GET['user_id'] ?? null;
$levelId = $_SESSION['level_id'] ?? $_GET['levelId'] ?? null;
$employeeLevel = $_SESSION['employee_level'] ?? $_GET['employee_level'] ?? null;

if ($employeeLevel == "Admin" || $employeeLevel == "Tài chính") {
    $sheets = ['VU1', 'DAN', 'HCM'];
    $writer = new XLSXWriter();

    foreach ($sheets as $current_sheet) {
        $header = array(
            'ID' => 'string',
            'Mã VT' => 'string',
            'Mã SP' => 'string',
            'ĐVKD' => 'string',
            'Tồn' => 'string',
        );

        $currentMonth = (int) date('m');

        for ($i = $currentMonth - 1; $i < 12; $i++) {
            $header['Tháng ' . ($i + 1)] = 'string';
        }

        //new writer
        $row1 = array("ID", "Mã VT", "Mã SP", "ĐVKD", "Tồn");

        for ($i = $currentMonth - 1; $i < 12; $i++) {
            array_push($row1, 'Tháng ' . ($i + 1));
            array_push($row1, " ");
            array_push($row1, " ");
        }

        $row2 = array("", "", "", "", "");

        for ($i = 0; $i <= 12 - $currentMonth; $i++) {
            array_push($row2, "P");
            array_push($row2, "S");
            array_push($row2, "I");
        }

        $writer->writeSheetHeader($current_sheet, $header, $suppress_header_row = true);   //write header
        for ($i = 0; $i < 5; $i++) {
            $writer->markMergedCell($current_sheet, $start_row = 0, $start_col = $i, $end_row = 1, $end_col = $i);
        }

        $j = 5;
        for ($i = 0; $i <= 12 - $currentMonth; $i++) {
            $writer->markMergedCell($current_sheet, $start_row = 0, $start_col = $j, $end_row = 0, $end_col = $j + 2);
            $j += 3;
        }

        $writer->writeSheetRow($current_sheet, $row1, [
            'valign' => 'center',
            'halign' => 'center',
            'border' => 'left,right,top,bottom',
            'border-style' => 'thin',
            'font-style' => 'bold'
        ]);

        $writer->writeSheetRow($current_sheet, $row2, [
            'valign' => 'center',
            'halign' => 'center',
            'border' => 'left,right,top,bottom',
            'border-style' => 'thin',
            'font-style' => 'bold'
        ]);

        $inventoryModel = new Inventory;
        $inventories = $inventoryModel->getInventories($current_sheet);

        foreach ($inventories as $key => $product) {
            $product_id = data_get($product, '0.product_id');
            $product_code = data_get($product, '0.product_id');
            $model = data_get($product, '0.model');
            $business_unit_name = data_get($product, '0.business_unit_name');
            $stock = data_get($product, '0.stock', 0);

            $row = array($product_id, $product_code, $model, $business_unit_name, $stock);

            for ($i = 0; $i <= 12 - $currentMonth; $i++) {
                $pValue = data_get($product, "{$i}.number_of_imported_goods", 0);
                $sValue = data_get($product, "{$i}.number_of_sale_goods", 0);
                $iValue = data_get($product, "{$i}.number_of_remaining_goods", 0);

                array_push($row, $pValue);
                array_push($row, $sValue);
                array_push($row, $iValue);
            }

            $writer->writeSheetRow($current_sheet, $row, [
                'valign' => 'center',
                'halign' => 'center',
                'border' => 'left,right,top,bottom',
                'border-style' => 'thin'
            ]);
        }
    }
    $fileName = 'Bảng Số lượng mua-' . date('d_m_Y') . '.xlsx';

    $writer->writeToFile('..\\excelData\\' . $fileName);

    echo json_encode(['file_url' => URLROOT . '/excelData/' . $fileName, 'file_name' => $fileName]);
} else {
    echo json_encode(['error' => "Không được phép truy cập"]);
}
