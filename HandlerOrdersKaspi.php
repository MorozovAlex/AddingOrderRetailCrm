<?php

namespace App;

use App\Config\RetailCRM;
use App\UseCase\CurlRequest;

class HandlerOrdersKaspi
{
    public function changeStatusOrderRetailCrm(array $ordersKaspi, array $orderRetailCrm): void
    {
        $completed = 'complete';
        $cancelled = 'prichina-otkaza-v-kliente';

        foreach ($ordersKaspi['data'] as $orderKaspi) {
            if (isset($orderKaspi['attributes']['code']) && $orderKaspi['attributes']['code'] === (new HandlerOrdersRetailCrm())->getOrderCode($orderRetailCrm)) {
                if (isset($orderKaspi['attributes']['status'])) {
                    if ('COMPLETED' === $orderKaspi['attributes']['status']) {
                        $idOrder = (new HandlerOrdersRetailCrm())->getOrderId($orderRetailCrm);
                        (new CurlRequest())
                            ->post((new CreatorPostDataRetailCrm())
                                ->getPostEditData((new CreatorPostDataRetailCrm())
                                    ->getEditPost($completed), (new RetailCRM())), (new RetailCRM())
                                        ->getLinkForEditOrder($idOrder));

                    } else if ('CANCELLED' === $orderKaspi['attributes']['status']) {
                        $idOrder = (new HandlerOrdersRetailCrm())->getOrderId($orderRetailCrm);
                        (new CurlRequest())
                            ->post((new CreatorPostDataRetailCrm())
                                ->getPostEditData((new CreatorPostDataRetailCrm())
                                    ->getEditPost($cancelled), (new RetailCRM())), (new RetailCRM())
                                        ->getLinkForEditOrder($idOrder));
                    }
                }
            }
        }
    }

    public function getOrderCode(array $order): ?string
    {
        if (isset($order['attributes']['code'])) {
            return $order['attributes']['code'];
        }

        return null;
    }
}

