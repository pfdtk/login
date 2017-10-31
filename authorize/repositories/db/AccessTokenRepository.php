<?php


namespace app\authorize\repositories\db;

use app\authorize\repositories\db\models\AccessTokensModel;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use app\authorize\entities\AccessTokenEntity;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        return new AccessTokenEntity();
    }

    /**
     * @inheritdoc
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $accessTokenModel = new AccessTokensModel();
        $accessTokenModel->access_token_id = $accessTokenEntity->getIdentifier();
        $accessTokenModel->expire_time = $accessTokenEntity->getExpiryDateTime()->getTimestamp();
        $accessTokenModel->user_id = $accessTokenEntity->getUserIdentifier();
        $accessTokenModel->client_id = $accessTokenEntity->getClient()->getIdentifier();
        if (!$accessTokenModel->save()) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }
    }

    /**
     * @inheritdoc
     */
    public function revokeAccessToken($tokenId)
    {
        /** @var \yii\db\ActiveRecord $obj */
        $obj = AccessTokensModel::findOne(['access_token_id' => $tokenId]);
        if ($obj) $obj->delete();
    }

    /**
     * @inheritdoc
     */
    public function isAccessTokenRevoked($tokenId)
    {
        return !AccessTokensModel::findOne(['access_token_id' => $tokenId]) ? true : false;
    }
}