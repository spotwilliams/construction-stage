<?php

declare(strict_types=1);

namespace ConstructionStages\Models;

use ConstructionStages\Repositories\ModelNotValidAttribute;

class Model implements \JsonSerializable
{
    public $attributes = [];

    public $table = '';

    protected $primaryKey = 'id';

    /**
     * Constructor method for the model.
     *
     * @param array $attributes An array of attributes to set on the model.
     *
     * @throws ModelNotValidAttribute If an attribute is passed that is not defined in the model's attributes array.
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $name => $value) {
            if (array_search($name, $this->attributes) === false) {
                throw new ModelNotValidAttribute(get_class($this), $name);
            }
            $this->{$name} = $value;
        }
    }

    /**
     * Get the primary key for the model.
     *
     * @return string The name of the primary key for the model.
     */
    public function getKeyName()
    {
        return $this->primaryKey;
    }

    /**
     * Get the value of the model's primary key.
     *
     * @return mixed The value of the primary key for the model.
     */
    public function getIdentifier()
    {
        return $this->{$this->getKeyName()};
    }

    /**
     * Returns an array that can be serialized to JSON.
     *
     * @return mixed The serialized JSON data.
     */
    public function jsonSerialize(): mixed
    {
        return ($this->toArray());
    }

    /**
     * Convert the model's attributes to an array.
     *
     * @return array An array representation of the model's attributes.
     */
    public function toArray(): array
    {
        $array = get_object_vars($this);
        unset($array['attributes']);
        unset($array['table']);
        unset($array['primaryKey']);

        return $array;
    }
}
