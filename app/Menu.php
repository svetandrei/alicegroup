<?php

namespace Alice;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
    protected $table = "menu";

    protected $fillable = ['id','publish', 'title', 'h_title', 'url', 'text', 'meta_keywords', 'meta_description', 'params'];
}
