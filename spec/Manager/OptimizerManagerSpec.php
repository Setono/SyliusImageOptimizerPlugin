<?php

namespace spec\Loevgaard\SyliusOptimizeImagesPlugin\Manager;

use Loevgaard\SyliusOptimizeImagesPlugin\Manager\OptimizerManager;
use Loevgaard\SyliusOptimizeImagesPlugin\Manager\OptimizerManagerInterface;
use Loevgaard\SyliusOptimizeImagesPlugin\Optimizer\OptimizerInterface;
use PhpSpec\ObjectBehavior;

class OptimizerManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OptimizerManager::class);
    }

    function it_inherits_interface()
    {
        $this->shouldBeAnInstanceOf(OptimizerManagerInterface::class);
    }

    function it_returns_all_optimizers(OptimizerInterface $optimizer1, OptimizerInterface $optimizer2)
    {
        $this->beConstructedWith($optimizer1, $optimizer2);
        $this->all()->shouldReturn([$optimizer1, $optimizer2]);
    }

    function it_returns_optimizer_by_code(OptimizerInterface $optimizer1, OptimizerInterface $optimizer2)
    {
        $optimizer1->getCode()->willReturn('code');
        $this->beConstructedWith($optimizer1, $optimizer2);

        $this->findByCode('code')->shouldReturn($optimizer1);
    }
}
