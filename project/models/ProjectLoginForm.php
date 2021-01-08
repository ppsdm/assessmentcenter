<?php
namespace project\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ProjectLoginForm extends Model
{
    public $username;
    public $password;
//    public $project_id;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            Yii::$app->session->setFlash('success', 'SUCCESS LOGGING IN');
//            print_r($this->getUser());

            $user = $this->getUser();
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
//             return $user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
//             print_r($result);

        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = ProjectUser::findByUsername($this->username, 2);
        }

        return $this->_user;
    }
}
