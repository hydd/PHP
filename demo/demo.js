function checkSubmit() {
    var a = document.getElementById("password");
    if ("undefined " != typeof a) {
        if ("67d709b2b54aa2aa648cf6e87a7114f1" == a.value)
            return !0;
        alert("Error");
        a.focus();
        return !1
    }
}
document.getElementById("levelQuest").onsubmit = checkSubmit;