<?php

namespace Alice;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    protected $fillable = ['title', 'alias', 'publish', 'sort', 'image', 'cover', 'desc', 'text', 'meta_keywords', 'meta_description'];
}
