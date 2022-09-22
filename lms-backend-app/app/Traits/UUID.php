<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UUID
{
    protected static function boot ()
    {
        // Boot other traits on the Model
        parent::boot();

        /** 
         * Listen for the creating event on the user model.
         * Sets the 'id' to a UUID using Str::uuid() on the instance being created
         */
        static::creating(function ($model) {
        try{
            if ($model->getKey() === null) {
                $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
            }
        }catch (UnsatisfiedDependencyException $e) {
            abort(500, $e->getMessage());
           }
        });

    //     try {
    //         $model->id = (string) Str::uuid(); // generate uuid
    //         // Change id with your primary key
    //     } catch (UnsatisfiedDependencyException $e) {
    //         abort(500, $e->getMessage());
    //     }
    // });

    }

    // Tells the database not to auto-increment this field
    public function getIncrementing ()
    {
        return false;
    }

    // Helps the application specify the field type in the database
    public function getKeyType ()
    {
        return 'string';
    }
}
