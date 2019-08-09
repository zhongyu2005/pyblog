<style>
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
                        <input type="text" class="form-control" id="name" value="" placeholder="请输入名称" />
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
                <table class="table table-bordered table-hover" id="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>名称</th>
                        <th>备注</th>
                        <th>状态</th>
                        <th>最后更新时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>10086</td>
                        <td>启用</td>
                        <td>2019-05-09 11:11:22</td>
                        <td>权限</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script>
    $(function () {
        $("body").addClass('cm-1-navbar');

        $(".search").on('click', function () {
            let url = '?r=setting/role/index';
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
    })

    function datatable_config() {
        var config = {
            paging: true,//开启分页
            pagingType: 'full_numbers',//分页样式
            searching: false,//开启搜索
            ordering: false,//开启排序
            info: true,//显示当前页,总页
            lengthChange: true,//开启长度控制
            pageLength: 25,//分页长度
            language: {
                paginate: {
                    first: "首页",
                    last: "尾页",
                    previous: "<<",
                    next: ">>"
                },
                processing: "数据正在加载中……",
                emptyTable: "无数据",//No data available in table
                info: "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                infoEmpty: "显示第 0 至 0 项结果，共 0 项",//Showing 0 to 0 of 0 entries
                infoFiltered: "(由 _MAX_ 项结果过滤)",//(filtered from _MAX_ total entries)
                lengthMenu: "显示 _MENU_ 条"
            },
            ajax: {
                url: location.href.toString(),
                type: "POST",
                data: function (d) {
                    delete  d.columns;
                    delete  d.search;
                }
            },
            dataSrc: 'data',//返回数据源
            deferRender: true,//延迟
            processing: true,//加载提示
            serverSide: true,//同步服务器模式
            columns: []
        };
        return config;
    }

    function init_table() {
        var config = datatable_config();
        config.paging = true;
        config.lengthChange = true;
        config.ajax = {
            url: location.href.toString(),
            type: "POST",
            data: function (d) {
                delete  d.columns;
                delete  d.search;
                d.name = $("#name").val();
                d.status = $("#status").val();
            }
        };
        config.columns = [
            {
                "data": "id",
                render: function (data, type, now, meta) {
                    var pid=meta.settings._iDisplayStart+meta.row + 1;
                    return pid;
                }
            },
            {
                "data": "name",
                render: function (data, type, row) {
                    return '<a href="?r=setting/menu/update&id=' + row.id + '">' + data + '</a>';
                }
            },
            {"data": "mark"},
            {"data": "update_at"},
            {
                "data": "id",
                render: function (data, type, row) {
                    return '<a onclick="delRole(this)" href="javascript:;" data-href="<?=\yii\helpers\Url::toRoute(['role/del'])?>&id=' + row.id + '">删除</a>'+
                        '&nbsp;<a href="?r=setting/menu/grant-auth&id=' + row.id + '">权限</a>';
                }
            }
        ];

        def.table = $('#table').DataTable(config);
    }

</script>