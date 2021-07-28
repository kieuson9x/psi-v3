
<?php

require_once 'core.php';
require_once 'db_connect.php';

class Employee
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getEmployee()
    {
        $this->db->query('SELECT a.login,b.UF_EMPLOYEE_CODE FROM b_user AS a JOIN b_uts_user AS b ON a.ID = b.VALUE_ID WHERE a.active = "Y"
        AND b.UF_EMPLOYEE_CODE IS NOT NULL AND a.LID IS NOT NULL AND UF_SUB_DEPARTMENT IS NOT NULL AND work_department IS NOT NULL AND work_department<>""');

        $results = $this->db->resultSet();

        return $results;
    }
    public function getPhongban()
    {
        $this->db->query('SELECT id,name FROM psi_channels');

        $results = $this->db->resultSet();

        return $results;
    }
    public function getDonvi()
    {
        $this->db->query('SELECT id,name FROM psi_business_units');

        $results = $this->db->resultSet();

        return $results;
    }

    public function getchucvu()
    {
        $this->db->query('SELECT id,name FROM psi_employee_levels');

        $results = $this->db->resultSet();

        return $results;
    }

    public function getEmployADM()
    {
        $this->db->query('SELECT a.id,a.full_name, a.user_code, b.name AS donvi,c.name AS phongban,d.name AS chucvu FROM psi_employees AS a
        JOIN psi_business_units AS b ON a.business_unit_id = b.id
        JOIN psi_channels AS c ON a.channel_id = c.id
        JOIN psi_employee_levels AS d ON a.level_id = d.id');

        $results = $this->db->resultSet();
        return $results;
    }

    public function createEmployee($data)
    {
        $db = $this->db;

        $query = "INSERT INTO psi_employees (`user_name`, `user_code`, `full_name`,`business_unit_id`,`channel_id`,`level_id`) VALUES(:user_name, :user_code, :full_name,:business_unit_id,:channel_id,:level_id)";

        $db->query($query);
        $db->bind(':user_name', data_get($data, 'tennhanvien'));
        $db->bind(':user_code', data_get($data, 'manhanvien'));
        $db->bind(':full_name', data_get($data, 'tennhanvien'));
        $db->bind(':business_unit_id', data_get($data, 'donvi'));
        $db->bind(':channel_id', data_get($data, 'phongban'));
        $db->bind(':level_id', data_get($data, 'chucvu'));

        return $db->execute();
    }

    public function getASMOptionsByChannelId($channelId)
    {
        $this->db->query('SELECT e.id, e.full_name
                        FROM psi_employees AS e
                        JOIN psi_employee_levels as el
                        ON el.id = e.level_id
                        WHERE e.channel_id = :channel_id and el.name like "Quản lý khu vực"
        ');

        $this->db->bind(':channel_id', $channelId);

        $results = $this->db->resultSet();

        return array_map(function ($value) {
            return [
                'value' => $value->id,
                'title' => $value->full_name,
            ];
        }, $results);
    }
}
