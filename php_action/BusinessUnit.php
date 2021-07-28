<?php

require_once 'db_connect.php';

class BusinessUnit
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getBusinessUnitOptions()
    {
        $this->db->query('SELECT id, name FROM psi_business_units');

        $results = $this->db->resultSet();

        return array_map(function ($value) {
            return [
                'value' => $value->id,
                'title' => $value->name,
            ];
        }, $results);
    }
}
