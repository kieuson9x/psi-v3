<?php

require_once 'core.php';
require_once 'Employee.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $employeeModel = new Employee();

    $agencies = $employeeModel->getEmployee();

    $agenciesOptions = array_map(function ($item) {
        return [
            'id' => $item->UF_EMPLOYEE_CODE,
            'text' => $item->login
        ];
    }, $agencies);

    echo json_encode($agenciesOptions);
}
