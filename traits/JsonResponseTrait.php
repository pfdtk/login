<?php

namespace app\traits;

use Yii;
use yii\web\Response;

/**
 * Class JsonResponseTrait
 * @author jiang
 * @package app\traits
 */
trait JsonResponseTrait
{
    /**
     * @param mixed $content
     * @return mixed
     */
    public function responseJson($content)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $content;
    }

    /**
     * @param mixed $content
     * @return array
     */
    public function responseSuccessJson($content)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'status' => true,
            'data' => $content,
            'info' => 'success',
        ];
    }

    /**
     * @param string $content
     * @return array
     */
    public function responseErrorJson($content)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'status' => false,
            'data' => [],
            'info' => $content,
        ];
    }

}