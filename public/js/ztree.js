/**
 * Created by Administrator on 2015/1/18.
 */
var setting = {	};

var zNodes =[
    { name:"文章管理", open:true,
        children: [
            { name:"文章列表",url:"/articles",target:"_self"},
            { name:"文章分类",url:"/cate",target:"_self"},
            { name:"添加文章",url:"/articles/create",target:"_self"},
            { name:"文章搜索 ",url:"/search",target:"_self"}
        ]},
    { name:"回收站管理",open:true,
        children: [
            { name:"回车站列表",url:"/recycle",target:"_self"},
            { name:"文章搜索",url:"/find",target:"_self"}
        ]},
    { name:"用户管理",open:true,
        children: [
            { name:"用户中心",url:"/user/home",target:"_self"},
            { name:"修改密码",url:"/user/pwd",target:"_self"},
            { name:"修改资料",url:"/user/edit",target:"_self"},
            { name:'修改头像',url:"/user/pic",target:"_self"}
        ]}
];
$(document).ready(function(){
    $.fn.zTree.init($("#treeDemo"), setting, zNodes);
});