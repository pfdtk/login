<?php

namespace app\authorize\filters\db;

use app\authorize\repositories\db\AccessTokenRepository;
use app\models\User;
use app\authorize\requests\ServerRequest;
use League\OAuth2\Server\Exception\OAuthServerException;
use yii\filters\auth\AuthMethod;
use League\OAuth2\Server\ResourceServer;
use app\authorize\exceptions\UnauthorizedResourceException;

/**
 * Created by PhpStorm.
 * User: jiang
 * Date: 2017/12/31
 * Time: 10:45
 */
class BearerAuth extends AuthMethod
{
    /**
     * @var string
     */
    const INVALID_ACCESS_TOKEN = 'You are requesting with an invalid credential.';

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $accessTokenRepository = new AccessTokenRepository();
        $publicKeyPath = \Yii::$app->get('oauth2_server')->publicKeyPath;
        $server = new ResourceServer($accessTokenRepository, $publicKeyPath);
        try {
            $auth = $server->validateAuthenticatedRequest(ServerRequest::fromGlobals());
            $userId = $auth->getAttribute('oauth_user_id');
            $identity = User::findIdentity($userId);
            $user->login($identity);
            return $identity;
        } catch (OAuthServerException $exception) {
            \Yii::error($exception);
            throw new UnauthorizedResourceException(static::INVALID_ACCESS_TOKEN, 401, 'invalid_credential', 'Access token');
        } catch (\Exception $exception) {
            \Yii::error($exception);
            throw new UnauthorizedResourceException('Unknown server error', 500, 'unknown_error', 'Unkown server error');
        }
    }

}