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

class ContractMethodsCannotBeStatic implements Constraint
{
    public function validate($model) : Violation
    {
        $contractName = $model->getName();
        $messages = [];
        foreach ($model->allMethods() as $method) {
            if ($method->isStatic()) {
                $messages[] = sprintf(
                    'Contract "%s" Method "%s" cannot be static',
                    $contractName,
                    $method->getName()
                );
            }
        }

        return (empty($messages) ? new NoneViolation() : new SomeViolation(implode("\n", $messages)));
    }
}
