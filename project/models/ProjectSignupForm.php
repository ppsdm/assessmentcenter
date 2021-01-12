<?php
namespace project\models;

use Yii;
use yii\base\Model;
use project\models\ProjectUser;

/**
 * Signup form
 */
class ProjectSignupForm extends Model
{
    public $username;
    public $email;
    public $password;
//    public $project_id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
//            ['username', 'unique', 'targetClass' => '\project\models\ProjectUser', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['email','username'], 'unique', 'targetClass' => '\project\models\ProjectUser', 'targetAttribute' => ['email','username'],'message' => 'This email,username has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
//            ['project_id', 'trim'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new ProjectUser();
        $user->username = $this->username;
        $user->email = $this->email;
//        $user->project_id = $this->project_id;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        return $user->save()
            && $this->sendEmail($user)
            ;



    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => ' PPSDM admin'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
