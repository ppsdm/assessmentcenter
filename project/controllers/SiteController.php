<?php
namespace project\controllers;


//use frontend\models\ResendVerificationEmailForm;
use Cassandra\Statement;
use frontend\models\Profile;
use frontend\models\SignupForm;
use project\models\Project;
use project\models\ProjectGroup;
use project\models\ProjectPreassigned;
use project\models\ProjectTaouser;
use project\models\ProjectUser;
use project\models\ProjectUserProfile;
use project\models\ProjectUserProject;
use project\models\TaoStatements;
use project\models\TaoUser;
use project\models\VerifyEmailForm;
use project\models\ProjectLoginForm;
use project\models\ProjectPasswordResetRequestForm;
use project\models\ProjectResendVerificationEmailForm;
use project\models\ProjectResetPasswordForm;
use project\models\ProjectSignupForm;
use project\models\ProjectUserSearch;



use Yii;
use yii\base\InvalidArgumentException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class SiteController extends Controller
{

//    public $project_id = 1;

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

    public function preassignedGroups($username)
    {
        $userT = ProjectUser::find()->andWhere(['username' => $username])->One();
        $projects = ProjectPreassigned::find()->andWhere(['username' => $userT->username])->all();
        foreach($projects as $project) {
            $new = new ProjectUserProject;
            $new->project_id = $project->projectId;
            $new->project_user_id = $userT->id;
            $new->save();
        }

        Yii::$app->session->addFlash('success', $userT->username);

        return;
    }
    public function actionSignup()
    {
        $newUser = new ProjectSignupForm();

        if ($newUser->load(Yii::$app->request->post())
        ) {
//    echo '<pre>';
//            print_r($newUser);
            $user = $this->createNewUser($newUser);


            //add tao user ID with project user id
//            $projectnewuser = ProjectUser::find()
////                    ->andWhere(['project_id' => $this->project_id])
//                ->andWhere(['username' => $newUser->username])->One();
            if ($user) {
                $this->preassignedGroups($newUser->username);
//                $newUser->user_id = $projectnewuser->id;
//                $newUser->save();
//                    $taoUser->user_id = $user->id;
                Yii::$app->session->addFlash('success', 'preassigned groups');
            }
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
//        $model->project_id = $this->project_id;

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
            $uri = ProjectTaouser::find()->andWhere(['project_user_id' => $model->id])->One();
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



    private function createNewTaoUser($newUser)
    {
        $getUrl = Yii::$app->params['tao_base_url'] . '/taoTestTaker/api/testTakers?'
            . 'login='.$newUser->username
            . '&label='.$newUser->username
            //            . '&label='.$newUser->first_name . ' ' . $newUser->last_name
//            . '&firstName='.(property_exists($newUser,'first_name')) ? $newUser->first_name   : ""
//            . '&lastName='.(property_exists($newUser,'last_name')) ? $newUser->first_name   : ""
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

//            $exist = ProjectTaouser::find()->andWhere(['user_uri' => $taoUser->uri])->One();
            $exist = ProjectTaouser::find()->andWhere(['project_user_id' => yii::$app->user->identity->id])->One();
            if (!is_null($exist)) {
                $exist->username = $newUser->username;
                $exist->user_uri = $taoUser->uri;
//                $exist->project_user_id = Yii::$app->user->identity->getId();
                $exist->save();
                Yii::$app->session->addFlash('warning', yii::$app->user->identity->username . ' previously existed');
            } else {
                $exist = new ProjectTaouser();
                $exist->username = $newUser->username;
                $exist->user_uri = $taoUser->uri;
                $exist->project_user_id = Yii::$app->user->identity->getId();
                if($exist->save()) {
                    Yii::$app->session->addFlash('success', $exist->user_uri . 'new');
                } else {
                    Yii::$app->session->addFlash('success', $exist->user_uri . json_encode($newUser->errors));
                }

            }


        } else {
            Yii::$app->session->addFlash('warning', 'tao error : ' . $taoUser->errorMsg);
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
//        $model->project_id = '1'; #untuk project kemeninfo

        if ($usermodel = $model->signup()) {

            $projectuserprofile = new ProjectUserProfile;
            $profile = new Profile;
            $profile->first_name = $newUser->first_name;
            $profile->last_name = $newUser->last_name;
            $profile->full_name = $newUser->first_name . '_' . $newUser->last_name;
            $profile->save();

            $projectuserprofile->projectUserId = $usermodel->id;
            $projectuserprofile->profileId = $profile->id;
            $projectuserprofile->save();



            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
//            return $this->goHome();
        } else {
            Yii::$app->session->setFlash('danger', json_encode($model->errors));

        }

        return $usermodel;

    }

    public function actionAdmin()
    {
        $searchModel = new ProjectUserSearch();
        $params = Yii::$app->request->queryParams;
//        $params['ProjectUserSearch']['project_id'] = $this->project_id;
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
$uri = "";
$member = "";

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


    /***
     * @return \yii\web\Response
     * menggunakan REST, tapi implementasi kurang lengkap.
     * lebih baik langsung ke database saja.
     * kekurangan dengan REST :
     * 1. group tao harus tidak boleh di bawah folder
     * 2. bias duplikat masukkin ke tabel statements saat join group dan ada unnecessary pair data entry antara object-subject dan subject-object
     */
public function joinGroup()
{
    $user = Yii::$app->user;
$projecttaouser = ProjectTaouser::find()->andWhere(['project_user_id' => $user->id])->one();
//echo $projecttaouser->user_uri;



            $projects = ProjectUserProject::find()->andWhere(['project_user_id' => $user->id])->all();
        $ids = ArrayHelper::getColumn($projects, 'project_id');

$groups = ProjectGroup::find()->andWhere(['in', 'project_id',$ids])->All();

foreach ($groups as $group) {
    echo '<br/><br/>';
    echo $group->taoGroup->group_name . ' : ' . $group->taoGroup->group_uri;

         $groupexists = TaoStatements::find()->andWhere(['subject' => $projecttaouser->user_uri])->andWhere(['predicate' => 'http://www.tao.lu/Ontologies/TAOGroup.rdf#member'])
             ->andWhere(['object' => $group->taoGroup->group_uri])->One();
         if (isset($groupexists)) {
             echo 'ALREADY EXISTED';
         } else {
             $response = $this->assignTaoUserToGroup($group->taoGroup->group_uri,$projecttaouser->user_uri);
         }

    if (isset($response->errorMsg))
    {
        echo $response->errorMsg;           //MESTI LIHAT STRING SAAT CALL API NYA
    }

}

//    return $this->redirect(Yii::$app->request->referrer);
    Yii::$app->session->addFlash('success', 'join group success');
return;
}

    public function assignTaoUserToGroup($uri, $member)
    {

        $getUrl = Yii::$app->params['tao_base_url'] . '/taoGroups/Rest?' . 'uri=' . $uri . '&member=' . $member;
        $getUrlHashEncoded = str_replace("#","%23",$getUrl);
        $cURLConnection = curl_init($getUrlHashEncoded);
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
        echo '<br/>' . $getUrl . '<br/>';
        if ($taoUser->success) {

//            Yii::$app->session->setFlash('success', 'tao success ');
        } else {
//            Yii::$app->session->setFlash('warning', 'tao add group error  : ' . $taoUser->errorMsg);
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

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }



    public function actionNamesync()
    {

    }

    public function actionTaosync()
    {

        $model = new ProjectLoginForm();
        if ($model->load(Yii::$app->request->post())

        ) {
            $model->username = Yii::$app->user->identity->username;

                $user = $model->getUser();
                if (!$user->validatePassword($model->password)) {
                    Yii::$app->session->addFlash('error', 'WRONG PASSWORD');
                    return $this->refresh();
//                    echo 'wrong password';
                }  else {
                    Yii::$app->session->addFlash('success', 'Verified');

//                    echo '<pre>';
//                    print_r($model);

                    $projecttaouser = $this->createNewTaoUser($model);
//
                    if ($projecttaouser->success)
                    {
//                        $changename = $this->changeTaoLabel($user,$taoUser->uri);

//                        $assigntogroup = $this->assignTaoUserToGroup( "https://cat.ppsdm.com/cat.rdf#i1603326718823824000",$taoUser->uri);

                            Yii::$app->session->addFlash('success', $projecttaouser ->uri);
                    } else {

                        /*
                        yang harus dilakukan disini :
                        1. get uri from username
                        2. use the uri and password to change password
                        */
//                        $this->changeTaoPassword()
//                        echo '<pre>';
//                        print_r($taoUser);

                        $taoobject = TaoStatements::find()->andWhere(['object' => $model->username])->andWhere(['predicate' => 'http://www.tao.lu/Ontologies/generis.rdf#login'])->One();
                        if (isset($taoobject))
                        {

                            $projecttaouser = ProjectTaouser::find()->andWhere(['project_user_id' => $user->id])->One();
                            if (isset($projecttaouser)) {
                                $projecttaouser->project_user_id = $user->id;
                                $projecttaouser->user_uri = $taoobject->subject;
                                $projecttaouser->username = $model->username;
                                $projecttaouser->status = 'resync';
                            } else {
                                $projecttaouser = new ProjectTaouser;
                                $projecttaouser->project_user_id = $user->id;
                                $projecttaouser->user_uri = $taoobject->subject;
                                $projecttaouser->username = $model->username;
                                $projecttaouser->status = 'resync';
                            }



                            $projecttaouser->save();
//                            Yii::$app->session->addFlash('warning', 'tao user previously existed and re-saved : ' . $taoobject->subject);

                        }
//                        Yii::$app->session->addFlash('danger', 'somthieng wrong ');

                    }

                    //update projecttaouser


                    $this->joinGroup();
                    $profile = ProjectUserProfile::find()->andWhere(['projectUserId' => $user->id])->One();
                    $this->changeTaoLabel($profile->profile, $projecttaouser->user_uri); //first name last name masih belum bener


//                    return $this->redirect(Yii::$app->request->referrer);
                    Yii::$app->session->addFlash('success', '========= ' . $profile->profile->first_name);
                            return $this->refresh();
                }


        } else {
            $model->password = '';


        }

            return $this->render('verifypassword', [
                'model' => $model,
            ]);

//        1. check for tao user with the same email
//        2. create tao user
//        3. create password

    }

    public function actionProfile()
    {
        if (!Yii::$app->user->isGuest) {
                $id = Yii::$app->user->id;



            $UserProfileModel = ProjectUserProfile::find()->andWhere(['projectUserId' => $id])->One();
            $taomodel = ProjectTaouser::find()->andWhere(['project_user_id' => $id])->One();
            if ( isset($UserProfileModel)){
                $model = $UserProfileModel->profile;
            } else {
                $model = new Profile;
                $UserProfileModel = new ProjectUserProfile();
            }


            if ( isset($taomodel)){

            } else {
                $taomodel = new ProjectTaouser;

            }


//            $model = $UserProfileModel->profile;
//            if (null == $UserProfileModel) {
//                $model = new Profile;
//                $model->save();
//                $UserProfileModel = new UserProfile();
//                $UserProfileModel->userId = $id;
//                $UserProfileModel->profileId = $model->id;
//                $UserProfileModel->save();
//            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $UserProfileModel->profileId = $model->id;
                $UserProfileModel->projectUserId = $id;
                $UserProfileModel->save();
                //  return $this->redirect(['view', 'id' => $model->id]);
                Yii::$app->session->setFlash('success', 'Profile is saved');
                return $this->refresh();
            }

            return $this->render('profile', [
                'model' => $model,
                'taomodel' => $taomodel
            ]);
        } else {
            return $this->goHome();
        }
    }

    public function actionProjects()
    {

        $id = Yii::$app->user->id;
//        $model = ProjectUserProject::find()->andWhere(['project_user_id' => $id])->all();

        $dataProvider = new ActiveDataProvider([
            'query' => ProjectUserProject::find()->andWhere(['project_user_id' => $id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('projects', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGroups()
    {
        $id = Yii::$app->user->id;
        $projects = ProjectUserProject::find()->andWhere(['project_user_id' => $id])->all();
        $ids = ArrayHelper::getColumn($projects, 'project_id');


        $taousermodel = ProjectTaouser::find()->andWhere(['project_user_id' => $id])->One();


        $taogroups = TaoStatements::find()->andWhere(['subject' => $taousermodel->user_uri])->andWhere(['predicate' => 'http://www.tao.lu/Ontologies/TAOGroup.rdf#member'])->All();

        $groupuris = ArrayHelper::getColumn($taogroups, 'object');

echo '<pre>';
print_r($taogroups);
//        $dataProvider = new ActiveDataProvider([
//            'query' => ProjectGroup::find()->andWhere(['in', 'project_id',$ids]),
//            'pagination' => [
//                'pageSize' => 20,
//            ],
//        ]);
//
//
//            return $this->render('groups', [
//                'dataProvider' => $dataProvider,
//                'taogroups' => $taogroups
//            ]);
    }

}
