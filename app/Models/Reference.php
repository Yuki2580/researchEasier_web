<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    //use HasFactory;]
    protected $table = 'reference';//使いたいテーブル名を指定
    protected $primaryKey = 'referenceNum';
    //可変項目
    public $timestamps=false;

    protected $fillable =
    [
        'fullReference',
        'shortReference',
        'type',
        'project_num',
        'paper_num'
    ];
}
