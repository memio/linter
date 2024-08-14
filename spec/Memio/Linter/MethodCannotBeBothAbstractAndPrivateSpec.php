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

class MethodCannotBeBothAbstractAndPrivateSpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_accepts_concrete_public_method()
    {
        $method = new Method('render');

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_concrete_method_with_no_visibility()
    {
        $method = (new Method('render'))
            ->removeVisibility()
        ;

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_concrete_protected_method()
    {
        $method = (new Method('render'))
            ->makeProtected()
        ;

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_concrete_private_method()
    {
        $method = (new Method('render'))
            ->makePrivate()
        ;

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_abstract_public_method()
    {
        $method = (new Method('render'))
            ->makeAbstract()
        ;

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_abstract_method_with_no_visibility()
    {
        $method = (new Method('render'))
            ->makeAbstract()
            ->removeVisibility()
        ;

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_abstract_protected_method()
    {
        $method = (new Method('render'))
            ->makeAbstract()
            ->makeProtected()
        ;

        $this->validate($method)->shouldHaveType(NoneViolation::class);
    }

    function it_rejects_abstract_private_method()
    {
        $method = (new Method('render'))
            ->makeAbstract()
            ->makePrivate()
        ;

        $this->validate($method)->shouldHaveType(SomeViolation::class);
    }
}
