<?php
session_start();
require_once 'Agency.php';

$data = [];
$userId = $_SESSION['user_id'] ?? $_GET['user_id'] ?? null;
$levelId = $_SESSION['level_id'] ?? $_GET['levelId'] ?? null;
$agencyModel = new Agency();

if ($levelId == "1") {
    $agencies = $agencyModel->getAgenciesByADM();
} else {
    $agencies = $agencyModel->getAgenciesByAMS($userId);
}

$data = [
    'agencies' => $agencies,
];

echo json_encode($data);
