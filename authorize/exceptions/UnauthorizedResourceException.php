<?php

namespace app\authorize\exceptions;

/**
 * Created by PhpStorm.
 * User: jiang
 * Date: 2017/12/31
 * Time: 13:49
 */
class UnauthorizedResourceException extends \Exception
{
    /**
     * @var null|string
     */
    private $hint;

    /**
     * @var string
     */
    private $errorType;

    /**
     * ResourceDenyException constructor.
     * @param string $message
     * @param int $code
     * @param string $errorType
     * @param string $hint
     */
    public function __construct($message = "", $code = 0, $errorType = null, $hint = null)
    {
        parent::__construct($message, $code);
        $this->hint = $hint;
        $this->errorType = $errorType;
    }

    /**
     * @return string
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * @return null|string
     */
    public function getHint()
    {
        return $this->hint;
    }
}