<style>

</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                菜单创建
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="addForm">
                    <div class="form-group">
                        <label for="desc" class="col-sm-2 control-label">菜单分类</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="pid" id="pid">
                                <option value="0">顶级菜单</option>
                                <?php
                                if (!empty($parentMenu)) {
                                    foreach ($parentMenu as $v) {
                                        ?>
                                        <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                                        <?php if (!empty($v['sub'])) {
                                            foreach ($v['sub'] as $vo) {
                                                ?>
                                                <option value="<?= $vo['id'] ?>"><?= '&nbsp;-&nbsp;' . $vo['name'] ?></option>
                                                <?php
                                            }
                                        } ?>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">菜单名称</label>
                        <div class="col-sm-10">
                            <input type="text" id="name" name="name" class="form-control" maxlength="50" placeholder="菜单名称" require value="<?= $menu['name'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="route" class="col-sm-2 control-label">功能</label>
                        <div class="col-sm-10">
                            <input type="text" id="route" name="route" class="form-control" placeholder="功能" require value="<?= $menu['route'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-sm-2 control-label">菜单类型</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <label><input type="radio" name="type" <?php if ($menu['type'] == '1' || !isset($menu)) echo 'checked'; ?> value="1"/>普通菜单</label>
                                <label><input type="radio" name="type" <?php if ($menu['type'] == '2') echo 'checked'; ?> value="2"/>权限菜单</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">菜单状态</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <label><input type="radio" name="status" <?php if ($menu['status'] == '1' || !isset($menu)) echo 'checked'; ?> value="1"/>启用</label>
                                <label><input type="radio" name="status" <?php if ($menu['status'] == '2') echo 'checked'; ?> value="9"/>禁用</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sort" class="col-sm-2 control-label">菜单排序</label>
                        <div class="col-sm-10">
                            <input type="text" id="sort" name="sort" class="form-control" placeholder="菜单排序" require value="<?= $menu['sort'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="col-sm-2 control-label">菜单描述</label>
                        <div class="col-sm-10">
                            <input type="text" id="mark" name="mark" class="form-control" maxlength="255" placeholder="菜单描述" value="<?= $menu['mark'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="col-sm-2 control-label">菜单className</label>
                        <div class="col-sm-10">
                            <input type="text" id="style" name="style" class="form-control" maxlength="255" placeholder="菜单className" value="<?= $menu['style'] ?>">
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

        <?php if(!empty($menu['pid'])){?>
        $("#pid").val(<?=$menu['pid']?>);
        <?php }?>
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
                    location='?r=setting/menu/index';
                }
            },'json');
            return false;
        });

    })
</script>