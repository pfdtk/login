<?php

namespace app\modules\user\controllers;

use app\authorize\filters\db\BearerAuth;
use app\models\User;
use app\traits\JsonResponseTrait;
use yii\base\Module;
use yii\filters\auth\CompositeAuth;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Class IndexController
 * @author jiang
 * @package app\modules\user\controllers
 */
class IndexController extends Controller
{
    use JsonResponseTrait;

    /**
     * IndexController constructor.
     * @param $id
     * @param Module $module
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                    BearerAuth::className(),
                ]
            ]
        ]);
    }

    /**
     * @return string
     */
    public function actionInfo()
    {
        /** @var User $user */
        $user = \Yii::$app->user->getIdentity();
        return $this->responseJson([
            'userid' => $user->getId(),
            'username' => $user->getUsername(),
        ]);
    }

}