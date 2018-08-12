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
function checkHex($img_path)
{
    if (file_exists($img_path)) {
        $resource = fopen($img_path, 'rb');
        $fileSize = filesize($img_path);
        fseek($resource, 0); //把文件指针移到文件的开头
        if ($fileSize > 512) { // 若文件大于521B文件取头和尾
            $hexCode = bin2hex(fread($resource, 512));
            fseek($resource, $fileSize - 512);
            $hexCode .= bin2hex(fread($resource, 512));
        } else { // 取全部
            $hexCode = bin2hex(fread($resource, $fileSize));
        }
        // $hexCode = bin2hex(fread($resource, $fileSize));
        fclose($resource);
        /* 匹配16进制中 <?php ?>|eval|fputs|fwrite */
        // if (!preg_match("/(3c3f706870.*?3f3e)|(6576616c)|(6670757473)|(667772697465)/is", $hexCode))
        if (!preg_match("/(3c25.*?28.*?29.*?253e)|(3c3f.*?28.*?29.*?3f3e)|(3C534352495054)|(2F5343524950543E)|(3C736372697074)|(2F7363726970743E)/is", $hexCode)) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}
function saveimg($base64_image_content)
{
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
        $type = $result[2];
        // echo "type" . $type;
        // $path = "icons/";
        $path = "temp/";
        if (!file_exists($path)) {
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($path);
        }
        $old_path = geticonpath($type);
        $new_file = $path . time() . ".$type";
        // echo "newfile " . $new_file;
        $file1 = (strpos($new_file, "/"));
        // echo strpos($new_file,"/");
        $file2 = (strpos($new_file, "."));
        // echo strpos($new_file,".");
        $filepath = substr($new_file, $file1 + 1, $file2 - 1);
        // echo "filepath" . $filepath;
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
            // echo '保存成功';
            if (checkHex($new_file)) {
                $icon_path = "icons/";
                $icon = $icon_path . $old_path;
                // echo $icon;
                rename($new_file, $icon);
                updateiconpath($old_path);
                header("refresh:0;url=personalInfo.php");
                // echo "ok";
            } else {
                unlink($new_file);
                echo "<script>alert('保存失败，请选择正确的图片！'); history.go(-1);</script>";
                // echo "no";
            }
            // return true;
        } else {
            echo "<script>alert('保存失败，请选择正确的图片！'); history.go(-1);</script>";
            // header("refresh:10;url=personalInfo.php");
            // echo '保存失败';
            // return false;
        }
    }
}
function geticonpath($type)
{
    include "connect.php";
    $name = $_SESSION['name'];
    // $sql = "select icon from user where username = '$name'";
    $sql = "select icon from user where username = ?";

    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();

    $stmt->bind_result($icon);

    if ($stmt->fetch()) {
        if ($icon != "") {
            return $icon;
        } else {
            return time() . ".$type";
        }
    }
}

function updateiconpath($path)
{
    include "connect.php";
    $name = $_SESSION['name'];
    // echo $name;
    // $sql = "update user set icon = '$path' where username = '$name'";
    $sql = "update user set icon =? where username = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $path, $name);
    $stmt->execute();

    // $stmt->bind_result($icon);

    // $reslut = mysqli_query($con, $sql);
    // if (!$reslut) {
    //     echo "失败";
    // } else {
    //     echo "成功";
    // }
}
