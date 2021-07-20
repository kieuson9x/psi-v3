<?php

require_once 'core.php';

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fileName = "Bảng Số lượng mua-20_07_2021.xlsx";
    $basepath = $_SERVER["DOCUMENT_ROOT"];
    $path = $basepath . '\\excelData\\' . $fileName;
    $exists = file_exists($path);

    sleep(3);

    if (!unlink($path)) {
        echo ("$path cannot be deleted due to an error");
    } else {
        echo ("$path has been deleted");
    }
}
