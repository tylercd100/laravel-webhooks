<?php

namespace Tylercd100\Laravel\Webhooks\Models;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    protected $guarded = array("id");

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'webhooks';

    public function user()
    {
        $class = config("auth.providers.users.model");
        
        if (empty($class))
            return null;

        return $this->belongsTo($class);
    }
}