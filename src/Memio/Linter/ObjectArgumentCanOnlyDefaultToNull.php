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

class ObjectArgumentCanOnlyDefaultToNull implements Constraint
{
    public function validate($model): Violation
    {
        if ($model->type->isObject && null !== $model->defaultValue && 'null' !== $model->defaultValue) {
            return new SomeViolation("Argument \${$model->name} of type {$model->type->name} cannot have default value different than NULL");
        }

        return new NoneViolation();
    }
}
