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

use Memio\Validator\{
    Constraint,
    Violation
};
use Memio\Validator\Violation\{
    NoneViolation,
    SomeViolation
};

class MethodCannotBeAbstractAndHaveBody implements Constraint
{
    public function validate($model) : Violation
    {
        if ($model->isAbstract() && null !== $model->getBody()) {
            return new SomeViolation(sprintf(
                'Method "%s" cannot be abstract and have a body',
                $model->getName()
            ));
        }

        return new NoneViolation();
    }
}
