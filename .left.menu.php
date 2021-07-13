<?
// if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
// global $APPLICATION;
// $APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");

$aMenuLinks = array();
$subArray =  array(
    "Danh sách đại lý",
    "agencies.php",
    array(),
    array(),
    ""
);
array_push($aMenuLinks, $subArray);
$subArray =  array(
    "Bảng cập nhật số Sale",
    "employee-sales.php",
    array(),
    array(),
    ""
);
array_push($aMenuLinks, $subArray);

$subArray =  array(
    "Bảng nhập tồn kho",
    "inventories.php",
    array(),
    array(),
    ""
);
array_push($aMenuLinks, $subArray);

$subArray =  array(
    "Phân quyền",
    "permision.php",
    array(),
    array(),
    ""
);
array_push($aMenuLinks, $subArray);
