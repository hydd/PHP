<?php
/**
 * trait优先级的问题
 * 1 重名 trait优先级高于父类
 */

trait Demo1
{
    public function hello()
    {
        return __METHOD__;
    }
}
trait Demo2
{
    public function hello2()
    {
        return __METHOD__;
    }
}
class Test
{
    public function hello()
    {
        return __METHOD__;
    }
}
class Demo extends Test
{
    use Demo1, Demo2;
    // public function hello()
    // {
    //     return __METHOD__;
    // }
    public function test1()
    {
        return $this->hello1();
    }
    public function test2()
    {
        return $this->hello2();
    }
}

$obj = new Demo();
echo $obj->hello();
// echo '<hr>';
// echo $obj->test1();
// echo '<hr>';
// echo $obj->test2();
// echo '<hr>';
