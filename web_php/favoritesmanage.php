<?php
if (isset($_POST["create_favorite"])) {
    $title = $_POST['title'];
    $info = $_POST['info'];
    include_once "favoritesbean.php";
    if ($title == "") {
        echo "<script>alert('请检查输入！'); history.go(-1);</script>";
        exit();
    }
    if (!isFavorite($title)) {
        if (createNewFavorite($title, $info)) {
            // $('#myModal_2').modal('hide');
            echo "<script>alert('创建成功！'); history.go(-1);</script>";
            // echo "ok";
        } else {
            echo "<script>alert('创建失败，请重试！'); history.go(-1);</script>";
        }
    } else {
        // echo "have";
        echo "<script>alert('收藏夹已存在，请重试！'); history.go(-1);</script>";
    }
}
if (isset($_POST['fid']) && !empty($_POST['fid']) && isset($_POST['faid']) && !empty($_POST['faid'])) {
    include_once "favoritesbean.php";
    if (updateFavorites($_POST['fid'], $_POST['faid'])) {
        echo "ok";
    }
}
if (isset($_POST['collection_id']) && !empty($_POST['collection_id'])) {
    include_once "favoritesbean.php";
    showFavCha($_POST['collection_id']);
}

if (isset($_POST['getTree']) && !empty($_POST['getTree'])) {
    include_once "favoritesbean.php";
    getTreeFav(3);
    // showFavCha($_POST['collection_id']);
}
