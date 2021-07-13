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
            'SELECT a.* FROM psi_stocks AS a
                            CROSS JOIN psi_products AS b
                            CROSS JOIN psi_business_units as c
                            WHERE a.product_code = b.product_code AND
                                  a.business_unit = c.business_unit_code AND
                                  b.business_unit_id = c.business_unit_id AND
                                  b.id = :product_id
                                  '
        );

        $this->db->bind(':product_id', $productId);

        $results = $this->db->resultSet();

        return $results;
    }
}
