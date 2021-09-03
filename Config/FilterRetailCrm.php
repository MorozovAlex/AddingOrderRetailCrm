<?php

namespace App\Config;

class FilterRetailCrm
{
    private const FILTER_PRODUCT = 'filter[name]';
    private const FILTER_MANUFACTURER = 'filter[manufacturer]';
    private const FILTER_CREATED_AT_FROM = 'filter[createdAtFrom]';
    private const FILTER_STATUS = 'filter[extendedStatus][]';

    public function getFilterProduct(): string
    {
        return self::FILTER_PRODUCT;
    }

    public function getFilterManufacturer(): string
    {
        return self::FILTER_MANUFACTURER;
    }

    public function getFilterCreatedAtFrom(): string
    {
        return self::FILTER_CREATED_AT_FROM;
    }

    public function getFilterStatus(): string
    {
        return self::FILTER_STATUS;
    }

    public function getTimeMidnight(): string
    {
        return date('Y-m-d');
    }
}

