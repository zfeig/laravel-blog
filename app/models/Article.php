<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/12
 * Time: 10:18
 */
use Illuminate\Database;
    class Article extends Eloquent{
        protected $fillable = array('title', 'text','author','brief','uid','cid','status');

        public function getCate(){
            return $this->hasOne('Cate','id','cid');//cate表的id=articles表的cid
        }

        public function getTags(){
            return $this->hasMany('Tag','aid','id');//tags表中的aid=articles表的id
        }
    }