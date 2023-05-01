<?php

declare(strict_types=1);

namespace ConstructionStages\Repositories;

class ModelNotValidAttribute extends \Exception
{
    public function __construct(string $modelName, string $attribute)
    {
        parent::__construct("The `{$modelName} has not `{$attribute}` defined in the list of attributes.", 500);
    }
}
