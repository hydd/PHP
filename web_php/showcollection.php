<?php
//                            _ooOoo_
//                           o8888888o
//                           88" . "88
//                           (| -_- |)
//                            O\ = /O
//                        ____/`---'\____
//                      .   ' \\| |// `.
//                       / \\||| : |||// \
//                     / _||||| -:- |||||- \
//                       | | \\\ - /// | |
//                     | \_| ''\---/'' | |
//                      \ .-\__ `-` ___/-. /
//                   ___`. .' /--.--\ `. . __
//                ."" '< `.___\_<|>_/___.' >'"".
//               | | : `- \`.;`\ _ /`;.`/ - ` : | |
//                 \ \ `-. \_ __\ /__ _/ .-` / /
//         ======`-.____`-.___\_____/___.-`____.-'======
//                            `=---='
//
//         .............................................
//                  佛祖保佑             永无BUG
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

    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
    <script src="./js/collect.js?v=1"></script>

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

<form align="center" name="form_favorite" action="favoritesmanage.php" method="post">
    <div id ="myModal_1" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" align="center">创建新收藏夹</h4>
        </div>
        <div class="modal-body" align="center">
            <input type="text" class="form-control" id="title" name="title" value="" style="width:90%" placeholder="收藏标题"></input>
        </div>
        <div class="modal-body" align="center">
        <textarea id="info" class="form-control" name="info" rows="5" style="width:90%" placeholder="收藏描述（可选）"></textarea>
        </div>
        <div align="center">
            <button type="submit" class="createfavorite btn btn-primary" name="create_favorite"><h5>创建</h5></button>
            <button type="button" class="btn btn-default col-md-offset-1" data-dismiss="modal"><h5>关闭</h5></button>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <tr></tr>
    </div><!-- /.modal -->

    <div id ="myModal_2" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" align="center">选择收藏夹</h4>
        </div>
        <div class="modal-body" align="center">

            <table class="table table-hover">
                    <div align="center">
                        <?php
include_once "favoritesbean.php";
$collectioninfo = getAllCollectTypeInfo();
echo "<tr><th>" . "ID" . "</th><th>" . "名称" . "</th><th>" . "简介" . "</th><th>" . "</th><tr>";
foreach ($collectioninfo as $info) {
    echo "<tr><td>" . $info[0] . "</td><td>" . $info[1] . "</td><td>" . $info[2] . "</td><td>";
    $coltype = $_POST['mycollections'] == "" ? 2 : $_POST['mycollections'];
    if ($coltype == $info[0]) {
        echo "<button type='button' class='changefavorite btn btn-primary' data-type='change' data-id='" . $info[0] . "' disabled='disabled'>当前收藏夹</button></td></tr>";
    } else {
        echo "<button type='button' class='changefavorite btn btn-default' data-type='change' data-id='" . $info[0] . "'>选择</button></td></tr>";
    }
}
?>
                    </div>
                    </tr>
                </table>
        </div>
        <div align="center">
            <!-- <button type="submit" class="btn btn-primary" name="change_favorite"><h5>确定</h5></button> -->
            <button type="button" class="btn btn-default col-md-offset-1" data-dismiss="modal"><h5>返回</h5></button>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <tr></tr>
    </div><!-- /.modal -->

    <div id ="myModal_3" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" align="center">管理收藏夹</h4>
        </div>
        <div class="modal-body" align="center">

            <table class="table table-hover">
                    <div align="center">
                        <?php
