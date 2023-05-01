<?php

declare(strict_types=1);

namespace ConstructionStages\Models;

use ConstructionStages\Repositories\ModelNotValidAttribute;

class Model implements \JsonSerializable
{
    public $attributes = [];

    public $table = '';

    protected $primaryKey = 'id';

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $name => $value) {
            if (array_search($name, $this->attributes) === false) {
                throw new ModelNotValidAttribute(get_class($this), $name);
            }
            $this->{$name} = $value;
        }
    }

    public function getKeyName()
    {
        return $this->primaryKey;
    }

    public function getIdentifier()
    {
        return $this->{$this->getKeyName()};
    }

    public function jsonSerialize(): mixed
    {
        return ($this->toArray());
    }

    public function toArray(): array
    {
        $array = get_object_vars($this);
        unset($array['attributes']);
        unset($array['table']);
        unset($array['primaryKey']);

        return $array;
    }
}
