<?php

namespace app\modules\authorize\controllers;

use app\authorize\responses\ErrorResponse;
use app\authorize\tokens\AccessToken;
use app\modules\authorize\services\Oauth2;
use app\traits\JsonResponseTrait;
use League\OAuth2\Server\Exception\OAuthServerException;
use GuzzleHttp\Psr7\Response as PsrResponse;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class TokenController
 * @author jiang
 * @package app\modules\authorize\controllers
 */
class TokenController extends Controller
{
    use JsonResponseTrait;

    /**
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * @var Oauth2
     */
    private $oauth2;

    /**
     * @var AccessToken
     */
    private $accessToken;

    /**
     * @var PsrResponse
     */
    private $response;

    /**
     * TokenController constructor.
     * @param $id
     * @param Module $module
     * @param array $config
     * @param Oauth2 $oauth2
     * @param AccessToken $accessToken
     */
    public function __construct(
        $id,
        Module $module,
        array $config = [],
        Oauth2 $oauth2,
        AccessToken $accessToken
    )
    {
        parent::__construct($id, $module, $config);
        $this->oauth2 = $oauth2;
        $this->accessToken = $accessToken;
        $this->response = new PsrResponse();
    }

    /**
     * @return mixed
     */
    public function actionAccesstoken()
    {
        try {
            return $this->responseJson($this->accessToken->content());
        } catch (OAuthServerException $exception) {
            \Yii::error($exception);
            $e = $exception;
        } catch (\Exception $exception) {
            \Yii::error($exception);
            $e = $exception;
        }
        return (new ErrorResponse($e))->toJson();
    }

}