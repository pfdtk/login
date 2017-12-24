<?php


namespace app\authorize\repositories\db\models;

use app\traits\TimeBehaviorsTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ClientGrantsModel extends ActiveRecord
{
    use TimeBehaviorsTrait;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%oauth_client_grants}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'grant_id'], 'required'],
            [['client_id', 'grant_id'], 'integer'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(ClientModel::className(), ['id' => 'client_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getGrant()
    {
        return $this->hasOne(GrantsModel::className(), ['id' => 'grant_id']);
    }

    /**
     * @param $grantType
     * @param ActiveQuery|null $query
     * @return ActiveQuery
     */
    public static function findByGrantType($grantType, ActiveQuery $query = null)
    {
        $query = $query ?: static::find();
        return $query->andWhere(['grant_id' => GrantsModel::findByGrantType($grantType)->select(['id'])]);
    }

}