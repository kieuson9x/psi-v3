<?php

require_once 'db_connect.php';

class Stock
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getStockByProductId($productId)
    {
        $this->db->query(
            'SELECT s.* FROM psi_products AS p
                        JOIN psi_business_units as bu
                        ON p.business_unit_id = bu.id
                        LEFT JOIN psi_stocks as s
                        ON s.product_code = p.product_code and bu.business_unit_code = s.business_unit
                        WHERE p.id = :product_id
                                  '
        );

        $this->db->bind(':product_id', $productId);

        $results = $this->db->single();

        return $results;
    }
}
