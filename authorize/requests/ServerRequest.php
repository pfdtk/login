<?php

namespace app\authorize\requests;

use GuzzleHttp\Psr7\ServerRequest as BaseServerRequest;

/**
 * Created by PhpStorm.
 * User: jiang
 * Date: 2017/12/31
 * Time: 15:27
 */
class ServerRequest extends BaseServerRequest
{
    /**
     * @inheritdoc
     */
    public static function fromGlobals()
    {
        $request = parent::fromGlobals();
        $headers = \Yii::$app->request->getHeaders();
        foreach ($headers as $header => $value) {
            $request = $request->withHeader($header, $value);
        }
        return $request;
    }
}