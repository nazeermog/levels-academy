<?php

namespace DataSource\Entities\Blog;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use DataSource\Entities\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory, Translatable;
    protected $table = 'blogs';

    public $translationForeignKey = 'blog_id';
    protected $translatedAttributes = [
        'title',
        'desc',

    ];
    protected $fillable = [
        'photo',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
