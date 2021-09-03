<?php

namespace App\Config;

class OrderState
{
    private const ORDERS_STATE_NEW = 'NEW';
    private const ORDERS_STATE_SIGN_REQUIRED = 'SIGN_REQUIRED';
    private const ORDERS_STATE_PICKUP = 'PICKUP';
    private const ORDERS_STATE_DELIVERY = 'DELIVERY';
    private const ORDERS_STATE_KASPI_DELIVERY = 'KASPI_DELIVERY';


    public function getState(): array
    {
        return array(self::getOrderStateNew(), self::getOrderStateKaspiDelivery(), self::getOrderStateDelivery(), self::getOrderStatePickup(), self::getOrderStateSignRequired());
    }
    public function getOrderStateNew(): string
    {
        return self::ORDERS_STATE_NEW;
    }

    public function getOrderStateSignRequired(): string
    {
        return self::ORDERS_STATE_SIGN_REQUIRED;
    }

    public function getOrderStatePickup(): string
    {
        return self::ORDERS_STATE_PICKUP;
    }

    public function getOrderStateDelivery(): string
    {
        return self::ORDERS_STATE_DELIVERY;
    }

    public function getOrderStateKaspiDelivery(): string
    {
        return self::ORDERS_STATE_KASPI_DELIVERY;
    }
}
