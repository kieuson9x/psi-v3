<?php

require_once 'core.php';
require_once 'EmployeeSale.php';

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $employeeSaleModel = new EmployeeSale();

    $data = [
        'tendaily' => data_get($_POST, 'tendaily'),
        'tinh' => data_get($_POST, 'tinh'),
        'nhanvien' => data_get($_POST, 'nhanvien'),
    ];
    $createStatus = true;
    $createStatus = $employeeSaleModel->createagency($data);
    
    if ($createStatus) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
 