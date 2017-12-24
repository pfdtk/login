<?php


namespace app\authorize\repositories\db\models;

use yii\db\ActiveRecord;

/**
 * @property string code
 * @property int access_token_id
 * @property int expire_time
 */
class RefreshTokensModel extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%oauth_refresh_tokens}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'access_token_id', 'expire_time'], 'required'],
            [['expire_time', 'access_token_id'], 'integer'],
            [['code'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

}