<?php

namespace frontend\controllers;

use Twilio\Exceptions\RestException;
use Yii;
use frontend\models\Videochat;
use frontend\models\VideochatSearch;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;


/**
 * VideochatController implements the CRUD actions for Videochat model.
 */
class VideochatController extends Controller
{

    protected $sid;
    protected $token;
    protected $key;
    protected $secret;


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();

        // ... initialization after configuration is applied

        $this->sid = Yii::$app->params['sid'];
        $this->token = Yii::$app->params['token'];
        $this->key = Yii::$app->params['key'];
        $this->secret = Yii::$app->params['secret'];
    }

    /**
     * Lists all Videochat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VideochatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRooms()
    {
        $searchModel = new VideochatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('userindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRoomsallopen()
    {

        $twilio = new Client($this->sid, $this->token);

        $rooms = $twilio->video->v1->rooms
            ->read([
                //    "uniqueName" => "DailyStandup"
            ], 20);
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        echo '<pre>';
        foreach ($rooms as $record) {
            print($record->sid);
            echo '<br/>';
            print($record->uniqueName);
            echo '<br/>';
            print($record->type);
            echo '<br/>';
            print($record->status);
            echo '<hr/>';
//            print_r($record);
        }
        echo '</pre>';
    }

    public function actionRoomsbyname($name)
    {

        $twilio = new Client($this->sid, $this->token);

        $rooms = $twilio->video->v1->rooms
            ->read([
                "uniqueName" => $name
            ], 20);

        foreach ($rooms as $record) {
            print($record->sid);
        }
    }

    public function actionRoombysid()
    {
        $twilio = new Client($this->sid, $this->token);

        $rooms = $twilio->video->v1->rooms("RMca8ec27c3b26ac8b4ed140c64039ab0b")
            ->fetch();



            print($rooms->sid);
            echo '<br/>';
            print($rooms->uniqueName);
            echo '<br/>';
            print($rooms->type);
            echo '<br/>';
            print($rooms->status);
            echo '<hr/>';

    }
    public function actionRoomsbystatus($status)
    {

                $twilio = new Client($this->sid, $this->token);

        $rooms = $twilio->video->v1->rooms
            ->read([
//                "sid" => "RMca8ec27c3b26ac8b4ed140c64039ab0b",
                "status" => $status,
            ], 20);

        foreach ($rooms as $record) {
            print($record->sid);
            echo '<br/>';
            print($record->uniqueName);
            echo '<br/>';
            print($record->type);
            echo '<br/>';
            print($record->status);
            echo '<hr/>';
        }

    }

    /**
     * Displays a single Videochat model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Videochat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Videochat();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Videochat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Videochat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Videochat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Videochat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Videochat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionCreateroom($id)
    {
        $videochat = Videochat::findOne($id);
        $client = new Client($this->sid, $this->token);

        $exists = $client->video->rooms->read([ 'uniqueName' => $videochat->roomname]);

        if (empty($exists)) {
            $response = $client->video->rooms->create([
                'uniqueName' => $videochat->roomname,
                'type' => $videochat->type,
                'recordParticipantsOnConnect' => true
            ]);
//            \Log::debug("created new room: ".$request->roomName);
            $videochat->roomId = $response->sid;
            $videochat->status = $response->status;
            $videochat->save();
            Yii::$app->session->setFlash('success', $response->uniqueName . " created");


        } else {
//            Yii::$app->session->setFlash('warning', "Room existed");

        }
        return $this->redirect(['index']);
//        return redirect()->action('VideoRoomsController@joinRoom', [
//            'roomName' => $request->roomName
//        ]);
    }

    public function actionHostjoin($id,$identity)
    {




        $videochat = Videochat::findOne($id);
        $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);


        
        $twilio = new Client($this->sid, $this->token);

        $rooms = $twilio->video->v1->rooms
            ->read([
                "uniqueName" => $videochat->roomname
            ], 20);

        // foreach ($rooms as $record) {
        //     print($record->sid);
        // }

if (sizeof($rooms) == 0) {
    Yii::$app->session->setFlash('warning', $videochat->roomname . " dont exist");
    return $this->redirect(['index']);
} else {
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($videochat->roomname);

        $token->addGrant($videoGrant);

        return $this->render('host_room', [
            'accessToken' => $token->toJWT(), 'roomName' => $videochat->roomname, 'roomId' => $id,
        ]);

}

    }


    public function actionUserroom($id, $identity, $username)
    {
        //        $identity = 'reno';
        $videochat = Videochat::findOne($id);
//        \Log::debug("joined with identity: $identity");
        $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);

        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($videochat->roomname);

        $token->addGrant($videoGrant);

//        print_r($token->toJWT());
        return $this->render('user_room', [
            'accessToken' => $token->toJWT(), 'roomName' => $videochat->roomname, 'roomId' => $id, 'username' => $username
        ]);
    }
    public function actionUserjoin($id,$identity)
    {

        if ($_POST)
        {
            Yii::$app->session->setFlash('success', "POST " . $_POST['name']);
            $this->redirect(['userroom', 'id' => $id, 'identity' => $identity, 'username' => $_POST['name']]);
        } else {
            Yii::$app->session->setFlash('warning', "no post ");
        }
        return $this->render('user_join', [
//            'id' => $id, 'identity' => $identity
        ]);

    }

    public function actionCompleteroom($id)
    {
        $videochat = Videochat::findOne($id);
        $twilio = new Client($this->sid, $this->token);

        $existingroom = $twilio->video->v1->rooms($videochat->roomname)
            ->fetch();

//        print($room->uniqueName);

        try {
            $room = $twilio->video->v1->rooms($existingroom->sid)
                ->update("completed");

            $videochat->status = $room->status;
            $videochat->duration = $room->duration;
            $videochat->save();
            Yii::$app->session->setFlash('success', "Videochat is COMPLETED - room terminated. duration : " . $room->duration);

        } catch (RestException $e) {
            Yii::$app->session->setFlash('warning', "room not existed");

        }
        return $this->redirect(['index']);
    }

    public function actionRecordings($id)
    {
        $videochat = Videochat::findOne($id);
        $twilio = new Client($this->sid, $this->token);
        $recordings = $twilio->video->v1->rooms($videochat->roomId)
            ->recordings
            ->read([], 20);

        foreach ($recordings as $record) {
            if ($record->type == 'video')
             echo Html::a($record->type . ' : ' .$record->links['media'], ['videochat/composerecording', 'id' => $id]);
//            print($record->links['media']);
            echo '<br/>';

        }

        echo '<hr/>Composition <br/>';


    }


    public function actionCompositions($id){

        $videochat = Videochat::findOne($id);
        $twilio = new Client($this->sid, $this->token);
        $compositions = $twilio->video->compositions
            ->read([
                'roomSid' => $videochat->roomId
            ]);

        foreach ($compositions as $c) {
            echo $c->sid;
            echo '<br/>';
        }
    }
    public function actionComposerecording($id)
    {
        $videochat = Videochat::findOne($id);
        $twilio = new Client($this->sid, $this->token);

        $compositions = $twilio->video->compositions
            ->read([
                'roomSid' => $videochat->roomId
            ]);


//        echo sizeof($compositions);

        if (sizeof($compositions) < 1) {
            $composition = $twilio->video->compositions->create($videochat->roomId, [
                'audioSources' => '*',
                'videoLayout' =>  array(
                    'single' => array (
                        'video_sources' => array('*')
                    )
                ),
                'statusCallback' => 'http://my.server.org/callbacks',
                'format' => 'mp4'
            ]);
            echo '<pre>';
            echo 'start processing composition';
            print_r($composition->links);
//        $response = $twilio->request("GET", $composition->links['media']);
////        $mediaLocation = $response->getContent()["redirect_to"];
//        print_r($response);
        } else {
            echo 'please wait until status "completed" <br/>';
                    foreach ($compositions as $c) {
            echo $c->links['media'] . ' : ' . $c->status;
            echo '<br/>';
        }
        }

    }





    public function actionGetrecordingmedia($id, $recordId)
    {
        $videochat = Videochat::findOne($id);
        $twilio = new Client($this->sid, $this->token);
        $uri = "https://video.twilio.com/v1/" .
            "Rooms/$videochat->roomId/" .
            "Recordings/$recordId/" .
            "Media/";
        $response = $twilio->request("GET", $uri);
        $mediaLocation = $response->getContent()["redirect_to"];

        echo $mediaLocation;
//        $media_content = file_get_contents($mediaLocation);
//        print_r($media_content);
    }


}
