$(document).ready(function () {
    $(".collect").click(function () {
        var abc = $(this);
        var id = $(this).data("id");
        // alert(data);
        $.post("collect.php", {
            x: id
        }, function (data) {
            // alert(data);
            if (data == "success") {
                alert("收藏成功！");
                $(abc).removeClass("btn-default");
                $(abc).addClass("btn-primary");   
                $(abc).text("取消收藏");
            } else if (data == "") {
                alert("添加收藏失败，请检查");
                $(abc).text("收藏");
            } else if (data == "del") {
                alert("取消收藏成功！");
                $(abc).removeClass("btn-primary");
                $(abc).addClass("btn-default");   
                $(abc).text("收藏");
            } else if (data == "ndel") {
                alert("取消收藏失败，请检查");
                $(abc).text("取消收藏");
            }
        }, "text");

    });
    $(".mycollect").click(function () {
        var abc = $(this);
        var id = $(this).data("id");
        // alert(data);
        $.post("collect.php", {
            x: id
        }, function (data) {
            // alert(data);
            if (data == "del") {
                alert("取消收藏成功！");
                $(abc).parent().siblings().hide();
                $(abc).parent().hide();
                $(abc).text("收藏");
            } else if (data == "ndel") {
                alert("取消收藏失败，请检查");
                $(abc).text("取消收藏");
            }
        }, "text");

    });
});