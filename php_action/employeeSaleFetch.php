<?php

require_once 'EmployeeSale.php';
require_once 'Agency.php';
require_once 'Stock.php';
require_once 'Employee.php';
require_once 'BusinessUnit.php';

$data = [];

$employeeId = $_SESSION['user_id'] ?? $_GET['userId'] ?? null;
$levelId = $_SESSION['level_id'] ?? $_GET['levelId'] ?? null;

$employeeLevel = $_GET['employee_level'] ?? null;

$channelId = $_GET['channel_id'] ?? null;
$channelName = $_GET['channel_name'] ?? null;
$businessUnitId =  $_GET['business_unit_id'] ?? $_SESSION['business_unit_id'] ?? null;

$employeeSaleModel = new EmployeeSale();
$agencyModel = new Agency();
$stockModel = new Stock();
$employeeModel = new Employee();
$businessUnitModel = new BusinessUnit();


$asmId = $_GET['asm_id'] ?? null;
$industryId = $_GET['industry_id'] ?? null;

switch ($employeeLevel) {
    case 'Quản lý khu vực':
        $options = $agencyModel->getAgencyOptions($employeeId);

        $agencies = array_column($agencyModel->getAgenciesByAMS($employeeId), 'id');

        $agencySales = $employeeSaleModel->getAgencySales($agencies, $businessUnitId);

        $data['agency_sales'] = $agencySales;
        $data['agencyOptions'] = $options;
        break;

    case 'Giám đốc kênh':
        if ($asmId && $asmId !== 'all') {
            $options = $agencyModel->getAllAgencyOptionsByAsm($asmId);
        } else {
            $options = $agencyModel->getAllAgencyOptionsByChannel($channelId);
        }

        $data['asmId'] = $asmId;

        $agencies = array_column($options, 'value');

        $agencySales = $employeeSaleModel->getAgencySalesForChannelManager($agencies, $businessUnitId, $asmId);

        $data['agency_sales'] = $agencySales;

        $data['sum_agency_sales'] = [];
        $currentMonth = (int) date('m');


        for ($i = $currentMonth; $i <= 12; $i++) {
            $data['sum_agency_sales'][$i] = 0;

            foreach ($agencySales as $product) {
                $key = array_search($i, array_column($product, 'month'));

                if ($key !== false) {
                    $data['sum_agency_sales'][$i] += (int) ($product[$key]->calculated_price ?? 0);
                }
            }
        }

        $data['agencyOptions'] = array_map(function ($item) {
            return [
                'title' => $item['title'],
                'value' => $item['value'],
            ];
        }, $options);

        $data['asmOptions'] = $employeeModel->getASMOptionsByChannelId($channelId);
        break;
    case "Giám đốc ngành":
        $businessUnitId =  $_GET['business_unit_id'] ?? "";
        $businessUnitId =  !empty($businessUnitId) ? $businessUnitId : 'all';

        $agencySales = $employeeSaleModel->getAgencySalesForIndustryManager($industryId, $businessUnitId);
        $data['agency_sales'] = $agencySales;

        $data['sum_agency_sales'] = [];
        $currentMonth = (int) date('m');


        for ($i = $currentMonth; $i <= 12; $i++) {
            $data['sum_agency_sales'][$i] = 0;

            foreach ($agencySales as $product) {
                $key = array_search($i, array_column($product, 'month'));

                if ($key !== false) {
                    $data['sum_agency_sales'][$i] += (int) ($product[$key]->calculated_price ?? 0);
                }
            }
        }
        $data['businessUnitOptions'] = [];
        array_push($data['businessUnitOptions'], [
            'title' => "Tất cả",
            'value' => "all",
        ]);
        $data['businessUnitOptions'] = array_merge($data['businessUnitOptions'], $businessUnitModel->getBusinessUnitOptions());

        $data['business_unit_id'] = $businessUnitId;

        break;
    default:
        $options = $agencyModel->getAllAgencyOptions();

        $agencies = array_column($agencyModel->getAllAgencies(), 'id');

        $agencySales = $employeeSaleModel->getAgencySales($agencies, $businessUnitId);

        $data['agency_sales'] = $agencySales;
        $data['agencyOptions'] = $options;
        break;
}

echo json_encode($data);
