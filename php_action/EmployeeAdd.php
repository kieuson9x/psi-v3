<?php

require_once 'core.php';
require_once 'Employee.php';

$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $employeeSaleModel = new Employee();

    $data = [
        'tennhanvien' => data_get($_POST, 'tennhanvien'),
        'manhanvien' => data_get($_POST, 'nhanvien'),
        'phongban' => data_get($_POST, 'phongban'),
        'donvi' => data_get($_POST, 'donvi'),
        'chucvu' => data_get($_POST, 'chucvu'),
    ];
    $createStatus = true;
    $createStatus = $employeeSaleModel->createEmployee($data);
    
    if ($createStatus) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
 