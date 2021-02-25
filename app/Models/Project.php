<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //use HasFactory;

    protected $table = 'project';//使いたいテーブル名を指定
    protected $primaryKey = 'projectCounter';
    //可変項目
    public $timestamps=false;

    protected $fillable =
    [
        'projectName',
        'project_description',
        'user_ID'
    ];
}
