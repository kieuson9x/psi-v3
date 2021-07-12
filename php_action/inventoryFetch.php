<?php

require_once 'Inventory.php';

$data = [];
$year = (int) ($_GET['year'] ?? date('Y'));
$data['year'] = $year;
$userId = $_GET['user_id'] ?? null;
$levelId = $_GET['levelId'] ?? null;

if ($levelId == "1" || $levelId == "2") {

    $year = $data['year'] ?? date('Y');
    
    $inventoryModel = new Inventory;

    $inventories = $inventoryModel->getInventories($year);
    
    $data['inventories'] = $inventories;

    echo json_encode($data);
}
