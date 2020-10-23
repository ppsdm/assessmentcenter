<?php
namespace project\controllers;


//use frontend\models\ResendVerificationEmailForm;
use project\models\ProjectUser;
use project\models\TaoUser;
use frontend\models\VerifyEmailForm;
use project\models\ProjectLoginForm;
use project\models\ProjectPasswordResetRequestForm;
use project\models\ProjectResendVerificationEmailForm;
use project\models\ProjectResetPasswordForm;
use project\models\ProjectSignupForm;
use project\models\ProjectUserSearch;



use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class SiteController extends Controller
{

    public $project_id = 1;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {


//        echo 'index';
        if (!Yii::$app->user->isGuest) {
            return $this->render('index');
        } else {
            return $this->render('index');
        }

    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new ProjectLoginForm();
        if ($model->load(Yii::$app->request->post())
            && $model->login()

        ) {

            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {


        Yii::$app->user->logout();
        Yii::$app->session->setFlash('warning', 'You are logged out ');
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {

        $newUser = new TaoUser();

        if ($newUser->load(Yii::$app->request->post())
        ) {
            $taoUser = $this->createNewTaoUser($newUser);

            if ($taoUser->success)
            {
                $changename = $this->changeTaoLabel($newUser ,$taoUser->uri);

            $assigntogroup = $this->assignTaoUserToGroup($taoUser->uri, "https://cat.ppsdm.com/cat.rdf#i160325707133123994");

                $user = $this->createNewUser($newUser);
                //add tao user ID with project user id
                $projectnewuser = ProjectUser::find()->andWhere(['project_id' => $this->project_id])->andWhere(['username' => $newUser->username])->One();
                if ($user) {
                    $newUser->user_id = $projectnewuser->id;
                    $newUser->save();
//                    $taoUser->user_id = $user->id;
                    Yii::$app->session->setFlash('success', $taoUser->uri);
                }

            }
//


            // return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('signup',
            ['model' => $newUser,
            ]);

    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {

        $model = new ProjectPasswordResetRequestForm();
        $model->project_id = $this->project_id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {

            $model = new ProjectResetPasswordForm($token);

        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }


//        echo '<pre/>';
//        print_r($model);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            $uri = TaoUser::find()->andWhere(['user_id' => $model->id])->One();
            $success = $this->changeTaoPassword($uri->user_uri,$model->password);
            if ($success) {
                Yii::$app->session->setFlash('success', 'New password saved.');
            } else {
                Yii::$app->session->setFlash('danger', 'tao password is UNCHANGED.');
            }


            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {

        echo ' no need for verification. all user are verified when signing up';
//        $model = new ProjectResendVerificationEmailForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail()) {
//                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
//                return $this->goHome();
//            }
//            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
//        }
//
//        return $this->render('resendVerificationEmail', [
//            'model' => $model
//        ]);
    }

    public function actionTest()
    {
        echo 'test';
    }

    private function createNewTaoUser($newUser)
    {
        $getUrl = Yii::$app->params['tao_base_url'] . '/taoTestTaker/api/testTakers?'
            . 'login='.$newUser->username
//            . '&label='.$newUser->first_name . ' ' . $newUser->last_name
            . '&firstName='.$newUser->first_name
            . '&lastName='.$newUser->last_name
            .'&password='.$newUser->password
            .'&mail='.$newUser->username
            .'&userLanguage=English';
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
            Yii::$app->session->setFlash('warning', 'tao error : ' . $taoUser->errorMsg);
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

    public function actionAdmin()
    {
        $searchModel = new ProjectUserSearch();
        $params = Yii::$app->request->queryParams;
        $params['ProjectUserSearch']['project_id'] = $this->project_id;
        $dataProvider = $searchModel->search($params);
//       echo 'index';

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function changeTaoPassword($uri, $password)
    {
        $getUrl = Yii::$app->params['tao_base_url'] . '/taoTestTaker/api/testTakers2?'
            . 'password=' . $password;
        $cURLConnection = curl_init($getUrl);
        curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($cURLConnection, CURLOPT_USERPWD, Yii::$app->params['api_username'] . ":" . Yii::$app->params['api_password']);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
//

        $headers = [
            'Accept: application/json',
            'uri: ' . $uri,
        ];

        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $headers);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $taoUser = json_decode($apiResponse);

        if ($taoUser->success) {


        } else {
            Yii::$app->session->setFlash('warning', 'tao ' . $taoUser->errorMsg);
        }

        return $taoUser;

    }


    public function actionGroup()
    {

        $uri = "https://cat.ppsdm.com/cat.rdf#i1603263508805223998";
            $member = "https://cat.ppsdm.com/cat.rdf#i160325707133123994";
        $getUrl = Yii::$app->params['tao_base_url'] . '/taoGroups/rest?' . 'uri=' . $uri . '&member=' . $member;
        $cURLConnection = curl_init($getUrl);
        curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($cURLConnection, CURLOPT_USERPWD, Yii::$app->params['api_username'] . ":" . Yii::$app->params['api_password']);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
//

        $headers = [
            'Accept: application/json'
//            'uri: ' . $uri,
        ];

        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $headers);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $taoUser = json_decode($apiResponse);

        if ($taoUser->success) {

            Yii::$app->session->setFlash('success', 'tao success ' . $taoUser->errorMsg);
        } else {
//            Yii::$app->session->setFlash('warning', 'tao add group error ' . $taoUser->errorMsg);
        }
echo '<pre/>';
        print_r($getUrl);
//        return $taoUser;
    }



    public function assignTaoUserToGroup($uri, $member)
    {

        $getUrl = Yii::$app->params['tao_base_url'] . '/taoGroups/rest?' . 'uri=' . $uri . '&member=' . $member;
        $cURLConnection = curl_init($getUrl);
        curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($cURLConnection, CURLOPT_USERPWD, Yii::$app->params['api_username'] . ":" . Yii::$app->params['api_password']);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
//

        $headers = [
            'Accept: application/json'
//            'uri: ' . $uri,
        ];

        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $headers);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $taoUser = json_decode($apiResponse);

        if ($taoUser->success) {

            Yii::$app->session->setFlash('success', 'tao success ' . $taoUser->errorMsg);
        } else {
            Yii::$app->session->setFlash('warning', 'tao add group error ' . $taoUser->errorMsg);
        }

        return $taoUser;
    }
    public function changeTaoLabel($user, $uri)
    {


        $getUrl = Yii::$app->params['tao_base_url'] . '/taoTestTaker/api/testTakers2?'
            . 'label=' . $user->first_name . '_' . $user->last_name;
        $cURLConnection = curl_init($getUrl);
        curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($cURLConnection, CURLOPT_USERPWD, Yii::$app->params['api_username'] . ":" . Yii::$app->params['api_password']);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
//

        $headers = [
            'Accept: application/json',
            'uri: ' . $uri,
        ];

        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $headers);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $taoUser = json_decode($apiResponse);

        if ($taoUser->success) {


        } else {
            Yii::$app->session->setFlash('warning', 'tao ' . $taoUser->errorMsg);
        }

        return $taoUser;

    }
}
