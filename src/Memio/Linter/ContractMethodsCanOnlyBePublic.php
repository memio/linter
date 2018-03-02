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

class ContractMethodsCanOnlyBePublic implements Constraint
{
    public function validate($model): Violation
    {
        $contractName = $model->getName();
        $messages = [];
        foreach ($model->allMethods() as $method) {
            $visibility = $method->getVisibility();
            if ('' !== $visibility && 'public' !== $visibility) {
                $messages[] = sprintf(
                    'Contract "%s" Method "%s" can only be public',
                    $contractName,
                    $method->getName()
                );
            }
        }

        return empty($messages) ? new NoneViolation() : new SomeViolation(implode("\n", $messages));
    }
}
