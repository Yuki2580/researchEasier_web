<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class memo extends Model
{
  //  use HasFactory;
  protected $table = 'memo';//使いたいテーブル名を指定
  protected $primaryKey = 'memo_id';
  //可変項目
  public $timestamps=false;

  protected $fillable =
  [
      'content',
      'page',
      'projectID',
      'paperNum'
  ];

}
