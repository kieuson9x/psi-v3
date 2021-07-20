<?php
require_once 'Agency.php';

$data = [];
$userId = $_SESSION['user_id'] ?? $_GET['user_id'] ?? null;
$levelId = $_SESSION['level_id'] ?? $_GET['levelId'] ?? null;
$employeeLevel = $_SESSION['employee_level'] ?? $_GET['employee_level'] ?? null;
$channelId = $_SESSION['channel_id'] ?? null;
$industryId = $_SESSION['industry_id'] ?? null;

$agencyModel = new Agency();

$agencies = [];

if ($employeeLevel === 'Admin') {
    $agencies = $agencyModel->getAgenciesByADM();
} else if ($employeeLevel == 'Giám đốc kênh') {
    $agencies = $agencyModel->getAgenciesByChannel($channelId);
} else if ($employeeLevel == 'Giám đốc ngành') {
    $agencies = $agencyModel->getAgenciesByIndustry($industryId);
} else {
    $agencies = $agencyModel->getAgenciesByAMS($userId);
}

$data = [
    'agencies' => $agencies,
];

echo json_encode($data);
