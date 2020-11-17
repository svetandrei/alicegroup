<?php

namespace Alice;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {
    protected $table = 'pages';

    protected $fillable = ['id','publish','title', 'alias', 'text', 'params'];
}
