$(document).ready(function () {
    $(".share").click(function () {
        $.get("sharelink.php", function (data) {
            alert(data);
        }, "text");

    });
});