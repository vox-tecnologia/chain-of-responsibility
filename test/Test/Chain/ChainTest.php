<?php

namespace Test\Chain;

use Chain\ChainManager;
use Chain\Context\Context;
use Chain\Context\ContextInterface;
use Chain\Handler\ChainHandlerInterface;
use PHPUnit\Framework\TestCase;

class ChainTest extends TestCase
{

    /**
     *
     */
    public function testNoHandlers()
    {
        $context = new Context();
        $context->set('elements', new \ArrayObject());

        $manager = new ChainManager();
        $manager->addHandler($this->createClass(false));
        $manager->addHandler($this->createClass(false));
        $manager->run($context);
        $this->assertCount(0, $context->get('elements'));
    }

    /**
     *
     */
    public function testDinamicHandlers()
    {
        $context = new Context();
        $context->set('elements', new \ArrayObject());
        $manager = new ChainManager();
        $manager->addHandler($this->createClass(false));
        $manager->addHandler($this->createClass(true));
        $manager->run($context);
        $this->assertCount(1, $context->get('elements'));
    }

    /**
     *
     */
    public function testDinamicSecoundLevelChainHandlers()
    {
        $context = new Context();
        $context->set('elements', new \ArrayObject());
        $manager = new ChainManager();

        $manager->addHandler($this->createClass(false));
        $manager->addHandler($this->createClass(false));
        $manager->addHandler($this->createClass(false));

        $manager
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
        ;
        $manager->run($context);
        $this->assertCount(2, $context->get('elements'));
    }

    /**
     *
     */
    public function testDinamicThirdLevelChainHandlers()
    {
        $context = new Context();
        $context->set('elements', new \ArrayObject());
        $manager = new ChainManager();
        $manager->addHandler($this->createClass(false));
        $manager->addHandler($this->createClass(false));
        $manager->addHandler($this->createClass(false));
        $manager->addHandler($this->createClass(false, $this->createClass(true)));

        $manager
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true));

        $manager->run($context);
        $this->assertCount(3, $context->get('elements'));
    }

    /**
     *
     */
    public function testDinamicMonsterLevelChainHandlers()
    {
        $context = new Context();
        $context->set('elements', new \ArrayObject());
        $manager = new ChainManager();
        $manager->addHandler($this->createClass(false));
        $manager->addHandler($this->createClass(false));
        $manager->addHandler($this->createClass(false));

        $manager
            ->addHandler($this->createClass(false))
            ->addHandler($this->createClass(true));

        $manager
            ->addHandler($this->createClass(false))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true));

        $manager
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
        ;

        $manager->run($context);
        $this->assertCount(20, $context->get('elements'));
    }


    /**
     *
     */
    public function testDinamicMonsterLevelWithCanNotInvokeChainHandlers()
    {
        $context = new Context();
        $context->set('elements', new \ArrayObject());
        $manager = new ChainManager();
        $manager->addHandler($this->createClass(false));
        $manager->addHandler($this->createClass(false));
        $manager->addHandler($this->createClass(false));

        $manager
            ->addHandler($this->createClass(false))
            ->addHandler($this->createClass(true));

        $manager
            ->addHandler($this->createClass(false))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true));

        $manager
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(false))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
            ->addHandler($this->createClass(true))
        ;

        $manager->run($context);
        $this->assertCount(3, $context->get('elements'));
    }

    /**
     * @param bool                       $canInvoke
     * @param ChainHandlerInterface|null $next
     *
     * @return ChainHandlerInterface|__anonymous@453
     */
    public function createClass(bool $canInvoke, ChainHandlerInterface $handler = null)
    {
        return new class($canInvoke, $handler) implements ChainHandlerInterface
        {

            private $canInvoke;

            private $next;

            public function __construct(bool $canInvoke, ChainHandlerInterface $next = null)
            {
                $this->canInvoke = $canInvoke;
                $this->next = $next;
            }

            /**
             * @param ContextInterface $context
             *
             * @return bool
             */
            public function canInvoke(ContextInterface $context): bool
            {
                return $this->canInvoke;
            }

            /**
             * @param ContextInterface $context
             *
             * @return mixed
             */
            public function __invoke(ContextInterface $context)
            {
                /** @var $elements \ArrayObject */
                $elements = $context->get('elements');
                $elements->offsetSet(random_int(1, 9999999), __CLASS__);
            }

            /**
             * @param ChainHandlerInterface $handler
             *
             * @return ChainHandlerInterface
             */
            public function addHandler(ChainHandlerInterface $handler): ChainHandlerInterface
            {
                $this->next = $handler;

                return $handler;
            }

            /**
             * @return ChainHandlerInterface|null
             */
            public function next()
            {
                return $this->next;
            }
        };
    }

}