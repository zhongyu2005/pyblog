<?php
$this->title = '角色列表';
?>
<style>
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="form-group">
                    <div class="col-md-1 col-sm-1">
                        <a href="?r=setting/role/create" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;创建</a>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <input type="text" class="form-control" id="name" value="" placeholder="请输入名称"/>
                    </div>
                    <div class="col-md-2 col-sm-3">
                        <a href="javascript:;" class="btn btn-info search "><i class="fa fa-search"></i>&nbsp;搜索</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover" id="py-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>名称</th>
                        <th>备注</th>
                        <th>最后更新时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script>
    $(function () {
        $("body").addClass('cm-1-navbar');

        $(".search").on('click', function () {
            def.table.clear().draw();
        });
        init_table();
    })

    function init_table() {
        var config = datatable_config();
        config.ajax = {
            url: location.href.toString(),
            type: "POST",
            data: function (d) {
                delete d.columns;
                delete d.search;
                d.name = $("#name").val();
            }
        };
        config.columns = [
            {
                "data": "id",
                render: function (data, type, now, meta) {
                    var pid = meta.settings._iDisplayStart + meta.row + 1;
                    return pid;
                }
            },
            {
                "data": "name",
                render: function (data, type, row) {
                    return '<a href="?r=setting/role/update&id=' + row.id + '">' + data + '</a>';
                }
            },
            {"data": "mark"},
            {"data": "updated_at"},
            {
                "data": "id",
                render: function (data, type, row) {
                    return '<a onclick="delRole(this)" href="javascript:;" data-href="?r=setting/role/del&id=' + row.id + '">删除</a>' +
                        '&nbsp;<a href="?r=setting/role/grant-auth&id=' + row.id + '">权限</a>';
                }
            }
        ];
        def.table = $('#py-table').DataTable(config);
    }

    function delRole(obj) {
        layer.confirm('确定删除？', {
            btn: ['确定', '取消'] //按钮
        }, function () {
            obj = $(obj);
            var url = obj.attr("data-href");
            $.post(url, [], function (j) {
                if (j.code == '1') {
                    layer.msg(j.message, {icon: 5});
                    return;
                }
                if (j.code == '0') {
                    layer.msg('操作成功', {time: 1500});
                    location.reload();
                }
            }, 'json');
        }, function () {
            layer.msg('你已取消', {
                time: 2000,
                icon: 5
            });
        });

        return false;
    }

</script>