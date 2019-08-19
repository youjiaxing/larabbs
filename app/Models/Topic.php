<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeWithOrder($query, $order)
    {
        /* @var Builder $query */
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
        }
        return $query->with('user', 'category');
    }

    public function scopeRecentReplied($query)
    {
        /* @var Builder $query */
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        /* @var Builder $query */
        return $query->orderBy('created_at', 'desc');
    }
}
