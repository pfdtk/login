<?php

namespace app\modules\authorize\controllers;

use League\OAuth2\Server\Exception\OAuthServerException;
use Yii;
use app\modules\authorize\services\Oauth2;
use app\traits\JsonResponseTrait;
use app\modules\authorize\services\Login;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class IndexController
 * @author jiang
 * @package app\modules\authorize\controllers
 */
class IndexController extends Controller
{
    use JsonResponseTrait;

    /**
     * @var Login
     */
    private $login;

    /**
     * @var Oauth2
     */
    private $oauth2;

    /**
     * IndexController constructor.
     * @param string $id
     * @param Module $module
     * @param array $config
     * @param Login $login
     * @param Oauth2 $oauth2
     */
    public function __construct(
        $id,
        Module $module,
        array $config = [],
        Login $login,
        Oauth2 $oauth2
    )
    {
        parent::__construct($id, $module, $config);
        $this->login = $login;
        $this->oauth2 = $oauth2;
    }

    /**
     * request example:
     * /authorize
     * ?state=OwZAJYc5p%2BXJJCG4ImQwZQTWJpUQtC9G
     * &scope=test1
     * &response_type=code
     * &approval_prompt=auto
     * &client_id=client1
     * &redirect_uri=http%3A%2F%2Ftest.jhj.com%2Flogin%2Fdefault%2Foauth2
     * @return string
     * @throws OAuthServerException
     */
    public function actionIndex()
    {
        $authRequest = $this->oauth2->validateAuthorizationRequest();

        $gets = Yii::$app->request->get();

        if (Yii::$app->user->identity) {
            return $this->render('info', array_merge($gets, [
                'clientName' => $authRequest->getClient()->getName(),
                'scopes' => $authRequest->getScopes(),
            ]));
        }

        return $this->render('index', $gets);
    }

    /**
     * @return array
     * @throws OAuthServerException
     */
    public function actionLogin()
    {
        $authRequest = $this->oauth2->validateAuthorizationRequest(Yii::$app->request->post());

        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        if (!$identity = $this->login->getUserIdentity($username, $password)) {
            return $this->responseErrorJson('Invalid credential.');
        }

        if (Yii::$app->user->login($identity)) {
            return $this->responseSuccessJson([
                'client_name' => $authRequest->getClient()->getName(),
                'scopes' => $authRequest->getScopes(),
            ]);
        }

        return $this->responseErrorJson('System error.');
    }

    /**
     * @return array
     * @throws OAuthServerException
     */
    public function actionConfirm()
    {
        if (!Yii::$app->user->identity) {
            return $this->responseErrorJson('Invalid credential.');
        }

        $authRequest = $this->oauth2->validateAuthorizationRequest(Yii::$app->request->post());

        return $this->responseSuccessJson([
            'redirect' => $this->oauth2->approved($authRequest)->getRedirectUri()
        ]);
    }

}