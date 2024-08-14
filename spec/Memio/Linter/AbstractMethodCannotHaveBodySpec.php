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

class AbstractMethodCannotHaveBodySpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_accepts_concrete_method_with_body()
    {
        $method = (new Method('render'))
            ->setBody('echo "Nobody expects the spanish inquisition";')
        ;

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_abstract_method_without_body()
    {
        $method = (new Method('render'))
            ->makeAbstract()
        ;

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_rejects_abstract_method_with_body()
    {
        $method = (new Method('render'))
            ->makeAbstract()
            ->setBody('echo "Nobody expects the spanish inquisition";')
        ;

        $this->validate($method)->shouldHaveType(SomeViolation::class);
    }
}
