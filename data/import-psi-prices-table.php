<?php

importProductCSV();

function importProductCSV()
{
    require_once 'php_action/db_connect.php';

    $filename = dirname(dirname(__FILE__)) . '\psi-v3\data\prices.csv';
    $file = fopen($filename, "r");
    $count = 0;
    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
        $count++;

        if ($count > 1) {
            $product_code = trim($emapData[0]);
            $model = trim($emapData[1]);
            $price = trim($emapData[2]);

            $sql = 'INSERT INTO `psi_prices` (`product_code`, `model`, `price`)
                SELECT :product_code, :model, :price
                FROM DUAL
                WHERE NOT EXISTS (
                    SELECT `product_code`, `model`, `price`
                    FROM `psi_prices`
                    WHERE `product_code`= :product_code and `model` = :model
                )
                LIMIT 1';

            $statement = $connect->prepare($sql);
            $status = $statement->execute(['product_code' => $product_code, 'model' => $model, 'price' => $price]);

            if ($status) {
                echo "Success: Added " . $product_code . " with price: " . $price . PHP_EOL;
            } else {
                echo "Failed: Added " . $product_code . " with price: " . $price . PHP_EOL;
            }
        }
    }
}
