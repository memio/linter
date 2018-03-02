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

use Memio\Model\Objekt;
use Memio\Model\Method;
use Memio\Validator\Constraint;
use Memio\Validator\Violation\NoneViolation;
use Memio\Validator\Violation\SomeViolation;
use PhpSpec\ObjectBehavior;

class ConcreteObjectMethodsCannotBeAbstractSpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_is_fine_with_concrete_objekt_and_concrete_methods(
        Objekt $objekt,
        Method $method
    ) {
        $objekt->getName()->willReturn('ConcreteClass');
        $objekt->isAbstract()->willReturn(false);
        $objekt->allMethods()->willReturn([$method]);
        $method->isAbstract()->willReturn(false);

        $this->validate($objekt)->shouldHaveType(NoneViolation::class);
    }

    function it_is_fine_with_abstract_objekts(Objekt $objekt)
    {
        $objekt->isAbstract()->willReturn(true);

        $this->validate($objekt)->shouldHaveType(NoneViolation::class);
    }

    function it_is_not_fine_with_concrete_objekt_and_abstract_methods(
        Objekt $objekt,
        Method $method
    ) {
        $objekt->getName()->willReturn('ConcreteClass');
        $objekt->isAbstract()->willReturn(false);
        $objekt->allMethods()->willReturn([$method]);
        $method->isAbstract()->willReturn(true);
        $method->getName()->willReturn('abstractClass');

        $this->validate($objekt)->shouldHaveType(SomeViolation::class);
    }
}
