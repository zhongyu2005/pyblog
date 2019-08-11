<?php
$this->title = '角色更新';
?>
<style>

</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                角色更新
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="addForm">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">角色名称</label>
                        <div class="col-sm-10">
                            <input type="text" id="name" name="name" class="form-control" maxlength="50" placeholder="菜单名称" require value="<?= $set['name']??'' ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="col-sm-2 control-label">角色描述</label>
                        <div class="col-sm-10">
                            <input type="text" id="mark" name="mark" class="form-control" maxlength="255" placeholder="菜单描述" value="<?= $set['mark']??'' ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">提交</button>
                            <a href="javascript:history.back();" class="btn btn-default">返回</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("body").addClass('cm-1-navbar');

        $("#addForm").on("submit",function(){
            var frm=$(this);
            var name=$("#name");
            if(name.val()==''){
                name.focus();
                return false;
            }
            if(frm.attr("lock")=='1'){
                return false;
            }
            frm.attr('lock','1');
            var url=location.href.toString();
            var data=frm.serialize();
            $.post(url,data,function(j){
                frm.attr('lock','0');
                if(j.code=='1'){
                    alert(j.message);
                    return false;
                }
                if(j.code=='0'){
                    alert('操作成功');
                    location='?r=setting/role/index';
                }
            },'json');
            return false;
        });

    })
</script>