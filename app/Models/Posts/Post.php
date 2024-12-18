<?php

namespace App\Models\Posts;

use App\Models\Users\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, Sluggable;

    const STATUS = [
        'PUBLISHED' => 'PUBLISHED',
        'DRAFT' => 'DRAFT',
        'PENDING' => 'PENDING'
    ];

    const NOT_FEATURED = 0;
    const FEATURED = 1;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
