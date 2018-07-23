<?php 
    header("Content-Type: text/html; charset=utf8");

    if(!isset($_POST['submit'])){
        exit("错误执行");
    }//判断是否有submit操作

    $name=$_POST['name'];//post获取表单里的name
    $password=$_POST['password'];//post获取表单里的password

    include('connect.php');//链接数据库
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $q="insert into user(id,username,password) values (null,'$name','$password')";//向数据库插入表单传来的值的sql   
    //查询
    $result = $con -> query($q);
   
    if (!$result){
        die(mysqli_error());//如果sql执行失败输出错误
    }else{
        echo "注册成功";//成功输出注册成功
        header("refresh:0;url=login.html");//如果成功跳转至登陆页面
        exit;
    }

    

    mysqli_close($con);//关闭数据库

?>