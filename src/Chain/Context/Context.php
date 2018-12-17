<?php
namespace Chain\Context;

class Context implements ContextInterface
{
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
     *
     * @return ContextInterface
     */
    public function set(string $name, $value): ContextInterface
    {
        $this->bagContext->offsetSet($name, $value);

        return $this;
    }
}