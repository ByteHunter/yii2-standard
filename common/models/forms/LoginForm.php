<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\Client;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_client = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
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
            $client = $this->getClient();
            if (!$client || !$client->validatePassword($this->password)) {
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
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }
    
    /**
     * Finds admin by email
     *
     * @return Admin|null
     */
    public function getClient()
    {
        if ($this->_client === false) {
            $this->_client = Client::findOne(['email' => $this->email]);
        }
        return $this->_client;
    }

    /**
     * Finds user
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->getClient() !== null) {
            return $this->getClient()->user;
        }

        return null;
    }
}
