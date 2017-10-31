<?php


namespace app\authorize\repositories\db\models;

use app\traits\TimeBehaviorsTrait;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class GrantsModel extends ActiveRecord
{
    use TimeBehaviorsTrait;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%oauth_grants}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 40],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getClientGrants()
    {
        return $this->hasMany(ClientGrantsModel::className(), ['grant_id' => 'id']);
    }

    /**
     * @param $id
     * @param ActiveQuery|null $query
     * @return ActiveQuery
     */
    public static function findByGrantId($id, ActiveQuery $query = null)
    {
        $query = $query ?: static::find();
        return $query->andWhere(['id' => $id]);
    }

    /**
     * @param $gantType
     * @param ActiveQuery|null $query
     * @return ActiveQuery
     */
    public static function findByGrantType($gantType, ActiveQuery $query = null)
    {
        $query = $query ?: static::find();
        return $query->andWhere(['name' => $gantType]);
    }

}