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

use Memio\Model\Argument;
use Memio\Validator\Constraint;
use Memio\Validator\Violation\NoneViolation;
use Memio\Validator\Violation\SomeViolation;
use PhpSpec\ObjectBehavior;

class CollectionCannotHaveNameDuplicatesSpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_is_fine_with_unique_names(
        Argument $argument1,
        Argument $argument2
    ) {
        $argument1->getName()->willReturn('myArgument1');
        $argument2->getName()->willReturn('myArgument2');

        $this->validate([$argument1, $argument2])->shouldHaveType(
            NoneViolation::class
        );
    }

    function it_is_not_fine_with_name_duplicates(
        Argument $argument1,
        Argument $argument2
    ) {
        $argument1->getName()->willReturn('myArgument');
        $argument2->getName()->willReturn('myArgument');

        $this->validate([$argument1, $argument2])->shouldHaveType(
            SomeViolation::class
        );
    }
}
