<?php
session_start();

require_once 'Inventory.php';
require_once 'EmployeeSale.php';
require_once 'Stock.php';

$data = [];

$userId = $_SESSION['user_id'] ?? $_GET['user_id'] ?? null;
$levelId = $_SESSION['level_id'] ?? $_GET['levelId'] ?? null;
$employeeLevel = $_SESSION['employee_level'] ?? null;
$currentBusinessUnitCode = $_GET['currentBusinessUnitCode'] ?? null;

if ($employeeLevel == "Admin" || $employeeLevel == "Tài chính") {
    $inventoryModel = new Inventory;

    $inventories = $inventoryModel->getInventories($currentBusinessUnitCode);
    syncYear($inventories);
    $data['inventories'] = $inventories;

    echo json_encode($data);
}

function syncYear($inventories)
{
    $currentYear = (int) date('Y');
    $currentMonth = (int) date('m');

    $employeeSaleModel = new EmployeeSale();
    $inventoryModel = new Inventory();
    $stockModel = new Stock();

    foreach ($inventories as $product) {
        $productId = data_get($product, '0.product_id');
        $stockValue = (int) data_get($stockModel->getStockByProductId($productId), 'stock', 0);

        foreach ($product as $key => $inventoryByMonth) {
            $month = (int) data_get($inventoryByMonth, 'month');
            $number_of_imported_goods = (int) data_get($inventoryByMonth, 'number_of_imported_goods');
            $date = date("{$currentYear}-${month}-1");

            $previousMonth = (int) date('m', strtotime('-1 months', strtotime($date)));
            $previousYear = (int) date('Y', strtotime('-1 months', strtotime($date)));

            $previousInventory = $inventoryModel->findInventory($productId, $previousMonth, $previousYear);

            $totalSales = $employeeSaleModel->getTotalSalesByProduct($productId, $month, $currentYear);
            $totalProductSales = $totalSales->total_product_sales ?? 0;

            $numberOfPreviousInventory = $month === $currentMonth ? $stockValue : data_get($previousInventory, 'number_of_remaining_goods', 0);
            $inventoryModel->syncRemainingGoods($productId, $month, $currentYear, $totalProductSales, $number_of_imported_goods, $numberOfPreviousInventory);
        }
    }

    // for ($i = $currentMonth - 1; $i < 12; $i++) {
    //     $month = $i + 1;
    //     $date = date("{$currentYear}-${month}-1");

    //     $previousMonth = (int) date('m', strtotime('-1 months', strtotime($date)));
    //     $previousYear = (int) date('Y', strtotime('-1 months', strtotime($date)));

    //     $inventory = $inventoryModel->findInventory($data['product_id'], $month, $currentYear);

    //     $totalSales = $employeeSaleModel->getTotalSalesByProduct($data['product_id'], $month, $data['year']);
    //     $totalProductSales = $totalSales->total_product_sales ?? 0;

    //     $previousInventory = $inventoryModel->findInventory($data['product_id'], $previousMonth, $previousYear);
    //     $currentInventory = $inventoryModel->findInventory($data['product_id'], $month, $year);

    //     $numberOfPreviousInventory = data_get($previousInventory, 'number_of_remaining_goods', 0);
    //     $inventoryModel->syncRemainingGoods($data['product_id'], $month, $year, $totalProductSales, $currentInventory->number_of_imported_goods, $numberOfPreviousInventory);
    // }
}
