<?php

require_once 'db_connect.php';

class Inventory
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getInventories($currentBusinessUnitCode)
    {
        $currentYear = (int) date('Y');
        $currentMonth = date('m');

        $db = $this->db;

        $db->query("SELECT DISTINCT t1.product_id
                            FROM psi_inventories as t1
                            WHERE DATE(CONCAT(`year`, '-', `month`, '-01')) BETWEEN '{$currentYear}-{$currentMonth}-01' AND '{$currentYear}-12-31'
                            ");

        $results = $this->db->resultSet();


        $newResults = array_map(function ($item) use ($db, $currentYear, $currentMonth, $currentBusinessUnitCode) {
            $db->query("SELECT p.product_code, p.name, p.model, p.business_unit_id, p.industry_id, p.product_type_id,
                                 t1.product_id, t1.month, t1.year, t1.number_of_imported_goods, t1.number_of_remaining_goods, t1.number_of_sale_goods,
                                 s.stock, bu.name as business_unit_name
                            FROM psi_inventories as t1
                            JOIN psi_products as p
                            ON p.id = t1.product_id
                            JOIN psi_business_units as bu
                            ON p.business_unit_id = bu.id
                            LEFT JOIN psi_stocks as s
                            ON s.product_code = p.product_code AND bu.name = s.business_unit
                            WHERE t1.product_id = {$item->product_id} AND
                                (DATE(CONCAT(`year`, '-', `month`, '-10')) BETWEEN '{$currentYear}-{$currentMonth}-01' AND '{$currentYear}-12-31') AND
                                bu.name = '{$currentBusinessUnitCode}'
                                ");
            $result = $db->resultSet();
            return empty($result) ? null : $result;
        }, $results);

        $newResults = array_filter($newResults);
        return $newResults;
    }

    public function findInventory($productId, $month, $year)
    {
        $this->db->query('SELECT * FROM psi_inventories WHERE product_id = :product_id and month = :month and year = :year');

        $this->db->bind(':product_id', $productId);
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);

        $row = $this->db->single();

        return $row;
    }

    public function updateInventory($inventoryId, $data)
    {
        $db = $this->db;

        $query = "UPDATE psi_inventories SET `number_of_imported_goods` = :number_of_imported_goods WHERE `id` = :inventory_id";

        $db->query($query);
        $db->bind(':inventory_id', (int) $inventoryId);
        $db->bind(':number_of_imported_goods', data_get($data, 'number_of_imported_goods'));

        return $db->execute();
    }

    public function createInventory($data)
    {
        $db = $this->db;

        $query = "INSERT INTO psi_inventories (`product_id`, `month`, `year`, `number_of_imported_goods`)
                     VALUES(:product_id, :month, :year, :number_of_imported_goods)";

        $db->query($query);
        $db->bind(':product_id', data_get($data, 'product_id'));
        $db->bind(':month', data_get($data, 'month'));
        $db->bind(':year', data_get($data, 'year'));
        $db->bind(':number_of_imported_goods', data_get($data, 'number_of_imported_goods'));
        // $db->bind(':number_of_remaining_goods', data_get($data, 'number_of_remaining_goods'));

        return $db->execute();
    }

    public function syncRemainingGoods($productId, $month, $year, $numberOfSales, $numberOfPurchases, $numberOfPreviousInventory)
    {
        $db = $this->db;

        $query = "UPDATE psi_inventories
                        SET `number_of_remaining_goods` = :number_of_remaining_goods, `number_of_sale_goods` = :number_of_sale_goods
                        WHERE product_id = :product_id and month = :month and year = :year";

        $numberOfInventory = $numberOfPreviousInventory + $numberOfPurchases - $numberOfSales;

        $db->query($query);

        $db->bind(':number_of_sale_goods', $numberOfSales);
        $db->bind(':number_of_remaining_goods', $numberOfInventory);
        $db->bind(':product_id', $productId);
        $db->bind(':month', $month);
        $db->bind(':year', $year);

        return $db->execute();
    }
}
