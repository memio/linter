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

    function it_accepts_unique_names()
    {
        $argument1 = new Argument('string', 'filename');
        $argument2 = new Argument('string', 'content');

        $this->validate([$argument1, $argument2])->shouldHaveType(
            NoneViolation::class
        );
    }

    function it_rejects_name_duplicates()
    {
        $argument1 = new Argument('string', 'filename');
        $argument2 = new Argument('string', 'filename');

        $this->validate([$argument1, $argument2])->shouldHaveType(
            SomeViolation::class
        );
    }
}
