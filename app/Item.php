<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'name', 'is_deleted', 'created_at', 'updated_at'
    ];

}
