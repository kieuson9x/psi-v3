<?php
require_once 'EmployeeSale.php';
require_once 'Agency.php';

$data = [];
$year = (int) ($_GET['year'] ?? date('Y'));
$data['year'] = $year;

$employeeId = $_GET['userId'] ?? null;
$levelId = $_GET['levelId'] ?? null;

$employeeSaleModel = new EmployeeSale();
$agencyModel = new Agency();

if ($levelId == "1") {

    $options = $agencyModel->getAgencyOptions($employeeId);

    $year = $data['year'] ?? date('Y');
    $agencies = array_column($agencyModel->getAllAgencies(), 'id');

    $agencySales = $employeeSaleModel->getAgencySales($agencies, $year);

    $data['agency_sales'] = $agencySales;
    $data['agencyOptions'] = $options;
}
else {

    $options = $agencyModel->getAllAgencyOptions();

    $year = $data['year'] ?? date('Y');
    $agencies = array_column($agencyModel->getAgenciesByAMS($employeeId), 'id');

    $agencySales = $employeeSaleModel->getAgencySales($agencies, $year);

    $data['agency_sales'] = $agencySales;
    $data['agencyOptions'] = $options;
}

echo json_encode($data);
