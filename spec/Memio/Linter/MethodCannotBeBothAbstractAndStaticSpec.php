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

use Memio\Model\Method;
use Memio\Validator\Constraint;
use Memio\Validator\Violation\NoneViolation;
use Memio\Validator\Violation\SomeViolation;
use PhpSpec\ObjectBehavior;

class MethodCannotBeBothAbstractAndStaticSpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_is_fine_with_non_static_abstract_methods(Method $method)
    {
        $method->isAbstract()->willReturn(true);
        $method->isStatic()->willReturn(false);

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_is_not_fine_with_abstract_and_static_methods(Method $method)
    {
        $method->isAbstract()->willReturn(true);
        $method->isStatic()->willReturn(true);
        $method->getName()->willReturn('__construct');

        $this->validate($method)->shouldHaveType(SomeViolation::class);
    }
}
