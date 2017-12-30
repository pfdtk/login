<?php

namespace app\authorize\tokens;

use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Response as PsrResponse;
use League\OAuth2\Server\AuthorizationServer;

/**
 * Created by PhpStorm.
 * User: jiang
 * Date: 2017/12/30
 * Time: 10:29
 */
class AccessToken
{
    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    private $request;

    /**
     * @var PsrResponse
     */
    private $response;

    /**
     * @var AuthorizationServer
     */
    private $server;

    /**
     * AccessToken constructor.
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct()
    {
        $this->request = ServerRequest::fromGlobals();
        $this->response = new PsrResponse();
        $this->server = \Yii::$app->get('oauth2_server')->handle();
    }

    /**
     * @return array
     * @throws \League\OAuth2\Server\Exception\OAuthServerException
     */
    public function content()
    {
        $tokenResponse = $this->server->respondToAccessTokenRequest($this->request, $this->response);
        return json_decode((string)$tokenResponse->getBody(), true);
    }

}