<?php

namespace App\Models;

use DateTimeInterface;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('c');
    }

    /**
     * @param string $attribute
     * @param mixed $from
     * @param mixed $to
     * @return bool
     */
    public function wasAttributeChanged($attribute, $from, $to)
    {
        return $this->getOriginal($attribute) === $from
            && $this->getAttribute($attribute) === $to;
    }
}
