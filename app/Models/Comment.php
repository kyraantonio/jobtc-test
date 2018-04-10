<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['comment_id', 'belongs_to', 'unique_id', 'comment', 'commenter_id','commenter_type'];

    protected $primaryKey = 'comment_id';
    protected $table = 'comment';

    public function user() {
        return $this->hasOne('App\Models\User','user_id','commenter_id');
    }
    
    public function applicant() {
        return $this->hasOne('App\Models\Applicant','id','unique_id');
    }
    
}
