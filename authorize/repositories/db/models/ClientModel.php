<?php


namespace app\authorize\repositories\db\models;

use app\traits\TimeBehaviorsTrait;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @property int id
 * @property string name
 * @property string redirect_uri
 * @property string client_id
 */
class ClientModel extends ActiveRecord
{
    use TimeBehaviorsTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth_clients}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'secret', 'name', 'redirect_uri'], 'required'],
            [['client_id', 'secret'], 'string', 'max' => 40],
            [['name'], 'string', 'max' => 255],
            [['redirect_uri'], 'string', 'max' => 512],
        ];
    }

    /**
     * @param $id
     * @param ActiveQuery|null $query
     * @return ActiveQuery
     */
    public static function findById($id, ActiveQuery $query = null)
    {
        $query = $query ?: static::find();
        return $query->andWhere(['id' => $id]);
    }

    /**
     * @param $clientIdentifier
     * @param ActiveQuery|null $query
     * @return ActiveQuery
     */
    public static function findByClientId($clientIdentifier, ActiveQuery $query = null)
    {
        $query = $query ?: static::find();
        return $query->andWhere(['client_id' => $clientIdentifier]);
    }

    /**
     * @param $clientSecret
     * @param ActiveQuery|null $query
     * @return ActiveQuery
     */
    public static function findBySecret($clientSecret, ActiveQuery $query = null)
    {
        $query = $query ?: static::find();
        return $query->andWhere(['secret' => $clientSecret]);
    }

    /**
     * @param $grantType
     * @param ActiveQuery|null $query
     * @return ActiveQuery
     */
    public static function findByGrantType($grantType, ActiveQuery $query = null)
    {
        $query = $query ?: static::find();
        return $query->andWhere(['id' => ClientGrantsModel::findByGrantType($grantType)->select(['client_id'])]);
    }

}