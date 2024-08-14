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

use Memio\Model\FullyQualifiedName;
use Memio\Validator\Constraint;
use Memio\Validator\Violation;
use Memio\Validator\Violation\NoneViolation;
use Memio\Validator\Violation\SomeViolation;

class CollectionCannotHaveNameDuplicates implements Constraint
{
    public function validate($model): Violation
    {
        $firstElement = current($model);
        $fqcn = get_class($firstElement);
        $modelType = (new FullyQualifiedName($fqcn))->getName();
        $nameCount = [];
        foreach ($model as $element) {
            if (!isset($nameCount[$element->name])) {
                $nameCount[$element->name] = 0;
            }
            ++$nameCount[$element->name];
        }
        $messages = [];
        foreach ($nameCount as $name => $count) {
            if ($count > 1) {
                $messages[] = "Collection \"{$modelType}\" cannot have name \"{$name}\" duplicates ({$count} occurences)";
            }
        }

        return [] === $messages
            ? new NoneViolation()
            : new SomeViolation(implode("\n", $messages));
    }
}
