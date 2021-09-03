<?php

namespace App;

use App\Config\KaspiCRM;
use App\Config\OrderState;
use App\Config\RetailCRM;
use App\UseCase\CurlRequest;


require_once 'Config/FilterKaspi.php';
require_once 'Config/KaspiCrm.php';
require_once 'CurlRequest.php';
require_once 'Config/OrderState.php';
require_once 'HandlerOrdersKaspi.php';
require_once 'Config/RetailCrm.php';
require_once 'Config/FilterRetailCrm.php';
require_once 'CreatorPostDataRetailCrm.php';
require_once 'HandlerOrdersRetailCrm.php';


$kaspiCrm = new KaspiCRM();
$retailCrm = new RetailCRM();
$curlRequest = new CurlRequest();
$orderState = new OrderState();
$handlerOrdersKaspi = new HandlerOrdersKaspi();
$creatorPostDataRetailCrm = new CreatorPostDataRetailCrm();
$handlerOrdersRetailCrm = new HandlerOrdersRetailCrm();


//$ordersListKaspiCrm = $curlRequest->get($kaspiCrm->getLinkForGetOrders($orderState->getOrderStateNew()), $curlRequest->getHeadersForKaspi());

$ordersListKaspiCrm = $curlRequest->get($kaspiCrm->getLinkForGetOrders($orderState->getOrderStateKaspiDelivery()), $curlRequest->getHeadersForKaspi());

$ordersTroubleListRetailCrm = $curlRequest->get($retailCrm->getLinkForGetOrdersListByStatus($retailCrm->getOrderStatusTrouble()), []);

$listAllOrdersKaspiCrm = [];
foreach ($orderState->getState() as $state) {
    $listAllOrdersKaspiCrm[] = $curlRequest->get($kaspiCrm->getLinkForGetOrders($state), $curlRequest->getHeadersForKaspi());
}

if (isset($ordersTroubleListRetailCrm['orders'])) {
    foreach ($ordersTroubleListRetailCrm['orders'] as $orderRetailCrm) {
       foreach ($listAllOrdersKaspiCrm as $ordersKaspi) {
           if (!empty($ordersKaspi['data'])) {
               $handlerOrdersKaspi->changeStatusOrderRetailCrm($ordersKaspi, $orderRetailCrm);
           }
       }
    }
}

if (!empty($ordersListKaspiCrm['data'])) {
    foreach ($ordersListKaspiCrm['data'] as $order) {

        $article = $creatorPostDataRetailCrm->getProductArticle($creatorPostDataRetailCrm->getProduct($order, $curlRequest));
        $manufacturer = $creatorPostDataRetailCrm->getProductManufacturer($creatorPostDataRetailCrm->getProduct($order, $curlRequest));

        $data = $curlRequest->get($retailCrm->getLinkForGetProduct($article, $manufacturer), []);

        if (!empty($data['products'])) {
            if (!$handlerOrdersRetailCrm->orderExistInRetailCrm($ordersTroubleListRetailCrm, $handlerOrdersKaspi->getOrderCode($order))) {

                $offerId = $data['products'][0]['offers'][0]['id'];
                $postOrder[] = $creatorPostDataRetailCrm->getPostOrder($order, $offerId);

            } else print_r('Existing order:' . $handlerOrdersKaspi->getOrderCode($order));
        }
    }
} else die('Array ordersListKaspiCrm[\'data\'] is empty.');



if (!empty($postOrder)) {
    $postData = $creatorPostDataRetailCrm->getPostData($postOrder, $retailCrm);

    echo '<pre>';
    print_r($curlRequest->post($postData, $retailCrm->getLinkForPostUpload()));
    echo '</pre>';
}



