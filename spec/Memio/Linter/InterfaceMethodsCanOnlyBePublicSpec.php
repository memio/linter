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

class InterfaceMethodsCanOnlyBePublicSpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_accepts_interface_with_no_visibility_methods()
    {
        $contract = (new Contract('Memio\PrettyPrinter\TemplateEngine'))
            ->addMethod((new Method('render'))
                ->removeVisibility()
            )
        ;

        $this->validate($contract)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_interface_with_no_public_methods()
    {
        $contract = (new Contract('Memio\PrettyPrinter\TemplateEngine'))
            ->addMethod(new Method('render'))
        ;

        $this->validate($contract)->shouldHaveType(NoneViolation::class);
    }

    function it_rejects_interface_with_private_methods()
    {
        $contract = (new Contract('Memio\PrettyPrinter\TemplateEngine'))
            ->addMethod((new Method('render'))
                ->makePrivate()
            )
        ;

        $this->validate($contract)->shouldHaveType(SomeViolation::class);
    }

    function it_rejects_interface_with_protected_methods()
    {
        $contract = (new Contract('Memio\PrettyPrinter\TemplateEngine'))
            ->addMethod((new Method('render'))
                ->makeProtected()
            )
        ;

        $this->validate($contract)->shouldHaveType(SomeViolation::class);
    }
}
