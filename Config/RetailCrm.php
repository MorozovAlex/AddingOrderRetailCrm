<?php

namespace App\Config;

require_once 'Config/FilterRetailCrm.php';

class RetailCRM
{
    private const API_KEY = 'token';
    private const SUBDOMAIN = 'superposuda';
    private const DOMAIN = 'retailcrm.ru';
    private const PATH_FOR_GET_PRODUCTS = 'api/v5/store/products';
    private const PATH_FOR_GET_LIST_ORDERS = 'api/v5/orders';
    private const PATH_FOR_POST = 'api/v5/orders/create';
    private const PATH_FOR_EDIT_POST = 'api/v5/orders';
    private const ORDER_STATUS_TROUBLE = 'trouble';
    private const PATH_FOR_POST_UPLOAD = 'api/v5/orders/upload';

    public function getApiKey(): string
    {
        return self::API_KEY;
    }

    public function getLinkForEditOrder(string $orderId): string
    {
        return 'https://' . self::SUBDOMAIN . '.' . self::DOMAIN . '/' . self::PATH_FOR_EDIT_POST . '/' . $orderId . '/'
            . 'edit';
    }

    public function getLinkForGetOrdersListByStatus($status): string
    {
        return 'https://' . self::SUBDOMAIN . '.' . self::DOMAIN . '/' . self::PATH_FOR_GET_LIST_ORDERS . '?' . (new FilterRetailCrm())->getFilterStatus() . '='
            . $status . '&' . 'apiKey' . '=' . self::API_KEY;
    }
    
    public function getLinkForGetProduct(string $article, string $manufacturer): string
    {
        return 'https://' . self::SUBDOMAIN . '.' . self::DOMAIN . '/' . self::PATH_FOR_GET_PRODUCTS . '?' . (new FilterRetailCrm())->getFilterProduct() . '='
            . $article . '&' . (new FilterRetailCrm())->getFilterManufacturer() . '=' . $manufacturer . '&apiKey=' . self::API_KEY;
    }

    public function getLinkForPostUpload(): string
    {
        return 'https://' . self::SUBDOMAIN . '.' . self::DOMAIN . '/' . self::PATH_FOR_POST_UPLOAD;
    }

    public function getOrderStatusTrouble(): string
    {
        return self::ORDER_STATUS_TROUBLE;
    }
}

