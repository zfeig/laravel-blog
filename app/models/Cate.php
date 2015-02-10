<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/12
 * Time: 10:18
 */
use Illuminate\Database;
class Cate extends Eloquent{
    protected $fillable = array('name', 'count','pid','uid','desc');
}