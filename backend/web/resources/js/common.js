var def = {};


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
                delete d.columns;
                delete d.search;
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

function s_render(str, param) {
    var reg = /{([^{}]+)}/gm;
    str = str.replace(reg, function (match, name) {
        return param[name];
    })
    return str;
}