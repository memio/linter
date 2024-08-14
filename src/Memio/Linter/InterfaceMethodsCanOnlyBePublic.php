<?php

/*
 * This file is part of the memio/linter package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Memio\Linter;

use Memio\Validator\Constraint;
use Memio\Validator\Violation;
use Memio\Validator\Violation\NoneViolation;
use Memio\Validator\Violation\SomeViolation;

class InterfaceMethodsCanOnlyBePublic implements Constraint
{
    public function validate($model): Violation
    {
        $messages = [];
        foreach ($model->methods as $method) {
            if ('' !== $method->visibility && 'public' !== $method->visibility) {
                $messages[] = "Interface method {$model->getName()}::{$method->name}() can only be public";
            }
        }

        return [] === $messages
            ? new NoneViolation()
            : new SomeViolation(implode("\n", $messages));
    }
}
