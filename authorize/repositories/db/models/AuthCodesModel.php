<?php


namespace app\authorize\repositories\db\models;

use yii\db\ActiveRecord;

/**
 * @property string code
 * @property int expire_time
 * @property int user_id
 * @property int client_id
 */
class AuthCodesModel extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%oauth_auth_codes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'user_id', 'client_id', 'expire_time'], 'required'],
            [['user_id', 'client_id', 'expire_time'], 'integer'],
            [['code'], 'string', 'max' => 255],
        ];
    }

}