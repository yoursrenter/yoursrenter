<?php
/**
 * Created by PhpStorm.
 * User: Админ
 * Date: 09.11.2019
 * Time: 22:56
 */

namespace App\models;


class Tenant extends Model
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setTableName('tenants');
    }

    private function mergeData($arr_first, $arr_second)
    {
        foreach ($arr_first as $key => $item) {
            foreach ($item as $prop => $value) {
                if ($arr_second[$key][$prop] != null) {
                    $arr_first[$key] = array_merge($arr_first[$key], $arr_second[$key]);
                };
            }
        }
        return $arr_first;
    }

    public function getData($user_login)
    {
        $first_sql =
            "SELECT 
                c.id AS contract_id, c.NAME, t.NAME AS tenant_name, 
                t.phone as tenant_phone, t.email as tenant_email,
                t.service_info, c.`status`, TRUNCATE(c.AREA, 2) AS area, 
                CONCAT(r.NAME, ', ', c.term, ' мес, ', ta.NAME) AS complexinfo, 
                DATE_FORMAT(c.created_at, '%d.%m.%Y') AS created_at, 
                DATE_FORMAT(c.expiration_at, '%d.%m.%Y') AS expiration_at, 
                TRUNCATE(c.rate, 2) AS rate, 
                TRUNCATE(c.rent, 2) AS rent, 
                TRUNCATE(c.rentYear, 2) AS rentYear, 
                c.deposit, c.`prepare`, 
                DATE_FORMAT(c.gettingcontract_at, '%d.%m.%Y') AS gettingcontract_at, 
                DATE_FORMAT(c.transfercontracttenant_at, '%d.%m.%Y') AS transfercontracttenant_at, 
                DATE_FORMAT(c.signtenant_at, '%d.%m.%Y') AS signtenant_at, 
                DATE_FORMAT(c.transfercopytenant_at, '%d.%m.%Y') AS transfercopytenant_at, 
                c.info, c.gettingfromssb_at, t.legaladdress,
                co.communicationtypes ,c.passescount
            FROM contracts AS c 
                 JOIN renterobjects AS r 
                 JOIN tenants AS t 
                 JOIN tenantactivities AS ta 
                 JOIN communications AS co
                 JOIN useravailabilities AS ua
                 JOIN users AS u
            ON c.tenant_id = t.id 
                AND c.renterobject_id=r.id 
                AND t.tenantactivity_id = ta.id 
                AND co.contract_id = c.id
                AND c.id = ua.contract_id
                AND ua.user_id = u.id
            WHERE u.login = '{$user_login}';
";
        $arr_first = $this->query($first_sql);

        $second_sql =
            "SELECT 
                s.contract_id AS contract_id, c.NAME,
                DATE_FORMAT(max(p.payment_at),'%d.%m.%Y') AS lastpayment_at, 
                getPaymentDate() AS payment_at
                FROM
                (SELECT c.id AS contract_id, c.NAME, c.created_at, t.NAME AS tenant_name, u.login  
                    FROM tenants AS t 
                        JOIN useravailabilities AS ua 
                        JOIN users AS u 
                        JOIN contracts AS c
                    ON u.id = ua.user_id 
                        AND ua.contract_id = c.id 
                        AND u.login = '{$user_login}'
                        AND c.tenant_id = t.id
                        ) AS s
                    JOIN payments AS p 
                    JOIN contracts AS c 
                ON p.contract_id = c.id AND c.tenant_id = s.contract_id
                GROUP BY c.id;
        ";

        $arr_second = $this->query($second_sql);
        $data = $this->mergeData($arr_first, $arr_second);
        return $data;
    }

    public function addTenantInfo($data)
    {
        $sql = "CALL sp_savetenantinfo(";
        for ($i = 0; $i < count($data); $i++) {
            $sql .= "'{$data[array_keys($data)[$i]]}'";
            if ($i != count($data) - 1) {
                $sql .= ", ";
            }
        }
        $sql .= ");";
        $data = $this->query($sql);
        return $data;
    }
}
