<?php

namespace App;


use App\UseCase\CurlRequest;
use App\Config\RetailCRM;


class CreatorPostDataRetailCrm
{

    public function getPostOrder(array $arrayOrderKaspi, string $offerId): array
    {
        $postOrder = [
            'status' => 'trouble',
            'orderType' => 'fizik',
            'orderMethod' => 'test',
            'firstName' => 'Kaspi',
            'lastName' => 'Morozov',
        ];


        if (isset($arrayOrderKaspi['attributes']['code'])) {
            $postOrder ['number'] = $arrayOrderKaspi['attributes']['code'];
        }

        $postOrder['items'][] = [
                'offer' => [
                    'id' => $offerId,

                ],
            ];

        return $postOrder;
    }

    public function getEditPost(string $orderStatus): array
    {
        return [
            'status' => $orderStatus,
        ];
    }

    public function getPostData(array $postOrder, RetailCRM $retailCrm): array
    {

        return [
            'site' => 'test',
            'orders' => json_encode($postOrder),
            'apiKey' => $retailCrm->getApiKey(),
        ];
    }

    public function getPostEditData(array $postEditOrder, RetailCRM $retailCrm): array
    {

        return [
            'site' => 'test',
            'by' => 'id',
            'order' => json_encode($postEditOrder),
            'apiKey' => $retailCrm->getApiKey(),
        ];
    }

    public function getEntriesLink(string $entryLink, CurlRequest $curlRequest): ?string
    {
        $arrayOrderEntries = $curlRequest->get($entryLink, $curlRequest->getHeadersForKaspi());

        if (isset($arrayOrderEntries['data'])) {
            foreach ($arrayOrderEntries['data'] as $orderEntry) {
                if (isset($orderEntry['relationships']['product']['links']['related'])) {
                    return $orderEntry['relationships']['product']['links']['related'];
                }
            }
        }

        return null;
    }

    public function getProductLink(string $productLink, CurlRequest $curlRequest): ?string
    {
        $arrayProduct = $curlRequest->get($productLink, $curlRequest->getHeadersForKaspi());

        if (isset($arrayProduct['data']['relationships']['merchantProduct']['links']['related'])) {

            return $arrayProduct['data']['relationships']['merchantProduct']['links']['related'];
        }

        return null;
    }

    public function getProduct(array $arrayOrderKaspi, CurlRequest $curlRequest): ?array
    {
        if (isset($arrayOrderKaspi['relationships']['entries']['links']['related'])) {
            $related = $arrayOrderKaspi['relationships']['entries']['links']['related'];

            return $curlRequest->get(self::getProductLink(self::getEntriesLink($related, $curlRequest),  $curlRequest), $curlRequest->getHeadersForKaspi());
        }

        return null;
    }

    public function getProductArticle(array $product): ?string
    {
        if (isset($product['data']['attributes']['code'])) {
                return $product['data']['attributes']['code'];
            }

        return null;
    }
    public function getProductManufacturer(array $product): ?string
    {
        if (isset($product['data']['attributes']['manufacturer'])) {
            return $product['data']['attributes']['manufacturer'];
        }

        return null;
    }
}

