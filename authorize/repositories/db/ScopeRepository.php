<?php


namespace app\authorize\repositories\db;

use Yii;
use app\authorize\entities\ScopeEntity;
use app\authorize\repositories\db\models\ScopesModel;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        Yii::trace($identifier);

        /** @var ScopesModel $scope */
        if (!$scope = ScopesModel::findByScopeName($identifier)->one()) {
            return null;
        }
        $scopeEntity = new ScopeEntity();
        $scopeEntity->setIdentifier($scope->id);
        $scopeEntity->setName($scope->name);
        return $scopeEntity;
    }

    /**
     * @inheritdoc
     */
    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null)
    {
        $scopesId = [];
        /** @var ScopeEntity[] $scopes */
        foreach ($scopes as $scope) {
            $scopesId[] = $scope->getIdentifier();
        }

        $query = ScopesModel::findByScopeId($scopesId);
        ScopesModel::findByClientId($clientEntity->getIdentifier(), $query);

        /** @var ScopesModel[] $result */
        $result = $query->all();

        $entitys = [];
        foreach ($result as $item) {
            foreach ($scopes as $key => $scope) {
                if ($item->id == $scope->getIdentifier()) $entitys[$key] = $scope;
            }
        }

        return $entitys;
    }


}