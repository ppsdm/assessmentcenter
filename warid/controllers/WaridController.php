<?php

namespace warid\controllers;
use app\models\ResultsStorage;
use linslin\yii2\curl;
use warid\models\KamusUraian;
use warid\models\ScaleRef;
use warid\models\TaoDelivery;
use yii\httpclient\XmlParser;

use yii\data\ActiveDataProvider;
use Twilio\Rest\Client;
class WaridController extends \yii\web\Controller
{

    public function actionIndex($id)
    {
//        $searchModel = new ProjectSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
        $taodelivery = TaoDelivery::find()->andWhere(['id' => $id])->andWhere(['status' => 'active'])->One();
//        $deliveryURI = 'http://cat.ppsdm.com/cat.rdf#i159084539617004827';
        $deliveryURI =$taodelivery->delivery_uri;
//        $deliveryURI = 'http://cat.ppsdm.com/cat.rdf#i159129520437266901';
        $testtakers = ResultsStorage::find()->select(['test_taker'])->andWhere(['delivery' => $deliveryURI])->distinct()->All();

        $dataProvider = new ActiveDataProvider([
            'query' => ResultsStorage::find()
//                ->select(['test_taker'])
                ->andWhere(['delivery' => $deliveryURI])->distinct(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

//        echo '<pre>';
//        print_r($testtakers);
        return $this->render('index', [
//            'searchModel' => $searchModel,
            'deliveryModel' => $taodelivery,
            'dataProvider' => $dataProvider,
            'id' => $id
        ]);
    }
    public function actionTwiliocreate()
        {
// Your Account SID and Auth Token from twilio.com/console
        $sid = 'ACc08adc757aeb79271f3c751e6b8f8f3d';
        $token = 'e5adee7bfde4ed8fef0e84c2c8a2d2bd';
        $twilio = new Client($sid, $token);


        $room = $twilio->video->v1->rooms
            ->create([
                    "recordParticipantsOnConnect" => True,
                    "statusCallback" => "http://example.org",
                    "type" => "group",
                    "uniqueName" => "DailyStandup",
                    "duration" => "30"
                ]
            );
        echo '<pre>';
        print_r($room);
        echo '</pre>';
        }

    public function actionTwilioread()
    {
// Your Account SID and Auth Token from twilio.com/console
        $sid = 'ACc08adc757aeb79271f3c751e6b8f8f3d';
        $token = 'e5adee7bfde4ed8fef0e84c2c8a2d2bd';
        $twilio = new Client($sid, $token);


        $rooms = $twilio->video->v1->rooms
            ->read(["uniqueName" => "DailyStandup"], 20);

        echo '<pre/>';
        foreach ($rooms as $record) {
            print_r($record);
        }
    }


    public function actionTestpdf()
    {

        return $this->render('testpdf');
    }
    public function actionPdf()
    {


        return $this->render('index',
            [
//                'biodata' => $biodata;
//                ''
            ]

        );

    }

    private function curlResult($testtakerId, $deliveryId) {
        $curl = new curl\Curl();
//        $deliveryURI = 'http://cat.ppsdm.com/cat.rdf#i159084539617004827';
//        $testtakerURI = 'http://cat.ppsdm.com/cat.rdf#i159075081183274815';
        $taobase = "http://cat.ppsdm.com/taoResultServer/QtiRestResults/getLatest";
                $uri = "http://cat.ppsdm.com/taoResultServer/QtiRestResults/getLatest?testtaker=".urlencode($testtakerId)."&delivery=" . urlencode($deliveryId);
//        $uri = "http://cat.ppsdm.com/taoResultServer/QtiRestResults/getLatest?testtaker=http%3A%2F%2Fcat.ppsdm.com%2Fcat.rdf%23i1589530618237525&delivery=http%3A%2F%2Fcat.ppsdm.com%2Fcat.rdf%23i158969457756132314"; //uri bermasalah karena ada photoupload
//        $uri = "http://cat.ppsdm.com/taoResultServer/QtiRestResults/getLatest?testtaker=http%3A%2F%2Fcat.ppsdm.com%2Fcat.rdf%23i1589530618237525&delivery=http%3A%2F%2Fcat.ppsdm.com%2Fcat.rdf%23i159056451292282685";
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

    private function getRiasec($riasec) {

        $sort_order = ['r','i','a','s','e','c'];



        $ret = [];
        foreach ($riasec as $key=>$value) {
//            echo '<br/>' . $key;
            if (sizeof($ret) < 6) {
               $ret[$key] = $value;
//                echo 'emptyyyyyyyyyy';
            } else {

                foreach (array_reverse($ret) as $ret_key => $ret_value) {
                    if ($ret_value == min($ret)) {
                        $ret[$key] = $value;
                    }
                }
            }
        }

        arsort($ret);
        if ($ret[array_key_first(array_slice($ret,2,1))] == $ret[array_key_first(array_slice($ret,3,1))]) {
            return array_slice($ret,0,2);
        }
        $slice = array_slice($ret,0,3);

        return $slice;
    }

    private function countAnswered($item2_value, $type,$needle,&$answered) {

            if(strpos($item2_value->attributes()->identifier, $needle)) {

                if (trim($item2_value->candidateResponse->value) !== '') {

                    $answered[$type]++;
                }

            }

    }

    public function actionNilaiwarid($testtakerId, $deliveryId,$deliveryType) {
        $result = $this->getNilaiwarid($testtakerId, $deliveryId, true);
        echo '<pre>';
        print_r($result);
        ob_end_clean();
        return $this->render('deliveryType', [
            'result' => $result,
        ]);


    }
    private function getIqUraian($score) {
        switch ($score) {
            case $score < 70 :
                return ['Jauh di bawah rata-rata','<70'];
            case $score < 85 :
                return ['Di bawah rata-rata','70 - 84'];
            case $score < 95 :
                return ['Rata-rata batas bawah','85 - 94'];
            case $score < 105 :
                return ['Rata-rata', '95 - 104'];
            case $score < 115 :
                return ['Rata-rata batas atas', '105 - 114'];
            case $score <= 130 :
                return ['Di atas rata-rata', '115 - 130'];
            default :
                return ['Jauh di atas rata-rata', '130 >'];
        }
    }
    private function getRst($score)
    {
        switch ($score) {
            case $score < 4 :
                return 'r';
            case $score == 4 :
                return 's';
            default :
                return 't';
        }
    }
    public function getNilaiwarid($testtakerId, $deliveryId, $debug) {


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

        foreach($items as $item_key => $item_value) {

            foreach($item_value as $item2_key => $item2_value)
            {

                if ($item2_key == 'outcomeVariable') {
//                    echo ' - ' . ($item2_key) . ' : ' . $item2_value->attributes()->identifier . ' => ' . $item2_value->value;

                    if (in_array($item_value->attributes()->identifier, $cfit1_items) && ($item2_value->attributes()->identifier == 'SCORE')) {
                        $cfit1_total = $cfit1_total + $item2_value->value;
                    }
                    if (in_array($item_value->attributes()->identifier, $cfit2_items) && ($item2_value->attributes()->identifier == 'SCORE')) {
                        $cfit2_total = $cfit2_total + $item2_value->value;
                    }
                    if (in_array($item_value->attributes()->identifier, $cfit3_items) && ($item2_value->attributes()->identifier == 'SCORE')) {
                        $cfit3_total = $cfit3_total + $item2_value->value;
                    }
                    if (in_array($item_value->attributes()->identifier, $cfit4_items) && ($item2_value->attributes()->identifier == 'SCORE')) {
                        $cfit4_total = $cfit4_total + $item2_value->value;
                    }
                    if (in_array($item_value->attributes()->identifier, $tiu_items) && ($item2_value->attributes()->identifier == 'SCORE')) {
                        $tiu_total = $tiu_total + $item2_value->value;
                    }
                    if (in_array($item_value->attributes()->identifier, $ist_items) && ($item2_value->attributes()->identifier == 'SCORE')) {
                        $ist_total = $ist_total + $item2_value->value;
                    }
                    if (in_array($item_value->attributes()->identifier, $tkd_items) && ($item2_value->attributes()->identifier == 'SCORE')) {
                        $tkd_total = $tkd_total + $item2_value->value;
                    }
                    if (in_array($item_value->attributes()->identifier, $analogi_items) && ($item2_value->attributes()->identifier == 'SCORE')) {
                        $analogi_total = $analogi_total + $item2_value->value;
                    }
                    if (in_array($item_value->attributes()->identifier, $gatb4_items) && ($item2_value->attributes()->identifier == 'SCORE')) {
                        $gatb4_total = $gatb4_total + $item2_value->value;
                    }
                    if (in_array($item_value->attributes()->identifier, $adkudag4_items) && ($item2_value->attributes()->identifier == 'SCORE')) {
                        $adkudag4_total = $adkudag4_total + $item2_value->value;
                    }
                    if (in_array($item_value->attributes()->identifier, $tese_items) && ($item2_value->attributes()->identifier == 'SCORE')) {
                        $tese_total = $tese_total + $item2_value->value;
                    }


                } elseif ( $item2_key == 'responseVariable') {
//                    echo '<br/>';
//

                    if (in_array($item_value->attributes()->identifier, $biodata_items)) {
                        if ($debug) {
                            echo '<br/>';
                            $ret['biodata'][(string) $item2_value->attributes()->identifier] = (string)$item2_value->candidateResponse->value;
                            echo $item2_value->attributes()->identifier . ' : ' .$item2_value->candidateResponse->value;
                        }


                    }

                    if (in_array($item_value->attributes()->identifier, $cfit1_items)) {
                            $this->countAnswered($item2_value, 'cfit1', 'ESPONS', $answered);
                    }
                    if (in_array($item_value->attributes()->identifier, $cfit2_items)) {
                        $this->countAnswered($item2_value, 'cfit2', 'ESPONS',$answered);
                    }
                    if (in_array($item_value->attributes()->identifier, $cfit3_items)) {
                        $this->countAnswered($item2_value, 'cfit3', 'ESPONS',$answered);
                    }
                    if (in_array($item_value->attributes()->identifier, $cfit4_items)) {
                        $this->countAnswered($item2_value, 'cfit4', 'ESPONS',$answered);
                    }
                    if (in_array($item_value->attributes()->identifier, $tiu_items)) {
                        $this->countAnswered($item2_value, 'tiu', 'ESPONS',$answered);
                    }
                    if (in_array($item_value->attributes()->identifier,$ist_items)) {
                        $this->countAnswered($item2_value, 'ist', 'oal',$answered);
                    }
                    if (in_array($item_value->attributes()->identifier, $tkd_items)) {
                        $this->countAnswered($item2_value, 'tkd', 'ESPONS', $answered);
                    }
                    if (in_array($item_value->attributes()->identifier, $analogi_items)) {
                        $this->countAnswered($item2_value, 'anv', 'ESPONS', $answered);
                    }
                    if (in_array($item_value->attributes()->identifier, $gatb4_items)) {
                        $this->countAnswered($item2_value, 'gatb4', 'ATB', $answered);
                    }
                    if (in_array($item_value->attributes()->identifier, $adkudag4_items)) {
                        $this->countAnswered($item2_value, 'adkudag4', 'ESPONS', $answered);
                    }
                    if (in_array($item_value->attributes()->identifier, $adkudag4_items)) {
                        $this->countAnswered($item2_value, 'adkudag4', 'DKUDAG', $answered);
                    }
                    if (in_array($item_value->attributes()->identifier, $tese_items)) {
                        $this->countAnswered($item2_value, 'tese', 'ESPONS', $answered);
                    }
                    if (in_array($item_value->attributes()->identifier, $tese_items)) {
                        $this->countAnswered($item2_value, 'tese', 'ESe', $answered);
                    }

                    if (in_array($item_value->attributes()->identifier, $holland_items)) {
                        if(strpos($item2_value->candidateResponse->value, 'OLLAND_')) {
                            if (!strpos($item2_value->candidateResponse->value, 'T_X')) {
//                                echo '<br/>';
//                                echo ' - ' . ($item2_key) . ' : ' . $item2_value->attributes()->identifier . ' => ' . $item2_value->candidateResponse->value;
//                                echo '<br/>';
                                switch (substr($item2_value->candidateResponse->value, -1)) {
                                    case 'R' :
                                        $holland['r']++;
                                        break;
                                    case 'I' :
                                        $holland['i']++;
                                        break;
                                    case 'A' :
                                        $holland['a']++;
                                        break;
                                    case 'S' :
                                        $holland['s']++;
                                        break;
                                    case 'E' :
                                        $holland['e']++;
                                        break;
                                    case 'C' :
                                        $holland['c']++;
                                        break;
                                }
                            }
                        }


                    }
                }




            }


        }

//        $holland['s'] = 5;

        $cfit14 = $cfit1_total + $cfit2_total + $cfit3_total + $cfit4_total;
        $riasec = $this->getRiasec($holland);
        $inteligensi_umum = ScaleRef::find()->andWhere(['scale_name' => 'cfit-to-6'])->andWhere(['>=','unscaled',$cfit14])->One()->scaled;
        $iq = ScaleRef::find()->andWhere(['scale_name' => 'iq'])->andWhere(['>=','unscaled',$cfit14])->One()->scaled;
        $tiu = ScaleRef::find()->andWhere(['scale_name' => '20to6'])->andWhere(['>=','unscaled', ScaleRef::find()->andWhere(['scale_name' => 'tiu'])->andWhere(['>=','unscaled',$tiu_total])->One()->scaled])->One()->scaled;
        $ist =             ScaleRef::find()->andWhere(['scale_name' => '20to6'])
            ->andWhere(['>=','unscaled', ScaleRef::find()->andWhere(['scale_name' => 'ist'])
                ->andWhere(['>=','unscaled',$ist_total])->One()->scaled])->One()->scaled;
        $tkd =             ScaleRef::find()->andWhere(['scale_name' => '20to6'])
            ->andWhere(['>=','unscaled', ScaleRef::find()->andWhere(['scale_name' => 'tkd'])
                ->andWhere(['>=','unscaled',$tkd_total])->One()->scaled])->One()->scaled;
        $anv =             ScaleRef::find()->andWhere(['scale_name' => '20to6'])
            ->andWhere(['>=','unscaled', ScaleRef::find()->andWhere(['scale_name' => 'anv'])
                ->andWhere(['>=','unscaled',$analogi_total])->One()->scaled])->One()->scaled;
        $gatb4 =             ScaleRef::find()->andWhere(['scale_name' => '20to6'])
            ->andWhere(['>=','unscaled', ScaleRef::find()->andWhere(['scale_name' => 'gatb4'])
                ->andWhere(['>=','unscaled',$gatb4_total])->One()->scaled])->One()->scaled;
        $adk4 =             ScaleRef::find()->andWhere(['scale_name' => '20to6'])
            ->andWhere(['>=','unscaled', ScaleRef::find()->andWhere(['scale_name' => 'adk4'])
                ->andWhere(['>=','unscaled',$adkudag4_total])->One()->scaled])->One()->scaled;
        $tese =             ScaleRef::find()->andWhere(['scale_name' => '20to6'])
            ->andWhere(['>=','unscaled', ScaleRef::find()->andWhere(['scale_name' => 'tese'])
                ->andWhere(['>=','unscaled',$tese_total])->One()->scaled])->One()->scaled;

//        echo '<br/>CFIT 1-4 / IQ / INTELIGENSI UMUM : ' . $cfit14;

        $daya_analisa_sintesa = ($tiu + $ist + $tkd) / 3;
        $konseptual = $anv;
        $pengetahuan_umum = $tkd;
        $orientasi_pandang_ruang = $tiu;
        $kemampuan_dasar_keteknikan = $tese;
        $kemampuan_numerik = $gatb4;
        $klasifikasi = $adk4;

//        $konsentrasi = ($kecepatan + $ketelitian) / 2;

        $stabilitas_emosi = $inteligensi_umum - 1;
        $penyesuaian_diri = $ist - 1;
        $hubungan_internasional = (($ist * 3) + $tkd + $anv + $adk4) / 6;

        $kecepatan = [];
        $ketelitian = [];



        $kecepatan['cfit1'] = $answered['cfit1'] / $questions['cfit1'];
        $kecepatan['cfit2'] = $answered['cfit2'] / $questions['cfit2'];
        $kecepatan['cfit3'] = $answered['cfit3'] / $questions['cfit3'];
        $kecepatan['cfit4'] = $answered['cfit4'] / $questions['cfit4'];
        $kecepatan['tiu'] = $answered['tiu'] / $questions['tiu'];
        $kecepatan['ist'] = $answered['ist'] / $questions['ist'];
        $kecepatan['tkd'] = $answered['tkd'] / $questions['tkd'];
        $kecepatan['anv'] = $answered['anv'] / $questions['anv'];
        $kecepatan['gatb4'] = $answered['gatb4'] / $questions['gatb4'];
        $kecepatan['adkudag4'] = $answered['adkudag4'] / $questions['adkudag4'];
        $kecepatan['tese'] = $answered['tese'] / $questions['tese'];

        $ketelitian['cfit1'] =  $cfit1_total / $answered['cfit1'];
        $ketelitian['cfit2'] =  $cfit2_total / $answered['cfit2'];
        $ketelitian['cfit3'] =  $cfit3_total / $answered['cfit3'];
        $ketelitian['cfit4'] =  $cfit4_total / $answered['cfit4'];
        $ketelitian['tiu'] =  $tiu_total / $answered['tiu'];
        $ketelitian['ist'] =  $ist_total / $answered['ist'];
        $ketelitian['tkd'] =  $tkd_total / $answered['tkd'];
        $ketelitian['anv'] =  $analogi_total / $answered['anv'];
        $ketelitian['gatb4'] =  $gatb4_total / $answered['gatb4'];
        $ketelitian['adkudag4'] =  $adkudag4_total / $answered['adkudag4'];
        $ketelitian['tese'] =  $tese_total / $answered['tese'];
        $average_kecepatan = array_sum($kecepatan)/count($kecepatan);
        $average_ketelitian = array_sum($ketelitian)/count($ketelitian);

        $cepat = ScaleRef::find()->andWhere(['scale_name' => 'kecepatan'])
            ->andWhere(['<=','unscaled', $average_kecepatan * 100])
            ->orderBy(['unscaled' => SORT_DESC])
            ->One();
        $teliti = ScaleRef::find()->andWhere(['scale_name' => 'ketelitian'])
            ->andWhere(['<=','unscaled', $average_ketelitian* 100])
            ->orderBy(['unscaled' => SORT_DESC])
            ->One();
        $konsentrasi = ($cepat->scaled + $teliti->scaled) / 2;
        $ret['aspek']['inteligensi_umum'] = $inteligensi_umum;
        $ret['aspek']['iq'] = $iq;
        $ret['aspek']['daya_analisa_sintesa'] = round($daya_analisa_sintesa);
        $ret['aspek']['konseptual'] = $konseptual;
        $ret['aspek']['pengetahuan_umum'] = $pengetahuan_umum;
        $ret['aspek']['orientasi_pandang_ruang'] = $orientasi_pandang_ruang;
        $ret['aspek']['kemampuan_numerik'] = $kemampuan_numerik;
        $ret['aspek']['klasifikasi_diferensiasi'] = $klasifikasi;
        $ret['aspek']['kemampuan_dasar_keteknikan'] = $kemampuan_dasar_keteknikan;
        $ret['aspek']['kecepatan_kerja'] = $cepat->scaled;
        $ret['aspek']['ketelitian_kerja'] = $teliti->scaled;
        $ret['aspek']['konsentrasi'] = round($konsentrasi);
        $ret['aspek']['stabilitas_emosi'] = $stabilitas_emosi;
        $ret['aspek']['penyesuaian_diri'] = $penyesuaian_diri;
        $ret['aspek']['hubungan_interpersonal'] = round($hubungan_internasional);
        $ret['level']['aspek_kecerdasan'] = $this->getRst($inteligensi_umum) . $this->getRst(round($daya_analisa_sintesa)) . $this->getRst($konseptual);
        $ret['level']['aspek_kepribadian'] = $this->getRst($stabilitas_emosi) . $this->getRst($penyesuaian_diri) . $this->getRst(round($hubungan_internasional));
        $ret['level']['aspek_sikap_kerja'] = $this->getRst($cepat->scaled) . $this->getRst($teliti->scaled) . $this->getRst(round($konsentrasi));
        $ret['level']['pengetahuan_umum'] = $this->getRst($pengetahuan_umum);
        $ret['level']['kemampuan_numerik'] = $this->getRst($kemampuan_numerik);
        $ret['level']['kemampuan_dasar_teknik'] = $this->getRst($kemampuan_dasar_keteknikan);
        $ret['level']['klasifikasi_diferensiasi'] = $this->getRst($klasifikasi);
        $ret['level']['orientasi_pandang_ruang'] = $this->getRst($orientasi_pandang_ruang);
        $uraian1 = KamusUraian::find()->andWhere(['aspek' => 'Inteligensi Umum - Kemampuan Berpikir Analitis Sintesis - Kemampuan Berpikir Konseptual'])->andWhere(['level' => $ret['level']['aspek_kecerdasan']])->andWhere(['varian' => '1'])->One();
        $ret['uraian']['aspek_kecerdasan'] = str_replace('SUBYEK', $ret['biodata']['nama'], $uraian1->description);
        $uraian2 = KamusUraian::find()->andWhere(['aspek' => 'Stabilitas Emosi - Penyesuaian Diri - Hubungan Interpersonal'])
            ->andWhere(['level' => $ret['level']['aspek_kepribadian']])->andWhere(['varian' => '1'])->One();
        $uraian3 = KamusUraian::find()->andWhere(['aspek' => 'Kecepatan Kerja - Ketelitian Kerja - Konsentrasi'])
            ->andWhere(['level' => $ret['level']['aspek_sikap_kerja']])->andWhere(['varian' => '1'])->One();
        $ret['uraian']['aspek_kepribadian'] = str_replace('SUBYEK', $ret['biodata']['nama'], $uraian2->description);
        $ret['uraian']['aspek_sikap_kerja'] = str_replace('SUBYEK', $ret['biodata']['nama'], $uraian3->description);

        $ret['uraian']['pengetahuan_umum'] = (KamusUraian::find()->andWhere(['aspek' => 'Pengetahuan Umum'])
            ->andWhere(['level' => $ret['level']['pengetahuan_umum']])->andWhere(['varian' => '1'])->One())->description;
        $ret['uraian']['kemampuan_numerik'] = (KamusUraian::find()->andWhere(['aspek' => 'Kemampuan Numerik'])
            ->andWhere(['level' => $ret['level']['kemampuan_numerik']])->andWhere(['varian' => '1'])->One())->description;
        $ret['uraian']['kemampuan_dasar_teknik'] = (KamusUraian::find()->andWhere(['aspek' => 'Kemampuan Dasar Teknik'])
            ->andWhere(['level' => $ret['level']['kemampuan_dasar_teknik']])->andWhere(['varian' => '1'])->One())->description;
        $ret['uraian']['klasifikasi_dan_diferensiasi'] = (KamusUraian::find()->andWhere(['aspek' => 'Klasifikasi dan Diferensiasi'])
            ->andWhere(['level' => $ret['level']['klasifikasi_diferensiasi']])->andWhere(['varian' => '1'])->One())->description;
        $ret['uraian']['orientasi_pandang_ruang'] = (KamusUraian::find()->andWhere(['aspek' => 'Orientasi Pandang Ruang'])
            ->andWhere(['level' => $ret['level']['orientasi_pandang_ruang']])->andWhere(['varian' => '1'])->One())->description;
        $ret['uraian']['iq'] = $this->getIqUraian($iq)[0];
        $ret['uraian']['range_iq'] = $this->getIqUraian($iq)[1];
        $ret['riasec'] = '';
        foreach($riasec as $key => $item) {
            $ret['riasec'] = $ret['riasec'] . $key;
        }



        if ($debug) {
            echo '<br/><br/>ANSWERED : <pre>';
            print_r($answered);
            echo '</pre>';
            echo '<hr/>';
            echo '<br/>CFIT 1 : ' . $cfit1_total;
            echo '<br/>CFIT 2 : ' . $cfit2_total;
            echo '<br/>CFIT 3 : ' . $cfit3_total;
            echo '<br/>CFIT 4 : ' . $cfit4_total;
            echo '<br/>TIU : ' . $tiu_total;
            echo '<br/>IST : ' . $ist_total;
            echo '<br/>TKD : ' . $tkd_total;
            echo '<br/>Analogi : ' . $analogi_total;
            echo '<br/>gatb4 : ' . $gatb4_total;
            echo '<br/>adkudag4 : ' . $adkudag4_total;
            echo '<br/>Tes E : ' . $tese_total;
            echo '<br/>Holland R : ' . $holland['r'];
            echo '<br/>Holland I : ' . $holland['i'];
            echo '<br/>Holland A : ' . $holland['a'];
            echo '<br/>Holland S : ' . $holland['s'];
            echo '<br/>Holland E : ' . $holland['e'];
            echo '<br/>Holland C : ' . $holland['c'];

            echo '<hr/>';
            echo '<h2>SCALED to 6</h2>';
            echo '<br/>CFIT 1-4 : ' . $inteligensi_umum;

            echo '<br/>TIU : ' . $tiu;
            echo '<br/>IST : ' . $ist;;
            echo '<br/>TKD : ' . $tkd;

            echo '<br/>Analogi : ' . $anv;
            echo '<br/>gatb4 : ' . $gatb4;
            echo '<br/>adkudag4 : ' . $adk4;
            echo '<br/>Tes E : ' . $tese;
            echo '<pre>';
            print_r($riasec);
            echo '</pre>';
            echo '<hr/>';


            echo '<br/>INTELIGENSI UMUM : ' . $inteligensi_umum;
            echo '<br/>IQ : ' . $iq;
            echo '<br/>DAYA ANALISA SINTESA (TIU + IST + TKD) / 3 = ' . $daya_analisa_sintesa;
            echo '<br/>KONSEPTUAL (anv ) = ' . $konseptual;
            echo '<br/>PENGETAHUAN UMUM (TKD) = ' . $pengetahuan_umum;
            echo '<br/>ORIENTASI PANDANG RUANG (TIU) = ' . $orientasi_pandang_ruang;
            echo '<br/>KEMAMPUAN NUMERIK (gatb4) = ' . $kemampuan_numerik;
            echo '<br/>KLASIFIKASI DAN DIFERENSIASI (adk4) = ' . $klasifikasi;
            echo '<br/>KEMAMPUAN DASAR KETEKNIKAN (tes e) = ' . $kemampuan_dasar_keteknikan;
            echo '<br/>';
//        echo '<br/>KECEPATAN KERJA (DF4) = ' . $kecepatan;
//        echo '<br/>KETELITIAN KERJA (DG4) = ' . $ketelitian;
            echo '<br/>KONSENTRASI (kecepatan + ketelitian) / 2 = ' . $konsentrasi;

            echo '<br/>STABILITAS EMOSI (IQskala6 - 1) = ' . $stabilitas_emosi;
            echo '<br/>PENYESUAIAN DIRI (Subtest 6 - 1) = ' . $penyesuaian_diri;
            echo '<br/>HUBUNGAN INTERNASIONAL ((subtest 6 * 3) + (SUBTEST 7 + 8 + 10)))/6 = ' . $hubungan_internasional;

            echo '<pre>';
            print_r($kecepatan);
            print_r($ketelitian);
            echo '</pre>kecepatan';
            echo $average_kecepatan;
            echo '<br/>';
            echo($cepat->scaled);
            echo '<br/>ketelitian';
            echo $average_ketelitian;
            echo '<br/>';
            echo($teliti->scaled);
            echo '<hr/>';
        }
        return $ret;

    }
    public function actionDebugresult($testtakerId, $deliveryId)
    {
        ob_end_clean();
        ob_start();

        $output = $this->curlResult($testtakerId, $deliveryId);


//        echo $output;

        $items=simplexml_load_string($output) or die("Error: Cannot create object");

        foreach($items as $item_key => $item_value) {
            echo $item_key;
            echo ' : ';
            echo $item_value->attributes()->identifier;

            foreach($item_value as $item2_key => $item2_value)
            {
                echo '<br/>';
                if ($item2_key == 'outcomeVariable') {
                    echo ' - ' . ($item2_key) . ' : ' . $item2_value->attributes()->identifier . ' => ' . $item2_value->value;
                } elseif ( $item2_key == 'responseVariable') {

                    echo ' - ' . ($item2_key) . ' : ' . $item2_value->attributes()->identifier . ' => ' . $item2_value->candidateResponse->value;
                }




            }


//            if ($item_key == 'itemResult') {
//
//                foreach ($item_value->outcomeVariable as $outcome_var) {
//                    echo $outcome_var->attributes()->identifer;

//                }
//
//            }
            echo '<hr/>';
        }

    }
    public function actionGetlatestresult($testtakerId, $deliveryId)
    {

        ob_end_clean();
        ob_start();


        $output = $this->curlResult($testtakerId, $deliveryId);

        /*        $output = "<?xml version='1.0' encoding='UTF-8'?>" . $output;*/
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;

        print_r($output);
//        var_dump($response);
//        echo gettype($response);
//        $parser = new XmlParser($response->assessmentResult);
//        return $parser;
    }

}
;