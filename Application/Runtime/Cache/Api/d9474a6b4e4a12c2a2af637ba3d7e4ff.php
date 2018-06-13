<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>Geek主页</title>

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

<div id="wrapper">

    <!--头部-->
    <div id="header">
        <div class="title">GEEK</div>
    </div>

    <!-- 幻灯片 -->
    <div id="" class="swiper-container" style="height: 220px;">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <?php if(is_array($data)): $i = 0; $__LIST__ = array_slice($data,0,5,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
                    <img src="<?php echo ($list["thumbnail_pic_s"]); ?>">
                </div><?php endforeach; endif; else: echo "" ;endif; ?>

        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>
    </div>

    <!--最新geek-->
    <div class="lastest-news container">
        <div class="row">
            <div class="weui-panel weui-panel_access">
                <div class="weui-panel__hd">最新Geek</div>
                <div class="weui-panel__bd">
                    <?php if(is_array($data)): $i = 0; $__LIST__ = array_slice($data,0,10,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($vo["url"]); ?>" class="weui-media-box weui-media-box_appmsg">
                            <div class="weui-media-box__hd">
                                <img width="100" height="70" class="weui-media-box__thumb" src="<?php echo ($vo["thumbnail_pic_s"]); ?>">
                            </div>
                            <div class="weui-media-box__bd">
                                <!--<h4 class="weui-media-box__title"><?php echo ($vo["title"]); ?></h4>-->
                                <p class="weui-media-box__bd" style="font-size: 16px"><?php echo ($vo["title"]); ?></p>

                            </div>
                        </a><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>
    </div>


    <footer id="footer">
        <p class="weui-footer__links">
            <a href="javascript:void(0);" class="weui-footer__link">YZQ测试号</a>
        </p>
        <p class="weui-footer__text">Copyright &copy; 2016-2017 vx.fastt.cn</p>
    </footer>

    <!-- <div id="push"></div> -->
</div><!--/end wrapper-->

<style>
    .weui-grid__icon {
        width: 60px;
        height: 60px;
    }
    .weui-grids::before {
        border-top:none;
    }
    #main-menu {
        padding: 0 !important;
    }
    #main-menu .row {
        margin-bottom: 0 !important;
    }
</style>

<script type="text/javascript">
    $(document).ready(
            function() {

                $("#header").addClass("bordered-none");

                //initialize swiper when document ready
                var mySwiper = new Swiper('.swiper-container', {
                    // Optional parameters
                    //direction: 'vertical',
                    loop : true,
                    pagination : '.swiper-pagination',
                    paginationClickable : true,
                    height : 220,
                    lazyLoading : true,
                    preloadImages : ''
                });


                $(window).scroll(
                        function() {
                            if ($(window).scrollTop() == $(document).height()
                                    - $(window).height()) {
                                // ajax call get data from server and append to the div
                                $("#loading").show();
                            }
                        });

            });
</script>
</body>
</html>