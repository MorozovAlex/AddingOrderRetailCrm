<?php

namespace App\Config;

class FilterKaspi
{
    private const FILTER_DATE = 'filter[orders][creationDate][$ge]';
    private const FILTER_ORDERS_STATE = 'filter[orders][state]';
    private const FILTER_ORDERS_COD = 'filter[orders][code]';
    private const FILTER_ORDER_STATUS = 'filter[orders][status]';

    public function getTimeMidnight(): int
    {
        return mktime(0, 0, 1) * 1000;
    }

    public function getFilterOrdersState(string $state): string
    {
        return self::FILTER_ORDERS_STATE . '=' . $state;
    }

    public function getFilterCreatingDate(int $time): string
    {
        return self::FILTER_DATE . '=' . $time;
    }
}
