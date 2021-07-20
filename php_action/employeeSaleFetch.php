<?php

require_once 'EmployeeSale.php';
require_once 'Agency.php';
require_once 'Stock.php';

$data = [];

$employeeId = $_SESSION['user_id'] ?? $_GET['userId'] ?? null;
$levelId = $_SESSION['level_id'] ?? $_GET['levelId'] ?? null;

$employeeLevel = $_GET['employee_level'] ?? null;

$channelId = $_GET['channel_id'] ?? null;
$channelName = $_GET['channel_name'] ?? null;
$businessUnitId = $_SESSION['business_unit_id'] ?? $_GET['business_unit_id'] ?? null;

$employeeSaleModel = new EmployeeSale();
$agencyModel = new Agency();
$stockModel = new Stock();

if ($employeeLevel == "Quản lý khu vực") {
    $options = $agencyModel->getAgencyOptions($employeeId);

    $agencies = array_column($agencyModel->getAgenciesByAMS($employeeId), 'id');

    $agencySales = $employeeSaleModel->getAgencySales($agencies, $businessUnitId);

    $data['agency_sales'] = $agencySales;
    $data['agencyOptions'] = $options;
} else if ($employeeLevel === 'Giám đốc kênh') {
    $options = $agencyModel->getAllAgencyOptionsByChannel($channelId);

    $agencies = array_column($options, 'value');

    $agencySales = $employeeSaleModel->getAgencySalesForChannelManager($agencies, $businessUnitId);

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
