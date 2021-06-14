<?php
/**
 * Created by PhpStorm.
 * User: hh
 * Date: 2021/6/8
 * Time: 18:25
 */
include_once "handle_function.php";
include_once 'main_index.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="main_index.css">
    <style>
        /*初始化*/
        * {
            margin: 0;
            padding: 0;
        }

        body {
            color: #666666;
            font: 13px "微软雅黑", "Lucida Grande", STHeiti, Verdana, Arial, Times, serif;
            background: url("data:image/gif;base64,R0lGODlhBwAGAKIAAAAAAP///8nJycjIyLm5ubi4uP///wAAACH5BAEAAAYALAAAAAAHAAYAAAMQOCOiTaREVmpU0C6pR8xDAgA7") repeat;
        }

        /*页面架构布局*/
        .container {

            margin: 2% 5%;
            width: 80vw;
            height: 220vh;
            display: grid;
            grid-template-areas: 'header header ' 'nav  main ' 'tfoot tfoot';
            grid-template-rows: 6% 86% 8%;
            grid-template-columns: 20% 80%;
            grid-row-gap: 2%;
            grid-column-gap: 2%;

        }

        .header {
            width: 88vw;

            position: fixed;
            /*position: fixed;*/
            /*width: 82%;*/
            /*height: 10%;*/
            display: grid;
            grid-area: header;
            background-color: rgba(177, 177, 177, 0.48);
            border-radius: 8px;
            box-shadow: 2px 4px rgba(177, 177, 177, 0.48);
            grid-template-areas: 'a b c';
            grid-template-rows: 100%;
            grid-template-columns: 30% 40% 30%;
            grid-gap: 1%;
            z-index: 12220;
        }



        .nav {
            grid-area: nav;
            background-color: rgba(177, 177, 177, 0.48);
            border-radius: 8px;
            box-shadow: 2px 4px rgba(177, 177, 177, 0.48);
            background-color: #82e0d3;
        }

        .main {
            grid-area: main;
            background-color: rgba(177, 177, 177, 0.48);
            border-radius: 8px;
            box-shadow: 2px 4px rgba(177, 177, 177, 0.48);
        }

        .tfoot {
            width: 90vw;
            grid-area: tfoot;
            background-color: rgba(84, 178, 219, 0.31);
            border-radius: 8px;
            box-shadow: 2px 4px rgba(177, 177, 177, 0.48);
        }

        /*头部样式设计  */
        .header div {
            border-radius: 8px;
        }

        /*1 .标题样式设计*/
        .header .title {
            grid-area: a;
            background-color: #357EBD;
            color: white;
            font-size: 2rem;
            text-align: center;
            padding: 2%;
        }

        /*2 .search样式布局*/
        .header .search {
            grid-area: b;
            background-color: #38bd8e;

        }

        /*搜索表单*/
        .header .search form {
            display: grid;
            width: 100%;
            height: 100%;
            grid-template-areas: 'search_form search_btn';
            grid-template-rows: 100%;
            grid-template-columns: 80% 20%;

        }

        /*搜索框*/
        .header .search form .search_form {
            grid-area: search_form;
            padding-left: 2%;
            border-radius: 8px 0 0 8px;
            font-size: 1.2rem;
            outline: none;
            border: none;
            background-color: #50bd8d;
        }

        .header .search form .search_form:hover {
            background-color: rgba(51, 51, 51, 0.43);
            color: white;
        }

        /*搜索框提示效果*/
        .header .search form .search_form:hover::-webkit-input-placeholder {
            color: #f4f4f4;
        }

        /*搜索按钮*/
        .header .search form .search_btn {
            grid-area: search_btn;
            border-radius: 0 8px 8px 0;
            font-size: 1.2rem;
            outline: none;
            border: none;
            background-color: #c04e3f;
        }

        .header .search form .search_btn:hover {
            background-color: rgba(51, 51, 51, 0.43);
            color: #f4f4f4;

        }

        /* 3 .用户显示页面*/
        .header .user {
            grid-area: c;
            background-color: #bda642;
            color:#f4f4f4;
            text-align: center;
            font-size: 1.2rem;
            padding-top: 10px;
            letter-spacing: 3px;
        }


        /*nav布局样式*/
        /*初始化a标签*/
        .nav .menus a {
            text-decoration: none;
            color: #333333;
        }

        /*初始化ul样式*/
        .nav .menus {
            list-style: none;
        }

        .nav .menus li {
            line-height: 30px;
            text-align: center;
            margin: 10% 25%;
            border-radius: 8px;
            border: 1px solid rgba(205, 139, 117, 0.80);
            box-shadow: 1px 2px rgba(205, 139, 117, 0.80);
            background-color: rgba(205, 139, 117, 0.80);

        }

        /*鼠标触摸样式*/
        .nav .menus li:hover {
            border: 1px solid rgba(205, 139, 117, 0.50);
            box-shadow: 1px 2px rgba(205, 139, 117, 0.50);
            background-color: rgba(205, 139, 117, 0.50);
        }

        /*tfoot样式处理*/
        .tfoot .bottom1 {
            width: 100%;
            padding-top: 20px;
            text-align: center;
        }


    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <?php
        include_once 'message_config.php';
        ?>

            <div class="title"><?php echo title ?></div>
            <div class="search">
                <form method="get" target="_blank onsubmit=" return CheckPost();
                ">
                <input type="text" placeholder="例如:十年 陈奕迅" name="ac" id="ac" class="search_form">
                <input type="submit" value="搜索" class="search_btn">
                </form>

            </div>

        <div class="user"><?php echo USER?></div>

    </div>

    <div class="nav">

        <ul class="menus">

            <li class="m_nav"><a class="sliding_menu" target="_blank" href="?p=1">歌曲列表</a></li>
            <!--            <li class="m_nav"><a class="sliding_menu" target="_blank" href="?p=1">恋爱歌曲</a></li>-->
            <li class="m_nav"><a class="sliding_menu" target="_blank" href="?p=2">top排行</a></li>
            <li class="m_nav"><a class="sliding_menu" target="_blank" href="?p=3">DJ舞曲</a></li>
            <li class="m_nav"><a class="sliding_menu" target="_blank" href="?m=1">MV视频</a></li>
        </ul>


    </div>
    <div class="main">
        <?php
        echo $main;
        ?>
    </div>

    <div class="tfoot">
        <div class="bottom1">
            <p>本网站的资源均使用API接口实现，如有侵权请及时联系我们</p>
            <p>
                <script language="javascript">var datatime = new Date();
                    document.write("&copy; " + datatime.toLocaleString());</script>
            </p>
            <?php
            echo title . "&nbsp&nbsp&nbsp" . "QQ:" . "&nbsp&nbsp" . QQ;
            ?>
        </div>
    </div>

</div>
</body>
</html>