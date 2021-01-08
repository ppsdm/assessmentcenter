<?php
namespace project\models;

use Yii;
use yii\base\Model;
use common\models\User;
use project\models\ProjectUser;

/**
 * Password reset request form
 */
class ProjectPasswordResetRequestForm extends Model
{
    public $email;
//    public $project_id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\project\models\ProjectUser',
                'filter' => ['status' => ProjectUser::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = ProjectUser::findOne([
            'status' => ProjectUser::STATUS_ACTIVE,
//            'project_id' => $this->project_id,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!ProjectUser::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}
