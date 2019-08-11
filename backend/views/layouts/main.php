<?php

use yii\helpers\Html;

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="resources/css/bootstrap-clearmin.min.css">
        <link rel="stylesheet" type="text/css" href="resources/css/roboto.css">
        <link rel="stylesheet" type="text/css" href="resources/css/material-design.css">
        <link rel="stylesheet" type="text/css" href="resources/css/small-n-flat.css">
        <link rel="stylesheet" type="text/css" href="resources/css/font-awesome.min.css">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script type="text/javascript" src="resources/js/lib/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="resources/js/common.js"></script>
    </head>
    <body class="cm-no-transition">
    <?php $this->beginBody() ?>
    <div id="cm-menu">
        <nav class="cm-navbar cm-navbar-primary">
            <div class="cm-flex" style="font-size:3rem;text-align: center;line-height: 50px;color:#e1e1e1">PyBlog</div>
            <div class="btn btn-primary md-menu-white" data-toggle="cm-menu"></div>
        </nav>
        <div id="cm-menu-content">
            <div id="cm-menu-items-wrapper">
                <div id="cm-menu-scroller">
                    <ul class="cm-menu-items">
                        <li class="active"><a href="?" class="sf-house">Home</a></li>
                        <?php
                        if (empty($this->context->menu)) {
                        } else {
                            foreach ($this->context->menu as $menu) {
                                $route = empty($menu['route']) ? 'javascript:;' : '?r=' . $menu['route'];
                                ?>

                                <?php if (empty($menu['sub'])) { ?>
                                    <li><a href="<?= $route ?>" class="<?= $menu['style'] ?>"><?= $menu['name'] ?></a>
                                    </li>
                                <?php } else { ?>
                                    <li class="cm-submenu">
                                        <a class="<?= $menu['style'] ?>"><?= $menu['name'] ?> <span
                                                    class="caret"></span></a>
                                        <ul>
                                            <?php
                                            foreach ($menu['sub'] as $sub) {
                                                $route = empty($sub['route']) ? 'javascript:;' : '?r=' . $sub['route'];
                                                ?>
                                                <li><a href="<?= $route ?>"><?= $sub['name'] ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php }

                            }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <header id="cm-header">
        <nav class="cm-navbar cm-navbar-primary">
            <div class="btn btn-primary md-menu-white hidden-md hidden-lg" data-toggle="cm-menu"></div>
            <div class="cm-flex">
                <h1>Home</h1>
                <form id="cm-search" action="index.html" method="get">
                    <input type="search" name="q" autocomplete="off" placeholder="Search...">
                </form>
            </div>
            <div class="pull-right">
                <div id="cm-search-btn" class="btn btn-primary md-search-white" data-toggle="cm-search"></div>
            </div>
            <div class="dropdown pull-right">
                <button class="btn btn-primary md-account-circle-white" data-toggle="dropdown"></button>
                <ul class="dropdown-menu">
                    <li class="disabled text-center">
                        <a style="cursor:default;"><strong>Test</strong></a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> 个人资料</a>
                    </li>
                    <!--
                    <li>
                        <a href="#"><i class="fa fa-fw fa-cog"></i> 设置</a>
                    </li>
                    !-->
                    <li>
                        <a href="?r=auth/logout"><i class="fa fa-fw fa-sign-out"></i> 安全退出</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div id="global">
        <?= $content ?? '' ?>
        <?php $this->endBody() ?>
        <footer class="cm-footer"><span class="pull-left">我是有底线的.</span><span class="pull-right">&copy; 2019 yu</span>
        </footer>
    </div>
    </body>
    <script src="resources/js/jquery.mousewheel.min.js"></script>
    <script src="resources/js/jquery.cookie.min.js"></script>
    <script src="resources/js/fastclick.min.js"></script>
    <script src="resources/js/bootstrap.min.js"></script>
    <script src="resources/js/clearmin.min.js"></script>
    <script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
    </html>
<?php $this->endPage() ?>