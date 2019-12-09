<?php
/**
 * Created by PhpStorm.
 * User: Админ
 * Date: 12.11.2019
 * Time: 2:41
 */

namespace App\models;

use DateTime;

class Finance extends Model
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setTableName('payments');
    }

    private function restructData($data)
    {
        $arr = [];
        foreach ($data as $item) {
            $tenant_id = $item['tenant_id'];
            unset($item['tenant_id']);
            $arr[$tenant_id][] = $item;
        }
        return $arr;
    }

    /**
     * Функция валидации дат (оплаты..)
     * @param $data
     * @return bool
     */
    private function isValidDates($data)
    {
        $now = date('Y-m-d H:i:s');
        return
            $this->numberFormatDate($data['payment_at']) > $this->numberFormatDate($data['created_at']) &&
            $this->numberFormatDate($data['payment_at']) < $this->numberFormatDate($now);
    }

    /**
     * проверка того, что контракт уже окончен
     * @param $tenant_data (данные арендатора)
     * @return bool
     */
    private function isExpiratedContract($tenant_data)
    {
        if (!$tenant_data['expiration_at']) return false;
        $now = date('Y-m-d H:i:s');
        return $this->numberFormatDate($now) > $this->numberFormatDate($tenant_data['expiration_at']);
    }

    private function numberFormatDate($date)
    {
        return +date('Ym', strtotime($date));
    }

    private function dateDiff($first_date, $second_date)
    {
        $date1 = date_create($first_date);
        $date2 = date_create($second_date);
        return date_diff($date1, $date2);
    }

    private function getLastPayments($data)
    {
        $arr = [];
        foreach ($data as $id => $tenant) {
            $maxDate = 0;
            $payment_sum = 0;
            foreach ($tenant as $item) {
                $payment_sum += $item['payment'];
                $date = $this->numberFormatDate($item['payment_at']);
                if ($date > $maxDate) {
                    $maxDate = $date;
                    $arr[$id] = $item;
                }

                $interval = $this->dateDiff($item['created_at'], date('Y-m-d H:i:s'));
                $month_count = $interval->format('%Y') * 12 + $interval->format('%m');
                $arr[$id]['rent_sum'] = $month_count * $item['rent'];
            }
            $arr[$id]['payment_sum'] = $payment_sum;
            $arr[$id]['diff_sum'] = $arr[$id]['rent_sum'] - $arr[$id]['payment_sum'];
            $arr[$id]['isDebtor'] = $arr[$id]['rent_sum'] > $arr[$id]['payment_sum'];
        }
        return $arr;
    }

    public function getData($user_login)
    {
        $sql = "
        SELECT 
          p.contract_id, 
          p.payment, 
          p.payment_at, 
          c.name as contract_name,
          c.rent, 
          c.rentYear, 
          c.deposit,
          t.id as tenant_id, 
          t.name as tenant_name, 
          c.created_at, 
          c.expiration_at 
        FROM payments AS p 
          JOIN contracts AS c 
          JOIN tenants AS t 
          JOIN useravailabilities AS ua 
          JOIN users AS u
        ON p.contract_id=c.id 
          AND c.tenant_id=t.id 
          AND ua.contract_id = c.id 
          AND ua.user_id = u.id 
          AND u.login = '{$user_login}';
        ";

        $data = $this->query($sql);
        $data = $this->restructData($data);
        $ret = [];
        $ret['all'] = $data;
        $ret['last'] = $this->getLastPayments($data);
        return $ret;
    }

    public function getDataOne()
    {
        $sql = '';
        return $this->query($sql);

    }
}