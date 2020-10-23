<?php


namespace app\modules\project\controllers;

use frontend\models\TaoUser;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `project` module
 */
class TaoController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegister()
    {
        $newUser = new TaoUser();

        if ($newUser->load(Yii::$app->request->post())
//            && $newUser->save()
        ) {

            $getUrl = 'https://cat.ppsdm.com/taoTestTaker/api/testTakers?' . 'login='.$newUser->username.'&password='.$newUser->password.'&userLanguage=English';
            $cURLConnection = curl_init($getUrl);
            curl_setopt($cURLConnection, CURLOPT_POST, 1);
            curl_setopt($cURLConnection, CURLOPT_USERPWD, $this->module->params['api_username'] . ":" . $this->module->params['api_password']);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
//

            $headers = [
                'Accept: application/json'
            ];

            curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $headers);

            $apiResponse = curl_exec($cURLConnection);
            curl_close($cURLConnection);

// $apiResponse - available data from the API request
            $jsonArrayResponse = json_decode($apiResponse);

            if ($jsonArrayResponse->success) {

                $exist = TaoUser::find()->andWhere(['user_uri' => $jsonArrayResponse->uri])->One();
                if (!is_null($exist)) {
                    $exist->save();
                    Yii::$app->session->setFlash('success', $jsonArrayResponse->uri . 'exist');
                } else {
                    $newUser->user_uri = $jsonArrayResponse->uri;
                    if($newUser->save()) {
                        Yii::$app->session->setFlash('success', $jsonArrayResponse->uri . 'new');
                    } else {
                        Yii::$app->session->setFlash('success', $jsonArrayResponse->uri . json_encode($newUser->errors));
                    }

                }
                $result = Yii::$app->mailer->compose()
                    ->setFrom('renowijoyo@gmail.com')
                    ->setTo($newUser->username)
                    ->setSubject('New Registrtaion')
                    ->setTextBody('Plain text content')
                    ->setHtmlBody('<b>Anda telah teregistrasi</b>')
                    ->send();

            } else {
                Yii::$app->session->setFlash('warning', $jsonArrayResponse->errorMsg);
            }

           // return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('register',
            ['model' => $newUser,
            ]);



    }

    public function actionEmail() {
        $result = Yii::$app->mailer->compose()
            ->setFrom('renowijoyo@gmail.com')
            ->setTo('renowijoyo@gmail.com')
            ->setSubject('New Registrtaion')
            ->setTextBody('Plain text content')
            ->setHtmlBody('<b>HTML content</b>')
            ->send();

        print_r($result);
    }

    public function actionChangepassword()
    {
        return $this->render('changepassword');
    }

    public function actionProfile($uri)
    {


        return $this->render('profile');
    }
}
