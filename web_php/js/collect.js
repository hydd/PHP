$(document).ready(function () {
    $(".collect").click(function () {
        var abc = $(this);
        var pid = $(this).data("id");
        var type = $(this).data("type");
        // alert(type);
        $.post("collect.php", {
            x: pid,
            t: type
        }, function (data) {
            // alert(data);
            if (data == "success") {
                alert("收藏成功！");
                $(abc).removeClass("btn-default");
                $(abc).addClass("btn-primary"); 
                $(abc).data("type", "del"); 
                $(abc).text("取消收藏");
            } else if (data == "") {
                alert("添加收藏失败，请检查");
                $(abc).text("收藏");
            } else if (data == "del") {
                alert("取消收藏成功！");
                $(abc).removeClass("btn-primary");
                $(abc).addClass("btn-default");   
                $(abc).data("type", "add"); 
                $(abc).text("收藏");
            } else if (data == "ndel") {
                alert("取消收藏失败，请检查");
                $(abc).text("取消收藏");
            }
        }, "text");

    });
    $(".mycollect").click(function () {
        var abc = $(this);
        var pid = $(this).data("id");
        var type = $(this).data("type");
        // alert(data);
        $.post("collect.php", {
            x: pid,
            t: type
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
    $(".changefavorite").click(function () {
        var abc = $(this);
        var fid = $(this).data("id");
        var type = $(this).data("type");
        // alert(fid);
        $.post("collect.php", {
            x: p_id,
            t: type,
            f: fid
        }, function (data) {
            // alert(data);
            if (data == "changed") {
                alert("修改成功！");
                $(prod).parent().siblings().hide();
                $(prod).parent().hide();
                $('#myModal_2').modal('hide');
                // $(abc).text("收藏");
            } else if (data == "unchanged") {
                alert("修改失败，请刷新重试");
                // $(abc).text("取消收藏");
            }
        }, "text");
    });
    $(".favorite").click(function () {
        prod = $(this);
        p_id = $(this).data("id");
        // alert(id);
        // p_id = id;
    });
    $(".mycollections_m").change(function () {
        var sel = $(this);
        var id = $(this).data("id");
        // alert($(this).data("id"));
        // alert($(this).val());
        $.ajax({
            url: 'favoritesmanage.php',
            data: {
                fid: $(this).data("id"),
                faid: $(this).val()
            },
            type: 'post',
            success: function (output) {
                if (output == "ok") {
                    alert("修改成功");
                    $('#myModal_3').modal('hide');
                } else {
                    alert("修改失败，请刷新重试");
                    $('#myModal_3').modal('hide');
                }
            }
        });
    });
});
var p_id;
var prod;

function submitForm() {
    var form = document.getElementById("show_favorite");
    form.submit();
}

function submitForm_1() {
    var form = document.getElementById("show_favorite");
    form.submit();
}

function submitForm_m() {
    var form = document.getElementById("show_favorite");
    form.submit();
}