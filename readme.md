## 基于laravel4.2开发的博客系统，完善的前台和后台

前端采用bootstrap响应式布局，后端手写普通布局，以及artdailog弹窗，构建了简单简洁的后台界面，实现了文章，文章标签，文章分类，文章搜索等完整的CURD功能，代码都有详细注释，没有过多封装，比较容易理解！

后台着重实现了，文章多标签添加，分类删除，文章回车站，文章单条恢复，文章批量删除等特色功能，思路适合大多数关联性操作，看完了对处理其他关联模型很有帮助

基于多用户，实现多用户登录，编辑，查找，权限处理等，实现用户头像处理，博客首面也是基于独立用户展示的，系统首页可以展示多用户的内容，扩展性强，（有点自吹自擂），总之还是有干货的，对于初学laravel的同学来说绝对是不错的入门教材，

##关于登录

登录地址，注册地址首页都有链接 http://loclahost:8000/user/login   http://loclahost:8000/user/register  

提供几个登录测试账号及密码：
admin@123.com  123456
zfeig@126.com  123456
lisi@126.com   123456
baidu@126.com  123456

## 关于安装

数据库采用mysql，数据库文件lv.sql,已提供，数据配置看看config里面的db节点；建议使用php artisan serve启动服务来进行浏览测试！

### 感谢Laravel

**php是最好的开发语言，laravel是最好的开发框架，有没有！真心不黑**

### License

The   is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
