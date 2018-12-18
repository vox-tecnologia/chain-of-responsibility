<?php
namespace Chain\Context;

use Chain\Exception\StopPropagationException;

class Context implements ContextInterface
{

    /**
     * @var \ArrayObject
     */
    private $bagContext;

    /**
     * Context constructor.
     */
    public function __construct()
    {
        $this->bagContext = new \ArrayObject();
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get(string $name)
    {
        return $this->bagContext->offsetGet($name);
    }

    /**
     * @param string $name
     * @param        $value
     *
     * @return ContextInterface
     */
    public function set(string $name, $value): ContextInterface
    {
        $this->bagContext->offsetSet($name, $value);

        return $this;
    }

    /**
     * @throws StopPropagationException
     */
    public function stopPropagation()
    {
        throw new StopPropagationException();
    }
}
