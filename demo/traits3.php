<?php
/**
 * 多个trait类有同名方法
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
    public function hello()
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
    use Demo1, Demo2 {
        Demo1::hello insteadof Demo2;
        Demo2::hello as Demo2Hello;
    }
    // public function hello()
    // {
    //     return __METHOD__;
    // }
    function test1()
    {
        return $this->hello();
    }
    function test2()
    {
        return $this->Demo2Hello();
    }
}

$obj = new Demo();
// echo $obj->hello();
echo $obj->test2();
// echo '<hr>';
// echo $obj->test1();
// echo '<hr>';
// echo $obj->test2();
// echo '<hr>';
