<?php

namespace app\authorize\responses;

use League\OAuth2\Server\Exception\OAuthServerException;
use yii\web\Response;

/**
 * Created by PhpStorm.
 * User: jiang
 * Date: 2017/12/31
 * Time: 11:26
 */
class ErrorResponse
{
    /**
     * @var string
     */
    private $error;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $hint = 'Exception';

    /**
     * @var int
     */
    private $statusCode = 500;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var bool
     */
    private $hasPrepareResponse = false;

    /**
     * ErrorResponse constructor.
     * @param string $error
     * @param string $message
     * @param string $hint
     */
    public function __construct($error = null, $message = null, $hint = null)
    {
        if ($error instanceof \Exception) {
            $this->exception($error);
        } elseif ($error && $message && $hint) {
            $this->error = $error;
            $this->message = $message;
            $this->hint = $hint;
        }
    }

    /**
     * @param \Exception $exception
     * @return $this
     */
    public function exception(\Exception $exception)
    {
        if ($exception instanceof OAuthServerException) {
            $this->statusCode = $exception->getHttpStatusCode();
            $this->headers = $exception->getHttpHeaders();
            $this->error = $exception->getErrorType();
            $this->message = $exception->getMessage();
            $this->hint = $exception->getHint();
        } else {
            $this->error = 'Unknown error.';
            $this->message = 'Unknown server error.';
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function response()
    {
        if (!$this->hasPrepareResponse) {
            \Yii::$app->response->statusCode = $this->statusCode;
            foreach ($this->headers as $header => $content) {
                \Yii::$app->response->headers->set($header, $content);
            }
            $this->hasPrepareResponse = true;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function toJson()
    {
        $this->response();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ['error' => $this->error, 'message' => $this->message, 'hint' => $this->hint];
    }

}