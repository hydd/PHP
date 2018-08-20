$(document).ready(function () {
    // var type = share;
    $(".share").click(function () {
        $.post("sharelink.php", {
            type: "share"
        }, function (data) {
            var url = document.getElementById("input");
            $(url).val(data);
            // shareUrl = data;
        }, "text");

    });
    $(".invite").click(function () {
        // var type = inivite;
        $.post("sharelink.php", {
            type: "inivite"
        }, function (data) {
            var url = document.getElementById("input");
            $(url).val(data);
            // shareUrl = data;
        }, "text");

    });
});

function copyUrl() {
    var url = document.getElementById("input");
    url.select();
    document.execCommand("Copy");
    // alert("复制成功！");
}