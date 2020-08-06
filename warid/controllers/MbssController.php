<?php

namespace warid\controllers;

use warid\models\KamusUraian;
use warid\models\ScaleRef;
use linslin\yii2\curl;

class MbssController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionResult($testtakerId, $deliveryId, $deliveryType)
    {

        $result = $this->getResult($testtakerId, $deliveryId, true);
//        echo '<pre>';
//        print_r($result);
//        ob_end_clean();
//        return $this->render($deliveryType, [
//            'result' => $result,
//        ]);
    }


    public function getResult($testtakerId, $deliveryId, $debug) {


        $cfit1_total = 0;
        $cfit2_total = 0;
        $cfit3_total = 0;
        $cfit4_total = 0;

        $tiu_total = 0;
        $ist_total = 0;
        $tkd_total = 0;
        $analogi_total = 0;
        $gatb4_total = 0 ;
        $adkudag4_total = 0;
        $tese_total = 0;
        $holland['r'] = 0;
        $holland['i'] = 0;
        $holland['a'] = 0;
        $holland['s'] = 0;
        $holland['e'] = 0;
        $holland['c'] = 0;

        $biodata_items = ['item-138'];
        $cfit1_items = ['item-2', 'item-3', 'item-4', 'item-5', 'item-6', 'item-7', 'item-8', 'item-9', 'item-10', 'item-11', 'item-12', 'item-13', 'item-14'];
        $cfit2_items = ['item-16', 'item-17', 'item-18', 'item-19', 'item-20', 'item-21', 'item-22', 'item-23', 'item-24', 'item-25', 'item-26', 'item-27', 'item-28', 'item-29'];
        $cfit3_items = ['item-31', 'item-32', 'item-33', 'item-34', 'item-35', 'item-36', 'item-37', 'item-38', 'item-39', 'item-40', 'item-41', 'item-42', 'item-43'];
        $cfit4_items = ['item-46', 'item-47', 'item-48', 'item-49', 'item-50', 'item-51', 'item-52', 'item-53', 'item-54', 'item-55'];
        $tiu_items = ['item-58', 'item-59', 'item-60', 'item-61', 'item-62', 'item-63', 'item-64', 'item-65'];
        $ist_items = ['item-68', 'item-69', 'item-70', 'item-71'];
        $tkd_items = ['item-74', 'item-75', 'item-76', 'item-77', 'item-78', 'item-79', 'item-80', 'item-81'];
        $analogi_items = ['item-84', 'item-85', 'item-86', 'item-87'];
        $gatb4_items = ['item-90', 'item-91', 'item-92', 'item-93', 'item-94'];
        $adkudag4_items = ['item-97', 'item-98', 'item-99', 'item-100'];
        $tese_items = ['item-103', 'item-104', 'item-105', 'item-106', 'item-107', 'item-108', 'item-109', 'item-110','item-111', 'item-112', 'item-113', 'item-114', 'item-115', 'item-116', 'item-117', 'item-118','item-119', 'item-120', 'item-121', 'item-122'];

        $holland_items = ['item-125', 'item-126', 'item-127', 'item-128', 'item-129', 'item-130', 'item-131', 'item-132', 'item-133', 'item-134', 'item-135'];

        ob_end_clean();
        ob_start();

        $output = $this->curlResult($testtakerId, $deliveryId);

        $questions['cfit1'] = 13;
        $questions['cfit2'] = 14;
        $questions['cfit3'] = 13;
        $questions['cfit4'] = 10;
        $questions['tiu'] = 40;
        $questions['ist'] = 20;
        $questions['tkd'] = 40;
        $questions['anv'] = 40;
        $questions['gatb4'] = 25;
        $questions['adkudag4'] = 40;
        $questions['tese'] = 20;

        $answered['cfit1'] = 0;
        $answered['cfit2'] = 0;
        $answered['cfit3'] = 0;
        $answered['cfit4'] = 0;
        $answered['tiu'] = 0;
        $answered['ist'] = 0;
        $answered['tkd'] = 0;
        $answered['anv'] = 0;
        $answered['gatb4'] = 0;
        $answered['adkudag4'] = 0;
        $answered['tese'] = 0;

//        echo $output;
        $ret['biodata']['nama'] = '';
        $ret['biodata']['pendidikan'] = '';
        $ret['biodata']['tanggal_lahir'] = '';
        $ret['biodata']['jurusan'] = '';
        $ret['biodata']['pendidikan'] = '';
        $ret['biodata']['email'] = '';
        $ret['biodata']['kelas'] = '';

        $items=simplexml_load_string($output) or die("Error: Cannot create object");
//
        foreach($items as $item_key => $item_value) {
//            echo $item_key;
            echo $item_value->attributes()->identifier;
            echo '<br/>';

                foreach ($item_value as $item2_key => $item2_value) {

                if ($item2_key == 'outcomeVariable') {

                    if  ($item2_value->attributes()->identifier == 'SCORE') {

                        if(strpos($item_value->attributes()->identifier, 'fit_1')) {
                            $cfit1_total = $cfit1_total + $item2_value->value;
                            echo ' - ' . ($item2_key) . ' : ' . $item2_value->attributes()->identifier . ' => ' . $item2_value->value;
                        }

                        if(strpos($item_value->attributes()->identifier, 'fit_2')) {
                            $cfit2_total = $cfit2_total + $item2_value->value;
                            echo ' - ' . ($item2_key) . ' : ' . $item2_value->attributes()->identifier . ' => ' . $item2_value->value;
                        }

                        if(strpos($item_value->attributes()->identifier, 'fit_3')) {
                            $cfit3_total = $cfit3_total + $item2_value->value;
                            echo ' - ' . ($item2_key) . ' : ' . $item2_value->attributes()->identifier . ' => ' . $item2_value->value;
                        }

                        if(strpos($item_value->attributes()->identifier, 'fit_4')) {
                            $cfit4_total = $cfit4_total + $item2_value->value;
                            echo ' - ' . ($item2_key) . ' : ' . $item2_value->attributes()->identifier . ' => ' . $item2_value->value;
                        }


                    }




                } elseif ( $item2_key == 'responseVariable') {

                    if(strpos($item_value->attributes()->identifier, 'ISC_')) {
                        $cfit4_total = $cfit4_total + $item2_value->value;
                        echo ' - ' . ($item2_key) . ' : ' . $item2_value->attributes()->identifier . ' => ' . $item2_value->candidateResponse->value;
                    }

//

                }
                echo '<br/>';

                }

            echo '<hr/>';


        }


//echo '<pre>';
//print_r($items);
//
        if ($debug) {
            echo '<hr/>';
            echo '<br/>CFIT 1 : ' . $cfit1_total;
            echo '<br/>CFIT 2 : ' . $cfit2_total;
            echo '<br/>CFIT 3 : ' . $cfit3_total;
            echo '<br/>CFIT 4 : ' . $cfit4_total;
        }
        return $ret;

    }


    private function curlResult($testtakerId, $deliveryId) {
        $curl = new curl\Curl();
        $taobase = "https://cat.ppsdm.com/taoResultServer/QtiRestResults/getLatest";
        $uri = "https://cat.ppsdm.com/taoResultServer/QtiRestResults/getLatest?testtaker=".urlencode($testtakerId)."&delivery=" . urlencode($deliveryId);
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $uri);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic YWRtaW46YWRtaW4xMjMj',
            'Accept: application/json'
        ));

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);
        return $output;
    }


}
