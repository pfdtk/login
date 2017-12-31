<?php

namespace app\modules\authorize\services;

use app\authorize\entities\UserEntity;
use Yii;
use League\OAuth2\Server\AuthorizationServer;
use app\authorize\requests\ServerRequest;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use League\OAuth2\Server\Exception\OAuthServerException;
use GuzzleHttp\Psr7\Response as PsrResponse;
use yii\base\InvalidConfigException;

/**
 * Class Oauth2
 * @author jiang
 * @package app\modules\authorize\services
 */
class Oauth2
{
    /**
     * @var AuthorizationServer
     */
    private $server;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * Oauth2 constructor.
     * @throws InvalidConfigException
     */
    public function __construct()
    {
        $this->server = Yii::$app->get('oauth2_server')->handle();
    }

    /**
     * @param array $query
     * @return AuthorizationRequest
     * @throws OAuthServerException
     */
    public function validateAuthorizationRequest($query = [])
    {
        $request = ServerRequest::fromGlobals();
        if ($query) {
            $request = $request->withQueryParams($query);
        }
        $authRequest = $this->server->validateAuthorizationRequest($request);
        return $authRequest;
    }

    /**
     * @param AuthorizationRequest $authRequest
     * @return $this
     */
    public function approved(AuthorizationRequest $authRequest)
    {
        $user = Yii::$app->user->identity;
        $userEntity = new UserEntity();
        $userEntity->setIdentifier($user->getId());
        $authRequest->setUser($userEntity);
        $authRequest->setAuthorizationApproved(true);

        $this->redirectUri = $this->server
            ->completeAuthorizationRequest($authRequest, new PsrResponse())
            ->getHeader('Location')[0];

        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

}