<?php

require_once 'core.php';
require_once 'Employee.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $employeeModel = new Employee();

    $agencies = $employeeModel->getchucvu();

    $agenciesOptions = array_map(function ($item) {
        return [
            'id' => $item->id,
            'text' => $item->name
        ];
    }, $agencies);

    echo json_encode($agenciesOptions);
}
