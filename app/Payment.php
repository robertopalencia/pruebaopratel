<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as MongoModel;

class Payment extends MongoModel
{
    //
    public function users()
    {
        return $this->hasMany("User", "phone", "phone");
    }
}
