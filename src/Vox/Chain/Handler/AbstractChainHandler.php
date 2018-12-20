<?php

namespace Vox\Chain\Handler;


abstract class AbstractChainHandler implements ChainHandlerInterface
{

    private $nextHandler;

    /**
     * @return ChainHandlerInterface|null
     */
    public function next()
    {
        return $this->nextHandler;
    }

    /**
     * @param ChainHandlerInterface $handler
     *
     * @return ChainHandlerInterface
     */
    public function addHandler(ChainHandlerInterface $handler): ChainHandlerInterface
    {
        $this->nextHandler = $handler;

        return $this;
    }
}