<?php

require_once 'db_connect.php';

class Agency
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAgenciesByAMS($empId)
    {
        $this->db->query('SELECT a.id, a.name, a.province,b.full_name FROM psi_agencies AS a JOIN psi_employees AS b ON a.employee_id = b.id WHERE employee_id = :employee_id');

        $this->db->bind(':employee_id', $empId);

        $results = $this->db->resultSet();

        return $results;
    }
    public function getAllAgencies()
    {
        $this->db->query('SELECT a.id, a.name, a.province,b.full_name FROM psi_agencies AS a JOIN psi_employees AS b ON a.employee_id = b.id');

        $results = $this->db->resultSet();

        return $results;
    }
    public function getAgenciesByADM()
    {
        $this->db->query('SELECT a.id, a.name, a.province, b.full_name FROM psi_agencies AS a JOIN psi_employees AS b ON a.employee_id = b.id');

        $results = $this->db->resultSet();

        return $results;
    }

    public function searchAgencyByAMS($employeeId, $searchParam)
    {
        $this->db->query('SELECT a.id, a.name, a.province, b.full_name FROM psi_agencies AS a JOIN psi_employees AS b ON a.employee_id = b.id
                            WHERE (a.name LIKE :searchParam OR a.province LIKE :searchParam) and a.employee_id = :employee_id
                            ORDER BY a.created_at ASC');
        $this->db->bind(':searchParam', $searchParam);
        $this->db->bind(':employee_id', $employeeId);

        $results = $this->db->resultSet();

        return $results;
    }

    public function getAgencyOptions($employeeId)
    {
        $this->db->query('SELECT id, name FROM psi_agencies WHERE employee_id = :employee_id');
        $this->db->bind(':employee_id', $employeeId);

        $results = $this->db->resultSet();

        return array_map(function ($value) {
            return [
                'value' => $value->id,
                'title' => $value->name,
            ];
        }, $results);
    }
    public function getEmployee()
    {
        $this->db->query('SELECT * FROM psi_employees');

        $results = $this->db->resultSet();

        return $results;
    }
    public function getAllAgencyOptions()
    {
        $this->db->query('SELECT id, name FROM psi_agencies');

        $results = $this->db->resultSet();

        return array_map(function ($value) {
            return [
                'value' => $value->id,
                'title' => $value->name,
            ];
        }, $results);
    }
}
