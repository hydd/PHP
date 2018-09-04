$(document).ready(function () {
    $.post("personalInfo.php", function (data) {
        // alert(data);
        $("#showmyinfo").html(data);
    });
});