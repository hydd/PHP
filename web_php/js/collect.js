$(document).ready(function () {
    $(".collect").click(function () {
        var abc = $(this);
        var data = $(this).data("id");
        // alert(data);
        $.get("collect.php", {
            x: data
        }, function (data) {
            // alert(data);
            if (data == "success") {
                alert("收藏成功！");
                $(abc).text("取消收藏");
            } else if (data == "error") {
                alert("添加收藏失败，请检查");
                $(abc).text("收藏");
            } else if (data == "del") {
                alert("取消收藏成功！");
                $(abc).text("收藏");
            } else if (data == "ndel") {
                alert("取消收藏失败，请检查");
                $(abc).text("取消收藏");
            }
        }, "text");

    });
});