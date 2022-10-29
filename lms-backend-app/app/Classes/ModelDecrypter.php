<?php
namespace App\Classes;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class ModelDecrypter
{
    public function decryptModel(Model $model)
    {
        foreach ($model->getEncryptable() as $attribute) {
            $model->setAttribute($attribute, decrypt($model->getAttribute($attribute)));
        }

        return $model;
    }

    public function decryptCollection(Collection $collection)
    {
        return $collection->map(function (Model $model) {
            return $this->decryptModel($model);
        });
    }
}
