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

class InterfaceMethodsCannotHaveBodySpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_accepts_interface_with_abstract_methods()
    {
        $contract = (new Contract('Memio\PrettyPrinter\TemplateEngine'))
            ->addMethod(new Method('render'))
        ;

        $this->validate($contract)->shouldHaveType(NoneViolation::class);
    }

    function it_rejects_interface_method_that_have_body()
    {
        $contract = (new Contract('Memio\PrettyPrinter\TemplateEngine'))
            ->addMethod((new Method('render'))
                ->setBody('echo "Nobody expects the spanish inquisition";')
            )
        ;

        $this->validate($contract)->shouldHaveType(SomeViolation::class);
    }
}
