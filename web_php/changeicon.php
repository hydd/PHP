<?php
session_start();
if (isset($_POST['sub'])) {
    $img = $_POST['test'];
    // echo "<br>" . $base64_image_content . "----php变量显示";
    if ($img == "") {
        echo "<script>alert('请先进行预览！'); history.go(-1);</script>";
    } else {
        saveimg($img);
        // updateiconpath("1323r432431");
    }
}
function saveimg($base64_image_content)
{
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
        $type = $result[2];
        $path = "icons/";
        if (!file_exists($path)) {
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($path);
        }
        $new_file = $path . geticonpath($type);
        // echo $new_file;
        $file1 = (strpos($new_file, "/"));
        // echo strpos($new_file,"/");
        $file2 = (strpos($new_file, "."));
        // echo strpos($new_file,".");
        $filepath = substr($new_file, $file1 + 1, $file2 - 1);
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
            header("refresh:0;url=personalinfo.php");
            echo '保存成功';
            updateiconpath($filepath);
            // return true;
        } else {
            header("refresh:10;url=personalinfo.php");
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
    if ($row != "") {
        // echo $row['icon'];
        return $row['icon'];
    } else {
        $path = time() . "{$type}";
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
    if (!$reslut) {
        echo "失败";
    } else {
        echo "成功";
    }
}
