<?php

require_once 'core.php';
require_once 'Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = strval($_POST['query'] ?? '');

    $businessUnitId = $_SESSION['business_unit_id'] ?? $_POST['business_unit_id'] ?? null;

    $productResult = [];

    $search_param = "%{$keyword}%";

    $productModel = new Product();
    $products = $productModel->searchProducts($search_param, $businessUnitId);

    $productOptions = array_map(function ($item) {
        return [
            'id' => $item->id,
            'text' => $item->business_unit_name . '-' . $item->name
        ];
    }, $products);

    echo json_encode($productOptions);
}
