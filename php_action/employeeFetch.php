<?php
require_once 'core.php';
require_once 'Employee.php';

$data = [];

	$userId = $_SESSION['user_id'] ?? null;

	$levelId = $_SESSION['level_id'] ?? null;
	
    $employeeModel = new Employee();

    $agencies = $employeeModel->getEmployADM();
    $data = [
        'agencies' => $agencies,
    ];


echo json_encode($data);
