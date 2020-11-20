<?php

namespace Alice;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'author';

    protected $fillable = ['title'];

    public function announcements() {
        return $this->hasMany('Alice\Announcement');
    }
}
