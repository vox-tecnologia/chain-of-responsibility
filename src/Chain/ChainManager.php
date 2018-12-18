<?php
namespace Chain;

use Chain\Context\ContextInterface;
use Chain\Exception\ChainExceptionInterface;
use Chain\Handler\ChainHandlerInterface;

class ChainManager implements ChainManagerInterface
{

    /**
     * @var \ArrayObject
     */
    private $bagHandler;

    /**
     * ChainManager constructor.
     *
     * @param ChainHandlerInterface[] ...$handlers
     */
    public function __construct(ChainHandlerInterface ...$handlers)
    {
        $this->bagHandler = new \ArrayObject($handlers);
    }

    /**
     * @param ChainHandlerInterface $handler
     *
     * @return ChainHandlerInterface
     */
    public function addHandler(ChainHandlerInterface $handler): ChainHandlerInterface
    {
        $this->bagHandler->append($handler);

        return $handler;
    }

    /**
     * @param ContextInterface           $context
     * @param ChainHandlerInterface|null $handler
     */
    public function run(ContextInterface $context, ChainHandlerInterface $handler = null)
    {
        try {
            if (!$handler) {
                $handler = $this->firstRunner($context);
            }

            if (!empty($handler) && $handler->canInvoke($context)) {
                $handler($context);
                $next = $handler->next();
                if ($next) {
                    $this->run($context, $next);
                }
            }
        } catch (ChainExceptionInterface $exception) {
            // Stop runner
        }
    }

    /**
     * @param ContextInterface $context
     *
     * @return mixed
     */
    private function firstRunner(ContextInterface $context)
    {
        foreach ($this->bagHandler as $handler) {
            if ($handler->canInvoke($context)) {
                return $handler;
            };
        }

        return null;
    }

}
