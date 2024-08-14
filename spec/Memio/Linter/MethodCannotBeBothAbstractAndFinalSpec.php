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

class MethodCannotBeBothAbstractAndFinalSpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_accepts_non_final_concrete_method()
    {
        $method = new Method('render');

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_final_concrete_method()
    {
        $method = (new Method('render'))
            ->makeFinal()
        ;

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_non_final_abstract_method_()
    {
        $method = (new Method('render'))
            ->makeAbstract()
        ;

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_rejects_final_abstract_method()
    {
        $method = (new Method('render'))
            ->makeAbstract()
            ->makeFinal()
        ;

        $this->validate($method)->shouldHaveType(SomeViolation::class);
    }
}
