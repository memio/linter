<?php

/*
 * This file is part of the memio/linter package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Memio\Linter;

use Memio\Model\Contract;
use Memio\Model\Method;
use Memio\Validator\Constraint;
use Memio\Validator\Violation\NoneViolation;
use Memio\Validator\Violation\SomeViolation;
use PhpSpec\ObjectBehavior;

class ContractMethodsCanOnlyBePublicSpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_is_fine_with_public_methods(
        Contract $contract,
        Method $method
    ) {
        $contract->getName()->willReturn('HttpKernelInterface');
        $contract->allMethods()->willReturn([$method]);
        $method->getVisibility()->willReturn('public');

        $this->validate($contract)->shouldHaveType(NoneViolation::class);
    }

    function it_is_fine_with_no_visibility_methods(
        Contract $contract,
        Method $method
    ) {
        $contract->getName()->willReturn('HttpKernelInterface');
        $contract->allMethods()->willReturn([$method]);
        $method->getVisibility()->willReturn('');

        $this->validate($contract)->shouldHaveType(NoneViolation::class);
    }

    function it_is_not_fine_with_private_methods(
        Contract $contract,
        Method $method
    ) {
        $contract->getName()->willReturn('HttpKernelInterface');
        $contract->allMethods()->willReturn([$method]);
        $method->getVisibility()->willReturn('private');
        $method->getName()->willReturn('handle');

        $this->validate($contract)->shouldHaveType(SomeViolation::class);
    }

    function it_is_not_fine_with_protected_methods(
        Contract $contract,
        Method $method
    ) {
        $contract->getName()->willReturn('HttpKernelInterface');
        $contract->allMethods()->willReturn([$method]);
        $method->getVisibility()->willReturn('protected');
        $method->getName()->willReturn('handle');

        $this->validate($contract)->shouldHaveType(SomeViolation::class);
    }
}
