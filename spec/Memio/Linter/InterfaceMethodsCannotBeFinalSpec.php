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

class InterfaceMethodsCannotBeFinalSpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_accepts_interfaces_with_non_final_methods()
    {
        $contract = (new Contract('Memio\PrettyPrinter\TemplateEngine'))
            ->addMethod(new Method('render'))
        ;

        $this->validate($contract)->shouldHaveType(NoneViolation::class);
    }

    function it_rejects_interfaces_with_final_methods()
    {
        $contract = (new Contract('Memio\PrettyPrinter\TemplateEngine'))
            ->addMethod((new Method('render'))
                ->makeFinal()
            )
        ;

        $this->validate($contract)->shouldHaveType(SomeViolation::class);
    }
}
