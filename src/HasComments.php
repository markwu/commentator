<?php

namespace Plmrlnsnts\Commentator;

use Plmrlnsnts\Commentator\Comment;

trait HasComments
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootHasComments()
    {
        static::deleting(function ($model) {
            $model->comments()->delete();
        });
    }

    /**
     * The comments associated to this model.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Add a new comment to this model.
     *
     * @param array $values
     * @return \Plmrlnsnts\Commentator\Comment
     */
    public function addComment($values)
    {
        $values['user_id'] ??= auth()->id();

        return $this->comments()->create($values);
    }

    /**
     * Used to identify this commentable.
     *
     * @return string
     */
    public function commentableKey()
    {
        return base64_encode($this->getMorphClass() . '::' . $this->id);
    }

    /**
     * Get the commentable key attribute.
     *
     * @return string
     */
    public function getCommentableKeyAttribute()
    {
        return $this->commentableKey();
    }
}
