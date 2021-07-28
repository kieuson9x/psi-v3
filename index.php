<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");

if (!defined('URLROOT')) {
    define('URLROOT', 'http://psi-v3.test');
}

header('location:' . URLROOT . '/dashboard.php');
