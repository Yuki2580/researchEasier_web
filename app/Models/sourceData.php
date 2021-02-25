<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sourceData extends Model
{
    //use HasFactory;
    protected $table = 'sourceData';//使いたいテーブル名を指定
    protected $primaryKey = 'resourceNum';
    //可変項目
    public $timestamps=false;

    protected $fillable =
    [
        'title',
        'author',
        'year',
        'abstract',
        'comment',
        'oneWord',
        'userNum',
        'projectNum',
        'position',
        'status'
    ];
}