include_once "favoritesbean.php";
$collectioninfo = getAllCollectTypeInfo();
echo "<tr><th>" . "ID" . "</th><th>" . "名称" . "</th><th>" . "简介" . "</th><th>" . "修改父收藏夹" . "</th><tr>";
foreach ($collectioninfo as $info) {
    echo "<tr><td>" . $info[0] . "</td><td>" . $info[1] . "</td><td>" . $info[2] . "</td><td>";
    // $coltype = $_POST['mycollections'] == "" ? 2 : $_POST['mycollections'];
    // if ($coltype == $info[0]) {
    //     echo "<button type='button' class='changefavorite btn btn-primary' data-type='change' data-id='" . $info[0] . "' disabled='disabled'>当前收藏夹</button></td></tr>";
    // } else {
    //     echo "<button type='button' class='changefavorite btn btn-default' data-type='change' data-id='" . $info[0] . "'>选择</button></td></tr>";
    // }
    echo "<select class='form-control' name='mycollections_m' onchange='submitForm_m();'>";
    include_once "favoritesbean.php";
    $types = getCollectTypeInfo(1);
    foreach ($types as $type) {
        if ($info[0] == $type[0]) {
            echo "<option value=$type[0] selected='selected'>" . $type[1] . "</option>";
        } else {
            echo "<option value=$type[0]>" . $type[1] . "</option>";
        }
    }
    echo "</select>";

}
?>
                    </div>
                    </tr>
                </table>
        </div>
        <div align="center">
            <!-- <button type="submit" class="btn btn-primary" name="change_favorite"><h5>确定</h5></button> -->
            <button type="button" class="btn btn-default col-md-offset-1" data-dismiss="modal"><h5>返回</h5></button>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <tr></tr>
    </div><!-- /.modal -->
</form>

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
            <label for="inputText3" class="col-md-2  control-label">收藏夹</label>
            <!-- <div class="col-md-2"></div> -->
<form align="center" name="show_favorite" id="show_favorite" action="showcollection.php" method="post">

            <div class="col-md-2">
            <select class="form-control" name="mycollections" onchange="submitForm();">
                <?php
include_once "favoritesbean.php";
$types = getCollectTypeInfo(1);
foreach ($types as $type) {
    // unset($_POST['mycollections_1']);
    if ($_POST['mycollections'] == $type[0]) {
        echo "<option value=$type[0] selected='selected'>" . $type[1] . "</option>";
    } else {
        echo "<option value=$type[0]>" . $type[1] . "</option>";
    }

}
?>
                </select>
            </div>

            <?php
if (isFather($_POST['mycollections'])) {
    echo "<div class='col-md-2'>";
    echo "<select class='form-control' name='mycollections_1' onchange='submitForm_1();'>";
    include_once "favoritesbean.php";
    $types = getCollectTypeInfo($_POST['mycollections']);
    echo "<option value=null>" . getNameById($_POST['mycollections']) . ": </option>";
    foreach ($types as $type) {
        if ($_POST['mycollections_1'] == $type[0]) {
            echo "<option value=$type[0] selected='selected'>" . $type[1] . "</option>";
        } else {
            echo "<option value=$type[0]>" . $type[1] . "</option>";
        }
        echo "</select></div>";
    }
} else {
    echo "<div class='col-md-2'></div>";
}
?>
            <?php
if (isFather($_POST['mycollections_1'])) {
    echo "<div class='col-md-2'>";
    echo "<select class='form-control' name='mycollections_2' onchange='submitForm_1();'>";
    include_once "favoritesbean.php";
    $types = getCollectTypeInfo($_POST['mycollections_1']);
    echo "<option value=null>" . getNameById($_POST['mycollections_1']) . ": </option>";
    foreach ($types as $type) {
        if ($_POST['mycollections_2'] == $type[0]) {
            echo "<option value=$type[0] selected='selected'>" . $type[1] . "</option>";
        } else {
            echo "<option value=$type[0]>" . $type[1] . "</option>";
        }
        echo "</select></div>";
    }
} else {
    echo "<div class='col-md-2'></div>";
}
?>
</form>

            <div>
                <button type="butthon" class = "btn btn-default sm" data-toggle="modal" data-target="#myModal_1">创建新收藏夹</button>
                <button type="butthon" class = "btn btn-default sm" data-toggle="modal" data-target="#myModal_3">管理收藏夹</button>
            </div>
        </div>
        <br></br>
                <table class="table table-hover">
                    <div align="center">
                        <?php
if (isset($_POST['mycollections_1']) && $_POST['mycollections_1'] != "") {
    $fid_1 = $_POST['mycollections_1'];
}
if (isset($_POST['mycollections']) && $_POST['mycollections'] != "") {
    $fid_0 = $_POST['mycollections'];
    if (isset($fid_1) && isSon($fid_0, $fid_1)) {
        $fid = $fid_1;
    } else {
        $fid = $fid_0;
    }
} else {
    $fid = 2;
}
// echo $fid;
getPid($fid);
?>
                    </div>
                    </tr>
                </table>
    </div>
</body>

</html>