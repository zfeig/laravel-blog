/**
 * Created by Administrator on 2015/1/12.
 */
$(function(){
    artDialog.confirm = function (content, yes, no) {
        return artDialog({
            id: 'Confirm',
            icon: 'question',
            fixed: true,
            lock: true,
            opacity: 0.5,
            content: content,
            ok: function (here) {
                return yes.call(this, here);
            },
            cancel: function (here) {
                return no && no.call(this, here);
            }
        });
    };
    //alert(1);
    $(".del").click(function(){
        //原生写法
        //if(!window.confirm('确定要删除吗？')){
        //    return false;
        //}

        var url=$(this).attr('href');
        art.dialog.confirm('你确定要删除该记录吗？', function () {
            //alert(url);
            this.close();
            window.location.href=url;
        }, function () {
            this.close();
        });
        return false;
    });

    $(".fdel").click(function(){
        //原生写法
        //if(!window.confirm('确定要删除吗？')){
        //    return false;
        //}
        var url=$(this).attr('href');
        art.dialog.confirm('你确定要删除该记录吗？', function () {
            //alert(url);
            this.close();
            window.location.href=url;
        }, function () {
            this.close();
        });
        return false;
    });
})
