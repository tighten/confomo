<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

trait OwnsModels
{
    /**
     * Determine if this model owns the given model.
     *
     * @param Model $model
     *
     * @return bool
     */
    public function owns(Model $model)
    {
        return $this->id === $model->{$this->getForeignKey()};
    }
}
