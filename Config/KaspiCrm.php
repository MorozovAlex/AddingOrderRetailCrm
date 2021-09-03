<?php

namespace App\Config;

class KaspiCRM
{
    private const TOKEN_API = 'token';
    private const DOMAIN = 'kaspi.kz';
    private const PATH_FOR_GET_ORDERS = '/shop/api/v2/orders';


    public function getLinkForGetOrders(string $state): string
    {
        $filterKaspi = new FilterKaspi();

        return 'https://' . self::DOMAIN . self::PATH_FOR_GET_ORDERS . '?' . 'page[number]=0&page[size]=200'
            . '&' . $filterKaspi->getFilterOrdersState($state)
            . '&' . $filterKaspi->getFilterCreatingDate((new FilterKaspi())->getTimeMidnight() - 864000000);
    }
}

