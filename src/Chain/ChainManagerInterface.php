<?php
namespace Chain;

use Chain\Context\ContextInterface;
use Chain\Handler\ChainHandlerInterface;

interface ChainManagerInterface
{
    /**
     * @param ChainHandlerInterface $handler
     *
     * @return ChainHandlerInterface
     */
    public function addHandler(ChainHandlerInterface $handler): ChainHandlerInterface;

    /**
     * @param ContextInterface $context
     *
     * @return mixed
     */
    public function run(ContextInterface $context, ChainHandlerInterface $handler = null);
}
