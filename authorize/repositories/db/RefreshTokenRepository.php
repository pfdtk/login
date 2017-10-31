<?php


namespace app\authorize\repositories\db;

use app\authorize\entities\RefreshTokenEntity;
use app\authorize\repositories\db\models\RefreshTokensModel;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntityInterface)
    {
        $refreshTokenModel = new RefreshTokensModel();
        $refreshTokenModel->code = $refreshTokenEntityInterface->getIdentifier();
        $refreshTokenModel->access_token_id = $refreshTokenEntityInterface->getAccessToken()->getIdentifier();
        $refreshTokenModel->expire_time = $refreshTokenEntityInterface->getExpiryDateTime()->getTimestamp();
        $refreshTokenModel->save();
    }

    /**
     * @inheritdoc
     */
    public function revokeRefreshToken($tokenId)
    {
        /** @var \yii\db\ActiveRecord $obj */
        $obj = RefreshTokensModel::findOne(['id' => $tokenId]);
        if ($obj) $obj->delete();
    }

    /**
     * @inheritdoc
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        return !RefreshTokensModel::findOne(['id' => $tokenId]) ? true : false;
    }
    
    /**
     * @inheritdoc
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }

}