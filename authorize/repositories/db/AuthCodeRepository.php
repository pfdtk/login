<?php


namespace app\authorize\repositories\db;

use app\authorize\entities\AuthCodeEntity;
use app\authorize\repositories\db\models\AuthCodesModel;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getNewAuthCode()
    {
        return new AuthCodeEntity();
    }

    /**
     * @inheritdoc
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        $authCodeModel = new AuthCodesModel();
        $authCodeModel->code = $authCodeEntity->getIdentifier();
        $authCodeModel->expire_time = $authCodeEntity->getExpiryDateTime()->getTimestamp();
        $authCodeModel->user_id = (string)$authCodeEntity->getUserIdentifier();
        $authCodeModel->client_id = $authCodeEntity->getClient()->getIdentifier();
        if (!$authCodeModel->save()) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }
    }

    /**
     * @inheritdoc
     */
    public function revokeAuthCode($codeId)
    {
        /** @var \yii\db\ActiveRecord $obj */
        $obj = AuthCodesModel::findOne(['id' => $codeId]);
        if ($obj) $obj->delete();
    }

    /**
     * @inheritdoc
     */
    public function isAuthCodeRevoked($codeId)
    {
        return !AuthCodesModel::findOne(['code' => $codeId]) ? true : false;
    }
}