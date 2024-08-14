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

class ObjectArgumentCanOnlyDefaultToNullSpec extends ObjectBehavior
{
    function it_is_a_constraint()
    {
        $this->shouldImplement(Constraint::class);
    }

    function it_accepts_object_arguments_without_default_value()
    {
        $argument = new Argument('DateTime', 'startDate');

        $this->validate($argument)->shouldHaveType(NoneViolation::class);
    }

    function it_accepts_object_arguments_with_null_default_value()
    {
        $argument = new Argument('DateTime', 'startDate');
        $argument->defaultValue = 'null';

        $this->validate($argument)->shouldHaveType(NoneViolation::class);
    }

    function it_rejects_object_arguments_with_non_null_default_value()
    {
        $argument = new Argument('DateTime', 'startDate');
        $argument->defaultValue = '42';

        $this->validate($argument)->shouldHaveType(SomeViolation::class);
    }
}
