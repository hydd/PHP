/*
    表单验证
*/
var flag1 = false; // flag1 如果为true（即用户名合法）就允许表单提交， 如果为false（即用户名不合法）阻止提交
var flag2 = false; // 密码
var flag3 = false; //email
// 当鼠标聚焦于用户名
function focus_username() {
    // 找到后面的div, id = username
    var nameObj = document.getElementById("username");
    nameObj.innerHTML = "用户名不能包含特殊字符且为5~20位";
    nameObj.style.color = "#999";
}
// 当鼠标不聚焦于用户名input
function blur_username() {
    // 找到id=username的div
    var nameObj = document.getElementById("username");
    // 判断用户名是否合法
    var str2 = check_user_name(document.form1.name.value);
    nameObj.style.color = "red";

    if ("通过" == str2) {
        flag1 = true;
        nameObj.innerHTML = str2;
    } else {
        nameObj.innerHTML = str2;
    }
}
// 检查用户名是否合法        合法就返回"通过"
function check_user_name(str) {
    var str2 = "通过";
    if ("" == str) {
        str2 = "用户名为空";
        return str2;
    } else if ((str.length < 5) || (str.length > 20)) {
        str2 = "用户名必须为5 ~ 20位";
        return str2;
    } else if (!check_name_char(str)) {
        str2 = "不能含有特殊字符或中文";
        return str2;
    }
    return str2;
}
// 验证用户名是否含有特殊字符
function check_name_char(str) {
    var uPattern = /^[a-zA-Z0-9_-]{5,20}$/;
    return uPattern.test(str);
}

function focus_userpwd() {
    // 找到后面的div, id = password
    var nameObj = document.getElementById("password");
    nameObj.innerHTML = "密码不能包含特殊字符且大于5位";
    nameObj.style.color = "#999";
}

function blur_userpwd() {
    // 找到id=username的div
    var nameObj = document.getElementById("password");
    // 判断用户名是否合法
    var str2 = check_user_pwd(document.form1.password.value);
    nameObj.style.color = "red";
    if ("通过" == str2) {
        flag2 = true;
        nameObj.innerHTML = str2;
    } else {
        nameObj.innerHTML = str2;
    }
}

// 检查密码是否合法        合法就返回"通过"
function check_user_pwd(str) {
    var str2 = "通过";
    if ("" == str) {
        str2 = "密码为空";
        return str2;
    } else if ((str.length < 5)) {
        str2 = "密码必须大于5位";
        return str2;
    } else if (!check_pwd_char(str)) {
        str2 = "不能含有特殊字符";
        return str2;
    }
    return str2;
}

function check_pwd_char(str) {
    var uPattern = /^[a-zA-Z0-9_-]{4,}$/;
    return uPattern.test(str);
}

function focus_userpwd1() {
    var nameObj = document.getElementById("password1");
    nameObj.innerHTML = "两次密码需要相同";
    nameObj.style.color = "#999";
}

function blur_userpwd1() {
    var nameObj = document.getElementById("password1");
    // 判断用户名是否合法
    var str2 = check_user_pwd1(document.form1.password1.value);
    nameObj.style.color = "red";
    if ("通过" == str2) {
        flag2 = true;
        nameObj.innerHTML = str2;
    } else {
        nameObj.innerHTML = str2;
    }
}
// 检查密码是否合法        合法就返回"通过"
function check_user_pwd1(str) {
    var str2 = "通过";
    if (!check_pwd1_char(str)) {
        str2 = "请输入相同的密码";
        return str2;
    }
    return str2;
}

function check_pwd1_char(str) {
    var password = document.form1.password.value;
    if (str == password) {
        return true;
    } else {
        return false;
    }
}
// 根据验证结果确认是否提交
function check_submit() {
    //检查用户名_密码格式
    // document.write(flag1);
    // document.write(flag2);
    if (flag1 == true && flag2 == true) {
        return true;
    } else {
        return false;
    }
}

function check_pwd_submit() {
    //检查密码格式
    if (flag2 == true) {
        return true;
    } else {
        return false;
    }
}

function check_name_submit() {
    //检查用户名格式
    if (flag1 == true) {
        return true;
    } else {
        return false;
    }
}

function check_ne_submit() {
    //检查用户名_邮箱格式
    if (flag1 == true && flag2 == true) {
        return true;
    } else {
        return false;
    }
}

function check_npe_submit() {
    //检查用户名_密码_邮箱格式
    if (flag1 == true && flag2 == true && flag3 == true) {
        return true;
    } else {
        return false;
    }
}