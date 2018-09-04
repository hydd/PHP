$(document).ready(function () {
    $(".collect").click(function () { //商品展示界面收藏功能
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

    // $(".mycollect").click(function () {
    $(document).on('click', '#products .mycollect', function () { //个人收藏界面功能管理
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
    $(document).on('click', '#myModal_2_table .changefavorite', function () { //更换收藏家
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
    $(document).on('click', '#products .favorite', function () { //修改物品所属收藏夹模态框显示
        prod = $(this);
        p_id = $(this).data("id");
        // alert(p_id);
        // p_id = id;
        $.post("favoritesmanage.php", {
            collection_id: p_id
        }, function (data) {
            // alert(data);
            $('#myModal_2_table').html(data);
            $('#myModal_2').modal('show');
        });
    });
    $(".mycollections_m").change(function () { //管理收藏夹关系
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
    $("#mycollections").change(function () { //展示我的收藏
        $.post("dataprocessing.php", {
            fid: $(this).val()
        }, function (data) {
            // alert(data);
            $("#products").html(data);
        });
    });
    $.post("favoritesmanage.php", { //返回收藏家
        getTree: "tree"
    }, function (data) {
        treedata = data;
        // alert(data);
        showTree(data);
        // $("#products").html(data);
    });
    $.post("dataprocessing.php", {
        fid: 2
    }, function (data) {
        // alert(data);
        $("#products").html(data);
    });
});
var p_id;
var prod;
var treedata;

function showTree(treedata) {
    $('#treeview').treeview({
        color: "#428bca",
        levels: 0,
        expandIcon: 'glyphicon glyphicon-chevron-right',
        collapseIcon: 'glyphicon glyphicon-chevron-down',
        nodeIcon: 'glyphicon glyphicon-bookmark',
        onhoverColor: 'AliceBlue',
        // selectedColor: 'red', //设置被选择节点的字体、图标颜色
        data: treedata,
        onNodeSelected: function (event, data) {
            // alert(data.text);
            var name = data.text;
            // alert(name);
            setTimeout(function () {
                $('#treeview').treeview('collapseAll', {
                    silent: true
                });
            }, 100);
            $.post("dataprocessing.php", {
                    favname: name
                },
                function (data) {
                    $("#products").html(data);
                })
        }
    });
}

function submitForm() {
    var form = document.getElementById("sort_choose");
    form.submit();
}
