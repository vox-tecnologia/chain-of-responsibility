<?php

namespace Chain\Handler;

use Chain\Context\ContextInterface;

interface ChainHandlerInterface
{

    /**
     * @param ContextInterface $context
     *
     * @return bool
     */
    public function canInvoke(ContextInterface $context): bool;

    /**
     * @param ContextInterface $context
     *
     * @return mixed
     */
    public function __invoke(ContextInterface $context);

    /**
     * @return ChainHandlerInterface|null
     */
    public function next();

    /**
     * @param ChainHandlerInterface $handler
     *
     * @return ChainHandlerInterface
     */
    public function addHandler(ChainHandlerInterface $handler): ChainHandlerInterface;
}