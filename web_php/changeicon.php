<?php
session_start();
if (isset($_POST['sub'])) {
    $img = $_POST['test'];
    isimg($img);
}
function isimg($img)
{
    if ($img == "") {
        echo "<script>alert('请先选择头像！'); history.go(-1);</script>";
    } else {
        // 分割base64码，获取头部编码部分
        $headData = explode(';', $img);
        // print_r(explode(";", $img));
        // 再获取编码前原文件的后缀信息
        $postfix = explode('/', $headData[0]);
        // print_r($postfix[1]);
        $filetype = ['jpg', 'jpeg', 'gif', 'bmp', 'png'];
        if (!in_array($postfix[1], $filetype)) {
            echo "<script>alert('请选择正确的图片格式！'); history.go(-1);</script>";
        } else {
            saveimg($img);
        }
    }
}
function saveimg($base64_image_content)
{
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
        $type = $result[2];
        // echo "type" . $type;
        $path = "icons/";
        if (!file_exists($path)) {
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($path);
        }

        $new_file = $path . geticonpath($type);
        // echo "newfile " . $new_file;
        $file1 = (strpos($new_file, "/"));
        // echo strpos($new_file,"/");
        $file2 = (strpos($new_file, "."));
        // echo strpos($new_file,".");
        $filepath = substr($new_file, $file1 + 1, $file2 - 1);
        // echo "filepath" . $filepath;
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
            header("refresh:0;url=personalInfo.php");
            echo '保存成功';
            updateiconpath($filepath);
            // return true;
        } else {
            header("refresh:10;url=personalInfo.php");
            echo '保存失败';
            // return false;
        }
    }
}
function geticonpath($type)
{
    include "connect.php";
    $name = $_SESSION['name'];
    $sql = "select icon from user where username = '$name'";
    $reslut = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($reslut);
    if ($row[icon] != null) {
        // echo "row" . $row['icon'];
        return $row['icon'];
    } else {
        $path = time() . ".$type";
        // echo "path" . $path;
        return $path;
    }
}

function updateiconpath($path)
{
    include "connect.php";
    $name = $_SESSION['name'];
    // echo $name;
    $sql = "update user set icon = '$path' where username = '$name'";
    $reslut = mysqli_query($con, $sql);
    // if (!$reslut) {
    //     echo "失败";
    // } else {
    //     echo "成功";
    // }
}
