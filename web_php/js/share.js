$(document).ready(function () {
    $(".share").click(function () {
        $.post("sharelink.php", function (data) {
            // document.getElementById("input").innerHTML = data;
            // alert(data);
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
    alert("复制成功！");
}