<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>车票详情页</title>

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

    <style>

        body {
            -webkit-text-size-adjust: 100%!important;
        }
        body, button, input, select, textarea {
            font: 14px/1.5 Arial,\5b8b\4f53;
        }

        a{
            margin-top: 5px !important;
            margin-bottom: 0;
        }
        .tableBox {
            padding: 12px 0 10px 0;
            border-bottom-right-radius: 4px;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px rgba(153,153,153,0.2);
            -webkit-box-shadow: 0 1px rgba(153,153,153,0.2);
        }
        .trainListTable {
            height: 50px;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        table {
            width: 100%;
            border-top-width: 0px;
            border-right-width: 0px;
            border-bottom-width: 0px;
            border-left-width: 0px;
            border-spacing: 0px;
        }
        tr {
            position: relative;
            height: 21px;
            line-height: 1em;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        tr:first-child td:first-child {
            font-size: 20px;
            color: #333;
            width: 26%;
            text-align: center;
        }
        tr:first-child td:nth-child(4) label {
            font-size: 12px;
            color: #ff6815;
            margin-right: 12px;
        }
        .traindatainfo table td {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }
        .train_checi {
            width: 27%;
        }
        .train_checi {
            font-size: 12px !important;
            left: 60px;
            text-align: center;
            position: relative;
            left: 0;
        }
        .rightArrow {
            width: 62px;
            height: 16px;
            background-position: -321px -136px;
            position: absolute;
            top: 13px;
            left: 50%;
            margin-left: -31px;
        }
        .icon-train-two {
            background-size: 320px;
            background-image: url(http://wx.40017.cn/touch/weixin/train/img/icon-train-two.png);
        }
        .atime {
            font-size: 20px;
            color: #333;
            text-align: center;
        }
        tr td:nth-child(4) {
            text-align: right;
            margin-right: 10px;
        }
        .traindatainfo table td {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }
        tr:first-child td:nth-child(4) label {
            color: #FF6540;
        }
        td{
            font-size: 15px !important;
        }
        /*element.style {
            font-size: 20px;
        }*/
        address, caption, cite, code, dfn, em, th, var {
            font-style: normal;
            font-weight: 500;
        }
        .train_haoshi {
            font-size: 12px !important;
        }
        .seats {
            line-height: 30px;
            font-size: 11px;
            color: #666;
            background-color: #f9f9f9;
            -webkit-border-bottom-right-radius: 4px;
            -webkit-border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            border-bottom-left-radius: 4px;
            margin-top: 1px;
            padding-left: 8px;
        }
        .seats .cheapcheat {
            margin-left: 12px;
        }
        .cheapcheat {
            top: 30px;
            right: 0;
            font-size: 11px;
        }
        label {
            cursor: default;
        }
        .cheapcheat {
            top: 30px;
            right: 0;
            font-size: 11px;
        }
        .traindatainfo {
            position: relative;
            width: 100%;
            font-size: 14px;
        }
        .fn-clear {
            background: #fff;
            margin: 5px;
            border-radius: 4px;
            box-shadow: 0 1px 1px 1px rgba(153,153,153,0.2);
            -webkit-box-shadow: 0 1px 1px 1px rgba(153,153,153,0.2);
            height: 103px;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        .red {
            color: #ed5565;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <!--头部-->
    <div id="header">
        <div class="pull-left">

        </div>
        <div class="title">车票详情</div>
        <div class="pull-right user-center">

        </div>
    </div>
    <div class="page__bd page__bd_spacing">
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><section class="fn-clear">
                <div class="traindatainfo">
                        <div class="tableBox">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="trainListTable">
                                <tbody>
                                <tr style="font-size: 12px !important;">
                                    <td class="btime" width="25%">
                                        <?php echo ($list["start_time"]); ?>
                                    </td>
                                    <td class="train_checi" width="25%">
                                        <?php echo ($list["train_no"]); ?>
                                        <span class="icon-train-two rightArrow"></span>
                                    </td>
                                    <td class="atime" width="25%">
                                        <?php echo ($list["end_time"]); ?>
                                    </td>
                                    <td rowspan="2" class="seatType" data-seattype="无座" width="25%">
                                        <?php if(count($list[price_list]) < 1): ?><label class="">
                                                <!--<span>&nbsp;</span>--><em
                                                    style="color:#999;font-size:12px">暂不发售</em>
                                            </label>
                                            <?php else: ?>
                                            <label class="minprice1">
                                                <!--<span>&nbsp;</span>--><em style="font-size:18px">¥<?php echo ($list["price_list"]["0"]["price"]); ?></em><em
                                                    style="color:#999;font-size:12px">起</em>
                                            </label><?php endif; ?>

                                    </td>
                                </tr>
                                <tr style="text-align: center">
                                    <td class="bplace"><?php echo ($list["start_station"]); ?></td>
                                    <td class="train_haoshi">
                                        <?php echo ($list["run_time"]); ?>
                                    </td>
                                    <td class="aplace"><?php echo ($list["end_station"]); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    <div class="seats">
                        <?php if(empty($list['price_list'])): ?><span class="cheapcheat" data-seattype="暂不发售">
                                    <label class="" style="color: #999">
                                        列车运行图调整
                                    </label>
                                </span>
                            <?php else: ?>
                            <?php if(is_array($list['price_list'])): $i = 0; $__LIST__ = $list['price_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$seats): $mod = ($i % 2 );++$i;?><span class="cheapcheat" data-seattype="硬座">
                                        <label class="">
                                            <?php echo ($seats["price_type"]); ?>
                                        </label>
                                        <!--(<label style="color:#000"><?php echo ($seats["remainNum"]); ?></label>)-->
                                            <label class="red">
                                                $<?php echo (intval($seats["price"])); ?>
                                            </label>
                                    </span><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </div>
                </div>
            </section><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>

    <footer id="footer">
        <p class="weui-footer__links">
            <a href="javascript:void(0);" class="weui-footer__link">YZQ测试号</a>
        </p>
        <p class="weui-footer__text">Copyright &copy; 2016-2017 vx.fastt.cn</p>
    </footer>

    <!-- <div id="push"></div> -->
</div><!--/end wrapper-->
</body>
</html>