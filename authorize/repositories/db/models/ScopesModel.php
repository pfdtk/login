<?php


namespace app\authorize\repositories\db\models;

use app\traits\TimeBehaviorsTrait;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property string name
 * @property int id
 */
class ScopesModel extends ActiveRecord
{
    use TimeBehaviorsTrait;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%oauth_scopes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param $id
     * @param ActiveQuery|null $query
     * @return ActiveQuery
     */
    public static function findByScopeId($id, ActiveQuery $query = null)
    {
        $query = $query ?: static::find();
        return $query->andWhere(['id' => $id]);
    }

    /**
     * @param $name
     * @param ActiveQuery|null $query
     * @return ActiveQuery
     */
    public static function findByScopeName($name, ActiveQuery $query = null)
    {
        $query = $query ?: static::find();
        return $query->andWhere(['name' => $name]);
    }

    /**
     * @param $clientId
     * @param ActiveQuery|null $query
     * @return ActiveQuery
     */
    public static function findByClientId($clientId, ActiveQuery $query = null)
    {
        $query = $query ?: static::find();
        return $query->andWhere(['id' => ClientScopesModel::findByClientId($clientId)->select(['scope_id'])]);
    }

}