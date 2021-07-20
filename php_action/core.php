<?php
session_start();
require_once 'db_connect.php';

if (!defined('URLROOT')) {
	define('URLROOT', 'http://psi-v3.test');
}

$user_code = 'taichinh';
//giam_doc_kenh_MT_TBNB : giam doc kenh
//tai chinh : KR03196;
//ASM mien nam : KR01427
//ASM tap doan : 'KR00005';
/*$id_user = $_SESSION['SESS_AUTH']['USER_ID'];

		$sql = "SELECT UF_EMPLOYEE_CODE FROM b_uts_user WHERE VALUE_ID = $id_user";
		$statement = $connect->prepare($sql);
		$statement->execute();
		$kr = $statement->fetch(PDO::FETCH_ASSOC);

		$sql = 'SELECT * FROM psi_employees WHERE user_code = :user_code';
		$statement = $connect->prepare($sql);
		$statement->execute(['user_code' => $kr['UF_EMPLOYEE_CODE']]);*/
//if (!($_SESSION['user_id'] ?? false)) {
$sql = "SELECT * FROM psi_employees WHERE user_code = '{$user_code}'"; //KR01697 //taichinh //giam_doc_kenh_MT_TBNB //giam_doc_kenh_MT_VLXD //giam_doc_nganh_vlxd
$statement = $connect->prepare($sql);
$statement->execute();

if ($statement->rowCount() > 0) {
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	$_SESSION['user_id'] = $row['id'];
	$_SESSION['full_name'] = $row['full_name'];
	$_SESSION['level_id'] = $row['level_id'];

	// Get employee level
	$_SESSION['employee_level'] = getEmployeeLevel($connect, $row['level_id']);

	$_SESSION['channel_id'] =  $row['channel_id'];
	$_SESSION['channel_name'] = getChannel($connect, $row['channel_id']);

	$_SESSION['business_unit_id'] =  $row['business_unit_id'];

	$_SESSION['industry_id'] = getIndustryId($connect, $row['channel_id']);
} else {
	echo "<h2>Bạn không được phân quyền mục này</h2>";
}
//}

function getIndustryId($connect, $channelId)
{
	$sql = 'SELECT industry_id FROM psi_channels WHERE id = :channelId';
	$statement = $connect->prepare($sql);
	$statement->execute(['channelId' => $channelId]);
	$row = $statement->fetch(PDO::FETCH_ASSOC);

	return $row['industry_id'] ?? null;
}

function getEmployeeLevel($connect, $levelId)
{
	$sql = 'SELECT id, name FROM psi_employee_levels WHERE id = :levelId';
	$statement = $connect->prepare($sql);
	$statement->execute(['levelId' => $levelId]);
	$row = $statement->fetch(PDO::FETCH_ASSOC);

	return $row['name'] ?? null;
}

function getChannel($connect, $channelId)
{
	$sql = 'SELECT id, name FROM psi_channels WHERE id = :channelId';
	$statement = $connect->prepare($sql);
	$statement->execute(['channelId' => $channelId]);
	$row = $statement->fetch(PDO::FETCH_ASSOC);

	return $row['name'] ?? null;
}


if (!function_exists('data_get')) {
	function data_get($data, $path, $default = null)
	{
		$paths = explode('.', $path);

		return array_reduce($paths, function ($o, $p) use ($default) {
			if (isset($o->$p)) return (is_object($o->$p) ? (array) $o->$p : $o->$p) ?? $default;
			if (isset($o[$p])) return (is_object($o[$p]) ? (array) $o[$p] : $o[$p])  ?? $default;

			return $default;
		}, (array) $data);
	}
}
