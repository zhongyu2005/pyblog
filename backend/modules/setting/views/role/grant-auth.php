<?php
$this->title = '角色权限';
?>
<style>

</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                角色权限
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="addForm">

                    <div class="auth-row ">
                        <?php
                        if (!empty($list)) {
                            $userMenu=is_array($userMenu) ? array_flip($userMenu) : [];
                            foreach ($list as $val) {
                                ?>
                                <div class="auth-div">
                                    <div class="col-md-2 col-sm-2 clearfix">
                                        <div class="checkbox-inline">
                                            <label>
                                                <input type="checkbox" <?= isset($userMenu[$val['id']]) ? 'checked' : '' ?> class="menu<?= $val['id'] ?> parent1" name="menu[]" value="<?= $val['id'] ?>"> <?= $val['name'] ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-sm-10">
                                        <?php
                                        if (!empty($val['sub'])) {
                                            foreach ($val['sub'] as $sub) {
                                                ?>
                                                <div class="checkbox-inline">
                                                    <label>
                                                        <input type="checkbox" <?= isset($userMenu[$sub['id']]) ? 'checked' : '' ?> class="menu<?= $sub['id'] ?> parent2" name="menu[]" value="<?= $sub['id'] ?>"> <?= $sub['name'] ?>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
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

        $("#addForm").on("submit", function () {
            var frm = $(this);
            var name = $("#name");
            if (name.val() == '') {
                name.focus();
                return false;
            }
            if (frm.attr("lock") == '1') {
                return false;
            }
            frm.attr('lock', '1');
            var url = location.href.toString();
            var data = frm.serialize();
            $.post(url, data, function (j) {
                frm.attr('lock', '0');
                if (j.code == '1') {
                    alert(j.message);
                    return false;
                }
                if (j.code == '0') {
                    alert('操作成功');
                    location = '?r=setting/role/index';
                }
            }, 'json');
            return false;
        });

    })
</script>