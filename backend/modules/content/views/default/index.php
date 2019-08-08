<div class="container-fluid cm-container-white">
    <h2 style="margin-top:0;">欢迎您，Test !</h2>
    <p>今天也是美好的一天哦！</p>
</div>
<div class="container-fluid">
    <div class="row cm-fix-height">
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
            <a href="dashboard-sales.html" class="panel panel-default thumbnail cm-thumbnail">
                <div class="panel-body text-center">
                                <span class="svg-48">
                                    <img src="resources/img/sf/dashboard.svg" alt="dashboard">
                                </span>
                    <h4>Dashboard</h4> <small>C3.js charts to display some fancy pies.</small>

                </div>
            </a>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
            <a href="notepad.html" class="panel panel-default thumbnail cm-thumbnail">
                <div class="panel-body text-center">
                                <span class="svg-48">
                                    <img src="resources/img/sf/notepad.svg" alt="notepad">
                                </span>
                    <h4>Text editor</h4> <small>Summernote WYSIWYG Editor implementation.</small>

                </div>
            </a>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
            <a href="components-text.html" class="panel panel-default thumbnail cm-thumbnail">
                <div class="panel-body text-center">
                                <span class="svg-48">
                                    <img src="resources/img/sf/brick.svg" alt="brick">
                                </span>
                    <h4>Components</h4> <small>Bootstrap main classes.</small>

                </div>
            </a>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
            <a href="layouts-breadcrumb1.html" class="panel panel-default thumbnail cm-thumbnail">
                <div class="panel-body text-center">
                                <span class="svg-48">
                                    <img src="resources/img/sf/window-layout.svg" alt="window-layout">
                                </span>
                    <h4>Navbar layouts</h4> <small>Put all you need on the top of your screen.</small>

                </div>
            </a>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
            <a href="ico-sf.html" class="panel panel-default thumbnail cm-thumbnail">
                <div class="panel-body text-center">
                                <span class="svg-48">
                                    <img src="resources/img/sf/cat.svg" alt="cat">
                                </span>
                    <h4>Icons</h4> <small>Semantic little pics.</small>

                </div>
            </a>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
            <a href="login.html" class="panel panel-default thumbnail cm-thumbnail">
                <div class="panel-body text-center">
                                <span class="svg-48">
                                    <img src="resources/img/sf/lock-open.svg" alt="lock-open">
                                </span>
                    <h4>Login page</h4> <small>Have a look to the login page.</small>

                </div>
            </a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">选择你喜欢的颜色</div>
        <div class="panel-body" id="demo-buttons">
            <p>点击下面的按钮设置主导航颜色吧 :</p>
            <div class="row">
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <button class="btn btn-block btn-primary" data-switch-color="primary">天空蓝</button>
                    <br>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <button class="btn btn-block btn-success" data-switch-color="success">青草绿</button>
                    <br>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <button class="btn btn-block btn-info" data-switch-color="info">浅色蓝</button>
                    <br>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <button class="btn btn-block btn-warning" data-switch-color="warning">橙子色</button>
                    <br>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <button class="btn btn-block btn-danger" data-switch-color="danger">特别红</button>
                    <br>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <button class="btn btn-block btn-gray" data-switch-color="gray">淡灰色</button>
                    <br>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <button class="btn btn-block btn-yellow" data-switch-color="yellow">土黄色</button>
                    <br>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <button class="btn btn-block btn-purple" data-switch-color="purple">尊贵紫</button>
                    <br>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <button class="btn btn-block btn-turquoise" data-switch-color="turquoise">松石绿</button>
                    <br>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <button class="btn btn-block btn-midnight" data-switch-color="midnight">午夜黑</button>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        var btn_cc = 'btn-primary';
        var navbar_cc = 'cm-navbar-primary';
        $('#demo-buttons button').click(function () {
            var color = $(this).data('switch-color');
            $('.cm-navbar').removeClass(navbar_cc);
            navbar_cc = 'cm-navbar-' + color;
            $('.cm-navbar').addClass(navbar_cc);
            $('.cm-navbar .btn').removeClass(btn_cc);
            btn_cc = 'btn-' + color;
            $('.cm-navbar .btn').addClass(btn_cc);
        });

        $("body").addClass("cm-1-navbar");
    });
</script>