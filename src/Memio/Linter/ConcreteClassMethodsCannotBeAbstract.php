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

class ConcreteClassMethodsCannotBeAbstract implements Constraint
{
    public function validate($model): Violation
    {
        if ($model->isAbstract) {
            return new NoneViolation();
        }
        $messages = [];
        foreach ($model->methods as $method) {
            if ($method->isAbstract) {
                $messages[] = "Concrete class method {$model->getName()}::{$method->name}() cannot be abstract";
            }
        }

        return [] === $messages
            ? new NoneViolation()
            : new SomeViolation(implode("\n", $messages));
    }
}
