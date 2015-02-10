<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/12
 * Time: 10:18
 */
use Illuminate\Database;
class Tag extends Eloquent{
    protected $table = 'tags';
    protected $fillable = array('uid','tag', 'aid');
}