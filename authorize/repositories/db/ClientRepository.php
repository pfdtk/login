<?php


namespace app\authorize\repositories\db;

use Yii;
use app\authorize\entities\ClientEntity;
use app\authorize\repositories\db\models\ClientModel;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getClientEntity(
        $clientIdentifier,
        $grantType,
        $clientSecret = null,
        $mustValidateSecret = true
    )
    {
        Yii::trace([$clientIdentifier, $grantType, $clientSecret, $mustValidateSecret]);
        
        $query = ClientModel::findByClientId($clientIdentifier);
        ClientModel::findByGrantType($grantType, $query);

        if ($mustValidateSecret) {
            if (!$clientSecret) return null;
            ClientModel::findBySecret($clientSecret, $query);
        }

        /** @var ClientModel $client */
        if (!$client = $query->one()) {
            return null;
        }

        $clientEntity = new ClientEntity();
        $clientEntity->setIdentifier($client->id);
        $clientEntity->setName($client->name);
        $clientEntity->setRedirectUri($client->redirect_uri);

        return $clientEntity;
    }

}