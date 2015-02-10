<style>
ul,li{list-style: none;padding: 0;margin: 0}
.navbar{width: 195px;height:auto;position: fixed;top:10px;left:0px;border-shadow:3px 1px 5px #888;background: #f7f7f7;padding: 5px; }
.navbar a{display: block;height: 30px;line-height: 30px;border-bottom: 1px solid #F7F7F7;background: #fff;}
.navbar a:hover{background: #F2F2F2;}
.submenu{font-weight: bold;text-indent: 2em;cursor: pointer}
.navbar ul li dl dt a{text-indent: 3em;}
.submenu span.folder{font-weight: bold;font-size:1.5em;}
</style>


<div class="navbar">
<ul>
    <li>
        <a class="submenu"  target="_blank"><span class="folder">+</span>文章管理</a>
        <dl>
            <dt><a href="/articles">文章列表</a></dt>
            <dt><a href="/cate">文章分类</a></dt>
            <dt><a href="/articles/create">添加文章</a></dt>
            <dt><a href="/search">文章搜索</a></dt>
        </dl>
    </li>
    
    <li>
        <a class="submenu"  target="_blank"><span class="folder">+</span>回车站管理</a>
         <dl>
            <dt><a href="/recycle">回车站列表</a></dt>
            <dt><a href="/find">文章搜索</a></dt>
         </dl>
    </li>
    <li>
        <a class="submenu"  target="_blank"><span class="folder">+</span>用户管理</a>
         <dl>
            <dt><a href="/user/home">用户中心</a></dt>
            <dt><a href="/user/pic">修改头像</a></dt>
            <dt><a href="/user/pwd">修改密码</a></dt>
            <dt><a href="/user/edit">修改资料</a></dt>
        </dl>
    </li>
</ul>
</div>