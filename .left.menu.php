<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
global $APPLICATION;
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");


$aMenuLinks = array();
    $subArray =  Array(
        "Danh sách đại lý",
        "agencies.php",
        Array(),
        Array(),
        ""
    );
    array_push($aMenuLinks,$subArray);
    $subArray =  Array(
        "Bảng cập nhật số Sale",
        "employee-sales.php",
        Array(),
        Array(),
        ""
    );
    array_push($aMenuLinks,$subArray);

    $subArray =  Array(
        "Bảng nhập tồn kho",
        "inventories.php",
        Array(),
        Array(),
        ""
    );
    array_push($aMenuLinks,$subArray);
	
    $subArray =  Array(
        "Phân quyền",
        "permision.php",
        Array(),
        Array(),
        ""
    );
    array_push($aMenuLinks,$subArray);



?>

