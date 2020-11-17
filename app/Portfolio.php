<?php

namespace Alice;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model{
    protected $table = "portfolio";

    protected $fillable = ['id', 'publish', 'image'];
}
