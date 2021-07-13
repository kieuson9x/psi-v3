<?php
session_start();

require_once 'EmployeeSale.php';
require_once 'Agency.php';
require_once 'Stock.php';

$data = [];

$employeeId = $_SESSION['user_id'] ?? $_GET['userId'] ?? null;
$levelId = $_SESSION['level_id'] ?? $_GET['levelId'] ?? null;
$employeeLevel = $_SESSION['employee_level'] ?? null;

$employeeSaleModel = new EmployeeSale();
$agencyModel = new Agency();
$stockModel = new Stock();

if ($employeeLevel == "Quản lý khu vực") {
    $options = $agencyModel->getAgencyOptions($employeeId);

    $agencies = array_column($agencyModel->getAgenciesByAMS($employeeId), 'id');

    $agencySales = $employeeSaleModel->getAgencySales($agencies);

    $data['agency_sales'] = $agencySales;
    $data['agencyOptions'] = $options;
} else {
    $options = $agencyModel->getAllAgencyOptions();

    $agencies = array_column($agencyModel->getAllAgencies(), 'id');

    $agencySales = $employeeSaleModel->getAgencySales($agencies, $year);

    $data['agency_sales'] = $agencySales;
    $data['agencyOptions'] = $options;
}

echo json_encode($data);
