<?php

require_once 'core.php';
require_once 'db_connect.php';

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function searchProducts($searchParam, $businessUnitId)
    {
        $this->db->query('SELECT p.id, p.product_code, p.name, p.model, bu.name as business_unit_name FROM psi_products as p JOIN psi_business_units as bu ON bu.id = p.business_unit_id
                            WHERE (p.product_code LIKE :searchParam OR p.name LIKE :searchParam OR p.model LIKE :searchParam) AND (p.business_unit_id = :business_unit_id)
                            ORDER BY p.created_at ASC');
        $this->db->bind(':searchParam', $searchParam);
        $this->db->bind(':business_unit_id', $businessUnitId);

        $results = $this->db->resultSet();

        return $results;
    }
}
