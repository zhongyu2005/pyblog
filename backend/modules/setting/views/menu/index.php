<?php
$this->title = '菜单列表';
?>
<style>
    i.fa {
        cursor: pointer;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="form-group">
                    <div class="col-md-1 col-sm-1">
                        <a href="?r=setting/menu/create" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;创建</a>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <select id="type" class="form-control">
                            <option value="">不限制</option>
                            <option value="1">普通菜单</option>
                            <option value="2">角色菜单</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <select id="status" class="form-control">
                            <option value="">不限制</option>
                            <option value="0">启用</option>
                            <option value="1">禁用</option>
                        </select>
                    </div>

                    <div class="col-md-2 col-sm-3">
                        <a href="javascript:;" class="btn btn-info search "><i class="fa fa-search"></i>&nbsp;搜索</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover" id="menu-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>名称</th>
                        <th>route</th>
                        <th>分类</th>
                        <th>状态</th>
                        <th>排序</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>setting/menu/index</td>
                        <td>一级分类</td>
                        <td>启用</td>
                        <td>100</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("body").addClass('cm-1-navbar');

        $(".search").on('click', function () {
            let url = '?r=setting/menu/index';
            let type = $("#type").val(), status = $("#status").val();
            let data = {type: type, status: status};
            $.post(url, data, function (j) {
                if (j.code == '1') {
                    alert(j.message);
                    return;
                }
                showTable(j.data);
            }, 'json');
        }).trigger('click');

        $("#menu-table").on('click', '.iparent', function (e) {
            let id = $(this).data('id');
            if ($(this).hasClass("fa-folder-open")) {
                $(".tr-sub" + id).hide();
                $(this).addClass("fa-folder").removeClass("fa-folder-open");
            } else {
                $(".tr-sub" + id).show();
                $(this).removeClass("fa-folder").addClass("fa-folder-open");
            }
        })
    })

    function showTable(list) {
        if (!list || !list.length) {
            $("#menu-table tbody").html('');
            return;
        }
        let tpl = $("#tpl").html();
        let ar = [];
        let ind = 1;
        for (let i in list) {
            let obj = list[i];
            obj._id = ind++;
            obj._class = 'tr-parent';
            obj.parent_str = '<i class="fa fa-folder-open iparent" data-id="' + obj.id + '"></i>';
            ar.push(s_render(tpl, obj));
            if (obj.sub && obj.sub.length) {
                for (var j in obj.sub) {
                    let sub = obj.sub[j];
                    sub._id = ind++;
                    sub._class = 'tr-sub' + obj.id;
                    sub.name = '&nbsp;&nbsp;-&nbsp;' + sub.name;
                    sub.parent_str = obj.name;
                    ar.push(s_render(tpl, sub));
                }
            }
        }
        $("#menu-table tbody").html(ar.join(''));
    }
</script>
<script type="text/template" id="tpl">
    <tr class="{_class}" data-id="{id}">
        <th scope="row"><a href="?r=setting/menu/create&id={id}">{_id}</a></th>
        <td><a href="?r=setting/menu/update&id={id}">{name}</a></td>
        <td>{route}</td>
        <td>{parent_str}</td>
        <td>{status_str}</td>
        <td>{sort}</td>
    </tr>
</script>