<?php

require_once 'db_connect.php';

class EmployeeSale
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAgencySales($agencyIds, $businessUnitId)
    {
        $currentYear = (int) date('Y');
        $currentMonth = date('m');

        if (empty($agencyIds)) {
            return [];
        }

        $agencyIds = implode(",", $agencyIds);
        $db = $this->db;

        $db->query("SELECT DISTINCT t1.product_id, t1.agency_id
                            FROM psi_agency_sales as t1
                            WHERE (DATE(CONCAT(`year`, '-', `month`, '-10')) BETWEEN '{$currentYear}-{$currentMonth}-01' AND '{$currentYear}-12-31') AND `agency_id` IN ($agencyIds)
                            ");

        $results = $this->db->resultSet();
        $newResults = array_map(function ($item) use ($db, $currentYear, $agencyIds, $currentMonth, $businessUnitId) {
            $db->query("SELECT p.product_code, p.name, p.model, p.business_unit_id, p.industry_id, p.product_type_id,
                                 t1.product_id, t1.month, t1.year, t1.number_of_sale_goods, t1.agency_id, s.stock, bu.name as business_unit_name,(pr.price * t1.number_of_sale_goods) AS calculated_price
                            FROM psi_agency_sales as t1
                            JOIN psi_products as p
                            ON p.id = t1.product_id
                            JOIN psi_business_units as bu
                            ON p.business_unit_id = bu.id
                            LEFT JOIN psi_stocks as s
                            on s.product_code = p.product_code AND bu.name = s.business_unit
                            LEFT JOIN psi_prices as pr
                            on pr.product_code = p.product_code AND pr.model = p.model
                            WHERE t1.product_id = {$item->product_id} AND t1.agency_id = {$item->agency_id}
                                AND (DATE(CONCAT(`year`, '-', `month`, '-01')) BETWEEN '{$currentYear}-{$currentMonth}-01' AND '{$currentYear}-12-31' )
                                AND `agency_id` IN ($agencyIds) AND p.business_unit_id = {$businessUnitId}
                            ");
            $result = $db->resultSet();
            return empty($result) ? null : $result;
        }, $results);

        $newResults = array_filter($newResults);

        return $newResults;
    }

    public function getAgencySalesForChannelManager($agencyIds, $businessUnitId)
    {
        $currentYear = (int) date('Y');
        $currentMonth = date('m');

        if (empty($agencyIds)) {
            return [];
        }

        $agencyIds = implode(",", $agencyIds);
        $db = $this->db;

        $db->query("SELECT DISTINCT t1.product_id, t1.agency_id
                            FROM psi_agency_sales as t1
                            WHERE (DATE(CONCAT(`year`, '-', `month`, '-10')) BETWEEN '{$currentYear}-{$currentMonth}-01' AND '{$currentYear}-12-31') AND `agency_id` IN ($agencyIds)
                            ");

        $results = $this->db->resultSet();

        $newResults = array_map(function ($item) use ($db, $currentYear, $agencyIds, $currentMonth, $businessUnitId) {
            $db->query("SELECT p.product_code, p.name, p.model, p.business_unit_id, p.industry_id, p.product_type_id,
                                 t1.product_id, t1.month, t1.year, t1.number_of_sale_goods, t1.agency_id, s.stock, bu.name as business_unit_name, pr.price, (pr.price * t1.number_of_sale_goods) AS calculated_price, e.full_name
                            FROM psi_agency_sales as t1
                            JOIN psi_products as p
                            ON p.id = t1.product_id
                            JOIN psi_business_units as bu
                            ON p.business_unit_id = bu.id
                            JOIN psi_agencies as a
                            ON a.id = t1.agency_id
                            JOIN psi_employees as e
                            ON a.employee_id = e.id
                            LEFT JOIN psi_stocks as s
                            on s.product_code = p.product_code AND bu.name = s.business_unit
                            LEFT JOIN psi_prices as pr
                            on pr.product_code = p.product_code AND pr.model = p.model
                            WHERE t1.product_id = {$item->product_id} AND t1.agency_id = {$item->agency_id}
                                AND (DATE(CONCAT(`year`, '-', `month`, '-01')) BETWEEN '{$currentYear}-{$currentMonth}-01' AND '{$currentYear}-12-31' )
                                AND `agency_id` IN ($agencyIds) AND p.business_unit_id = {$businessUnitId}
                            ");
            $result = $db->resultSet();
            return empty($result) ? null : $result;
        }, $results);

        $newResults = array_filter($newResults);
        return $newResults;
    }

    public function getAgencySalesForIndustryManager($industryId, $businessUnitId)
    {
        $currentYear = (int) date('Y');
        $currentMonth = date('m');

        $db = $this->db;

        $db->query("SELECT DISTINCT t1.product_id, t1.agency_id
                            FROM psi_agency_sales as t1
                            WHERE DATE(CONCAT(`year`, '-', `month`, '-10')) BETWEEN '{$currentYear}-{$currentMonth}-01' AND '{$currentYear}-12-31'
                            ");

        $results = $this->db->resultSet();

        $newResults = array_map(function ($item) use ($db, $currentYear, $currentMonth, $industryId, $businessUnitId) {
            $businessUnitQuery = $businessUnitId !== 'all' ? " AND bu.id = {$businessUnitId}" : "";
            $db->query("SELECT p.product_code, p.name, p.model, p.business_unit_id, p.industry_id, p.product_type_id,
                                 t1.product_id, t1.month, t1.year, t1.number_of_sale_goods, t1.agency_id, s.stock,
                                 bu.name as business_unit_name, pr.price, (pr.price * t1.number_of_sale_goods) AS calculated_price, e.full_name,
                                 pt.name as product_type_name, i.name as industry_name, a.name as agency_name
                            FROM psi_agency_sales as t1
                            JOIN psi_products as p
                            ON p.id = t1.product_id
                            JOIN psi_business_units as bu
                            ON p.business_unit_id = bu.id
                            JOIN psi_agencies as a
                            ON a.id = t1.agency_id
                            JOIN psi_employees as e
                            ON a.employee_id = e.id
                            JOIN psi_product_types as pt
                            ON p.product_type_id = pt.id
                            JOIN psi_industries as i
                            ON p.industry_id = i.id
                            LEFT JOIN psi_stocks as s
                            on s.product_code = p.product_code AND bu.name = s.business_unit
                            LEFT JOIN psi_prices as pr
                            on pr.product_code = p.product_code AND pr.model = p.model
                            WHERE t1.product_id = {$item->product_id} AND t1.agency_id = {$item->agency_id}
                                AND (DATE(CONCAT(`year`, '-', `month`, '-01')) BETWEEN '{$currentYear}-{$currentMonth}-01' AND '{$currentYear}-12-31' )
                                AND p.industry_id = {$industryId} {$businessUnitQuery}
                            ");
            $result = $db->resultSet();
            return empty($result) ? null : $result;
        }, $results);

        $newResults = array_filter($newResults);
        return $newResults;
    }

    public function findAgencySale($agencyId, $productId, $month, $year)
    {
        $this->db->query('SELECT * FROM psi_agency_sales WHERE product_id = :product_id and month = :month and year = :year and agency_id = :agency_id');

        $this->db->bind(':product_id', $productId);
        $this->db->bind(':month', (int) $month);
        $this->db->bind(':year', $year);
        $this->db->bind(':agency_id', $agencyId);

        $row = $this->db->single();

        return $row;
    }

    public function getTotalSalesByProduct($productId, $month, $year)
    {
        $this->db->query('SELECT SUM(`number_of_sale_goods`) as total_product_sales FROM psi_agency_sales WHERE product_id = :product_id and month = :month and year = :year');

        $this->db->bind(':product_id', $productId);
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);

        $row = $this->db->single();

        return $row;
    }

    public function updateAgencySale($agencySaleId, $data)
    {
        $db = $this->db;

        $query = "UPDATE psi_agency_sales SET `number_of_sale_goods` = :number_of_sale_goods WHERE `id` = :agency_sale_id";

        $db->query($query);
        $db->bind(':agency_sale_id', (int) $agencySaleId);
        $db->bind(':number_of_sale_goods', data_get($data, 'number_of_sale_goods'));

        return $db->execute();
    }

    public function createAgencySale($agencyId, $data)
    {
        $db = $this->db;

        $query = "INSERT INTO psi_agency_sales (`agency_id`, `product_id`, `month`, `year`, `number_of_sale_goods`)
                     VALUES(:agency_id, :product_id, :month, :year, :number_of_sale_goods)";

        $db->query($query);
        $db->bind(':product_id', data_get($data, 'product_id'));
        $db->bind(':agency_id', $agencyId);
        $db->bind(':month', (int) data_get($data, 'month'));
        $db->bind(':year', data_get($data, 'year'));
        $db->bind(':number_of_sale_goods', data_get($data, 'number_of_sale_goods'));
        // $db->bind(':number_of_remaining_goods', data_get($data, 'number_of_remaining_goods'));

        return $db->execute();
    }
    public function createagency($data)
    {
        $db = $this->db;

        $query = "INSERT INTO psi_agencies (`name`, `province`, `employee_id`)
                     VALUES(:name, :province, :employee_id)";

        $db->query($query);
        $db->bind(':name', data_get($data, 'tendaily'));
        $db->bind(':employee_id', data_get($data, 'nhanvien'));
        $db->bind(':province', data_get($data, 'tinh'));

        return $db->execute();
    }
}
