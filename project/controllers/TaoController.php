<?php


namespace project\controllers;

//use frontend\models\ProjectSignupForm;
use frontend\models\TaoUser;
use project\models\ProjectSignupForm;
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


    private function createNewTaoUser($newUser)
    {
        $getUrl = 'https://cat.ppsdm.com/taoTestTaker/api/testTakers?' . 'login='.$newUser->username.'&password='.$newUser->password.'&userLanguage=English';
        $cURLConnection = curl_init($getUrl);
        curl_setopt($cURLConnection, CURLOPT_POST, 1);
        curl_setopt($cURLConnection, CURLOPT_USERPWD, Yii::$app->params['api_username'] . ":" . Yii::$app->params['api_password']);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
//

        $headers = [
            'Accept: application/json'
        ];

        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $headers);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $taoUser = json_decode($apiResponse);
        if ($taoUser->success) {

                $exist = TaoUser::find()->andWhere(['user_uri' => $taoUser->uri])->One();
                if (!is_null($exist)) {
                    $exist->save();
                    Yii::$app->session->setFlash('success', $taoUser->uri . 'exist');
                } else {
                    $newUser->user_uri = $taoUser->uri;
                    if($newUser->save()) {
                        Yii::$app->session->setFlash('success', $taoUser->uri . 'new');
                    } else {
                        Yii::$app->session->setFlash('success', $taoUser->uri . json_encode($newUser->errors));
                    }

                }
//                $result = Yii::$app->mailer->compose()
//                    ->setFrom('renowijoyo@gmail.com')
//                    ->setTo($newUser->username)
//                    ->setSubject('New Registrtaion')
//                    ->setTextBody('Plain text content')
//                    ->setHtmlBody('<b>Anda telah teregistrasi</b>')
//                    ->send();

        } else {
            Yii::$app->session->setFlash('warning', $taoUser->errorMsg);
        }

        return $taoUser;
//        if ($usermodel = $model->signup()) {
//            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
////            return $this->goHome();
//        } else {
//            Yii::$app->session->setFlash('danger', $model->errors['email'][0]);
//
//        }
    }

    public function createNewUser($newUser)
    {
        $model = new ProjectSignupForm();
        $model->username = $newUser->username;
        $model->email = $newUser->username;
        $model->password = $newUser->password;
        $model->project_id = '1'; #untuk project kemeninfo

        if ($usermodel = $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
//            return $this->goHome();
        } else {
            Yii::$app->session->setFlash('danger', $model->errors['email'][0]);

        }

        return $usermodel;

    }

    public function actionRegister()
    {
        $newUser = new TaoUser();

        if ($newUser->load(Yii::$app->request->post())
        ) {

            $user = $this->createNewUser($newUser);
            $taoUser = $this->createNewTaoUser($newUser);

            if ($user && $taoUser->success)
            {
                Yii::$app->session->setFlash('success', 'BOOOOOOOOOOOOYEAH');
            }
//


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
