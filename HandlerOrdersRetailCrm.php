<?php

namespace App;

class HandlerOrdersRetailCrm
{
    public function orderExistInRetailCrm(array $ordersListRetailCrm, string $codeOrderKaspiCrm): ?bool
    {
        foreach ($ordersListRetailCrm as $orderRetailCrm) {
            foreach ($orderRetailCrm as $property) {
                if (isset($property['number'])){
                   if ($property['number'] === $codeOrderKaspiCrm) {
                       return true;
                   }
                }
            }
        }

        return null;
    }

    public function getOrderId(array $orderRetailCrm): ?string
    {
        foreach ($orderRetailCrm as $propertyKey => $property) {
            if ('id' === $propertyKey) {
                return $property;
            }
        }

        return null;
    }

    public function getOrderCode(array $orderRetailCrm): ?string
    {
        foreach ($orderRetailCrm as $propertyKey => $property) {
            if ('number' === $propertyKey) {
                return $property;
            }
        }

        return null;
    }
}
