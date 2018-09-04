$(document).ready(function () {
    $.post("showinvitioninfo.php", {}, function (data) {
        var index = data.indexOf("table");
        // alert(index);
        $("#invitioninfo").html(data.substring(0, index - 1));
        $("#sons").html(data.substring(index - 1));
        // $("#sons").html(data);
    });
});