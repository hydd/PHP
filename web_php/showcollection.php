<?php
include "dataprocessing.php";
if (!isLogin()) {
    header("refresh:1;url=login.html"); //如果成功跳转至商品页面
}
?>

<!DOCTYPE html>
<html lang="en">
<html xmlns:wb="http://open.weibo.com/wb">

<head>
    <meta charset="utf-8">
    <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="./js/share.js?v=2"></script>
    <title>心愿单</title>
    <!-- Bootstrap core CSS -->

    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
    <script language="JavaScript">
    </script>

</head>

<body>
    <div id ="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">分享我的心愿单</h4>
        </div>
        <div class="modal-body">
            <p>请将以下链接分享给您的好友。</p>
            <input type="text" id="input" value="" style="width:75%" readonly></input>
            <button class="btn btn-default" onclick="copyUrl()">点击复制链接</button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div id ="myModal_1" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" align="center">创建新收藏夹</h4>
        </div>
        <div class="modal-body" align="center">
            <input type="text" class="form-control" id="title" value="" style="width:90%" placeholder="收藏标题"></input>
        </div>
        <div class="modal-body" align="center">
        <textarea id="info" class="form-control" rows="5" style="width:90%" placeholder="收藏描述（可选）"></textarea>
        </div>
        <div align="center">
            <button type="button" class="btn btn-primary" onclick="copyUrl()"><h5>创建</h5></button>
            <button type="button" class="btn btn-default col-md-offset-1" data-dismiss="modal"><h5>关闭</h5></button>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <tr></tr>
    </div><!-- /.modal -->


    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <h1 align="center">我的收藏</h1>
            <a href="products.php?type=1" style="font-size:8" class="">全部商品</a>
            <a href='personalInfo.php' style="font-size:8" class="col-md-offset-10">个人主页</a>
            <!-- <p>This is a template showcasing the optional theme stylesheet included in Bootstrap. Use it as a starting point to create something more unique by building on or modifying it.</p> -->
        </div>

        <div class="page-header">
        <button type="button" class='share btn btn-default col-md-offset-10' data-toggle="modal" data-target="#myModal">点击分享我的心愿单</button></td><td>
        </div>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">

            <div class="form-group">
            <label for="inputText3" class="col-md-3 col-md-offset-1 control-label">收藏夹</label>
            <!-- <div class="col-md-2"></div> -->
            <div class="col-md-4">
            <select class="form-control">
                <?php
include_once "invition.php";
$types = getCollectType();
foreach ($types as $type) {
    echo "<option>" . $type . "</option>";
}
?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="butthon" class = "btn btn-default col-md-offset-4" data-toggle="modal" data-target="#myModal_1">创建新收藏夹</button>
            </div>
        </div>
        <br></br>
                <table class="table table-hover">
                    <div align="center">
                        <?php
getPid();
?>
                    </div>
                    </tr>
                </table>
    </div>
</body>

</html>