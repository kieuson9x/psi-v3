<?php

require_once 'core.php';
require_once 'Agency.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $agencyModel = new Agency();

    $agencies = $agencyModel->getEmployee();

    $agenciesOptions = array_map(function ($item) {
        return [
            'id' => $item->id,
            'text' => $item->full_name
        ];
    }, $agencies);

    echo json_encode($agenciesOptions);
}
