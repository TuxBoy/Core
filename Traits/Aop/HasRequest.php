<?php

namespace TuxBoy\Traits\Aop;

use Go\Aop\Intercept\MethodInvocation;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Trait HasRequest
 * @package TuxBoy\Trait
 */
trait HasRequest
{

    /**
     * @var ServerRequestInterface
     */
    public $request;

    /**
     * @param MethodInvocation $invocation
     * @return mixed|ServerRequestInterface
     */
    public function getRequest(MethodInvocation $invocation): ServerRequestInterface
    {
        if (is_null($this->request)) {
            $this->request = current(array_filter($invocation->getArguments(), function ($argument) {
                return $argument instanceof ServerRequestInterface;
            }));
        }
        return $this->request;
    }

}