<?php


namespace app\authorize\repositories\db\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ClientScopesModel extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%oauth_client_scopes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'scope_id'], 'required'],
            [['client_id', 'scope_id'], 'integer'],
        ];
    }

    /**
     * @param $clientId
     * @param ActiveQuery|null $query
     * @return ActiveQuery
     */
    public static function findByClientId($clientId, ActiveQuery $query = null)
    {
        $query = $query ?: static::find();
        return $query->andWhere(['client_id' => $clientId]);
    }

}