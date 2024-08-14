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
use Memio\Model\Objekt;
use Memio\Validator\Constraint;
use Memio\Validator\Violation\NoneViolation;
use Memio\Validator\Violation\SomeViolation;
use PhpSpec\ObjectBehavior;

class ConcreteClassMethodsCannotBeAbstractSpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_accepts_abstract_class_with_no_methods()
    {
        $objekt = (new Objekt('Memio\Model\AbstractClass'))
            ->makeAbstract()
        ;

        $this->validate($objekt)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_abstract_class_with_abstract_methods()
    {
        $objekt = (new Objekt('Memio\Model\AbstractClass'))
            ->makeAbstract()
            ->addMethod((new Method('abstractMethod'))
                ->makeAbstract()
            )
        ;

        $this->validate($objekt)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_abstract_class_with_concrete_methods()
    {
        $objekt = (new Objekt('Memio\Model\AbstractClass'))
            ->makeAbstract()
            ->addMethod(new Method('concreteMethod'))
        ;

        $this->validate($objekt)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_concrete_class_with_no_methods()
    {
        $objekt = new Objekt('Memio\Model\ConcreteClass');

        $this->validate($objekt)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_concrete_class_with_concrete_methods()
    {
        $objekt = (new Objekt('Memio\Model\ConcreteClass'))
            ->addMethod(new Method('concreteMethod'))
        ;

        $this->validate($objekt)->shouldHaveType(NoneViolation::class);
    }

    function it_rejects_concrete_class_with_abstract_methods()
    {
        $objekt = (new Objekt('Memio\Model\ConcreteClass'))
            ->addMethod((new Method('abstractMethod'))
                ->makeAbstract()
            )
        ;

        $this->validate($objekt)->shouldHaveType(SomeViolation::class);
    }
}
