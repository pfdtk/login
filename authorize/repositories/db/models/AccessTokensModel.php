<?php


namespace app\authorize\repositories\db\models;

use app\traits\TimeBehaviorsTrait;
use yii\db\ActiveRecord;

/**
 * @property int expire_time
 * @property int user_id
 * @property string client_id
 * @property string access_token_id
 */
class AccessTokensModel extends ActiveRecord
{
    use TimeBehaviorsTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth_access_tokens}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['access_token_id', 'expire_time', 'user_id', 'client_id'], 'required'],
            [['expire_time', 'user_id', 'client_id'], 'integer'],
            [['access_token_id'], 'string', 'max' => 255],
        ];
    }

}