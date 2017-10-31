<?php

namespace app\modules\authorize\services;

use Yii;
use app\models\User;

/**
 * @author jiang
 */
class Login
{
    /**
     * @param $username
     * @param $password
     * @return User|null
     */
    public function getUserIdentity($username, $password)
    {
        /** @var User $identity */
        if (!$identity = User::findOne(['username' => $username])) {
            return null;
        }
        if (Yii::$app->getSecurity()->validatePassword($password, $identity->password)) {
            return $identity;
        }
        return null;
    }

}