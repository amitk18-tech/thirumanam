<?php

namespace App\Models;

use Bits\Package\Models\Role as BaseRole;

class Role extends BaseRole
{

        protected $fillable = ['name', 'description', 'slug'];


    public function __construct(array $attributes = [])
    {
        // Merge BaseUser fillable dynamically
        $this->fillable = array_merge(
            $this->fillable, // current class fields
            parent::$fillable ?? [] // only if defined as static, otherwise use parent instance
        );

        parent::__construct($attributes);
    }

    public function permissions()
    {
        return parent::permissions();
    }
}