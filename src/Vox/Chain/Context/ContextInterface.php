<?php

namespace Vox\Chain\Context;

use Vox\Chain\Exception\StopPropagationException;

interface ContextInterface
{

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get(string $name);

    /**
     * @param string $name
     * @param        $value
     *
     * @return ContextInterface
     */
    public function set(string $name, $value): ContextInterface;

    /**
     * @throws StopPropagationException
     */
    public function stopPropagation();

}
