<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>车票首页</title>

    <link rel="stylesheet" type="text/css" href="<?php echo WEIXIN_ASSETS;?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEIXIN_ASSETS;?>fonts/ionicons-2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo WEIXIN_ASSETS;?>plugins/swiper/css/swiper.min.css" type="text/css">
    <!-- weui -->
    <link rel="stylesheet" type="text/css" href="<?php echo WEIXIN_ASSETS;?>plugins/weui/css/weui.min.css">

    <!-- custom styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo WEIXIN_ASSETS;?>css/styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo WEIXIN_ASSETS;?>css/new-styles.css">

    <script type="text/javascript" src="<?php echo WEIXIN_ASSETS;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo WEIXIN_ASSETS;?>js/bootstrap.min.js"></script>


    <script type="text/javascript" src="<?php echo WEIXIN_ASSETS;?>plugins/tmpl/tmpl.min.js"></script>


    <script type="text/javascript" src="<?php echo WEIXIN_ASSETS;?>plugins/swiper/js/swiper.jquery.min.js"></script>

</head>
<body>
<div class="weui-toptips weui-toptips_warn js_tooltips">请输入信息</div>
<div id="wrapper">
    <!--头部-->
    <div id="header">
        <div class="pull-left">

        </div>
        <div class="title">车票查询</div>
        <div class="pull-right user-center">

        </div>
    </div>

    <!-- 幻灯片 -->
    <!--<div id="" class="swiper-container" style="height: 220px;">
        &lt;!&ndash; Additional required wrapper &ndash;&gt;
        <div class="swiper-wrapper">

        </div>
        &lt;!&ndash; If we need pagination &ndash;&gt;
        <div class="swiper-pagination"></div>
    </div>-->


    <!--主菜单-->
    <!--<div id="main-menu" class="container">
        <div class="row">
            <div class="weui-grids">

            </div>
        </div>
    </div>-->

    <div class="weui-cells__title">请输入要查询的车票信息</div>
    <div class="weui-cells weui-cells_form">
        <form action="<?php echo U('Geek/ticket_details');?>" method="post" id="myform">
            <div class="weui-cell" id="startdiv">
                <div class="weui-cell__hd"><label class="weui-label">出发站</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" id="start" value="" name="originating" placeholder="请输入出发站">
                </div>
                <div class="weui-cell__ft" id="starthid" hidden>
                    <i class="weui-icon-warn"></i>
                </div>
            </div>
            <div class="weui-cell" id="enddiv">
                <div class="weui-cell__hd"><label class="weui-label">终点站</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" id="end" name="terminal" placeholder="请输入终点站">
                </div>
                <div class="weui-cell__ft" id="endhid" hidden>
                    <i class="weui-icon-warn"></i>
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label  class="weui-label">出发日期</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="date" name="time" value="">
                </div>
            </div>
            <!--<div class="weui-cell">
                <div class="weui-cell__hd"><label  class="weui-label">时间</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="datetime-local" value="" placeholder="">
                </div>
            </div>-->
        </form>
    </div>
    <!--最新车型
    <div class="lastest-news container">
        <div class="row" >
            <div class="weui-panel weui-panel_access">

            </div>
        </div>
    </div>-->
    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">确定</a>
    </div>


    <footer id="footer">
        <p class="weui-footer__links">
            <a href="javascript:void(0);" class="weui-footer__link">YZQ测试号</a>
        </p>
        <p class="weui-footer__text">Copyright &copy; 2016-2017 vx.fastt.cn</p>
    </footer>

    <!-- <div id="push"></div> -->
</div><!--/end wrapper-->
<script type="text/javascript">
    $(function(){
        var $tooltips = $('.js_tooltips');

        $('#showTooltips').on('click', function(){
            if ($.trim($('#start').val()) == '') {
                $tooltips.css('display', 'block');
                $('#startdiv').addClass('weui-cell_warn');
                $('#starthid').prop('hidden',false);
                setTimeout(function () {
                   $tooltips.css('display', 'none');
                }, 2000);
            } else {
                $('#startdiv').removeClass('weui-cell_warn');
                $('#starthid').prop('hidden',true);
            }

            if ($.trim($('#end').val()) == '') {
                $tooltips.css('display', 'block');
                $('#enddiv').addClass('weui-cell_warn');
                $('#endhid').prop('hidden',false);
                setTimeout(function () {
                    $tooltips.css('display', 'none');
                }, 2000);
            } else {
                $('#enddiv').removeClass('weui-cell_warn');
                $('#endhid').prop('hidden',true);
            }

            if ($tooltips.css('display') == 'none') {
                myform.submit();
            } else {
                return false;
            }

            // toptips的fixed, 如果有`animation`, `position: fixed`不生效
            //$('.page.cell').removeClass('slideIn');

            //
            //setTimeout(function () {
            //    $tooltips.css('display', 'none');
            //}, 2000);
        });
    });
</script>
</body>
</html>