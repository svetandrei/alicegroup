<?php

namespace Alice;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcement';

    protected $fillable = ['title', 'alias', 'publish', 'sort', 'image', 'desc', 'text', 'author_id', 'meta_keywords', 'meta_description'];

    public function author(){
        return $this->belongsTo('Alice\Author');
    }
}
