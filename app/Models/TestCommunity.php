<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCommunity extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'test_id',
        'order',
        'version',
        'parent_test_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'test_community';

    public function test() {
        return $this->belongsTo('App\Models\Test', 'test_id', 'id')
            ->select(array(
                'user_id as author_id',
                'title',
                'description',
                'length',
                'version',
                'average_score',
                'test_photo',
                'start_message',
                'completion_message',
                'completion_image',
                'completion_sound',
                'default_tags',
                'default_points',
                'default_time'
            ));
    }
}
