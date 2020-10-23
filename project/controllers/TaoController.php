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




    public function actionRegister()
    {


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
