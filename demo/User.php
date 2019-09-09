<?php
namespace app\admin\controller;

use think\facade\Config;

class User
{
    public function get()
    {
        //获取全部配置项
        // dump(Config::get());

        //仅获取app下的配置项
        // dump(Config::get('app.'));

        //仅仅获取一级配置项
        // dump(Config::pull('app'));

        //获取二级配置项
        dump(Config::get('app.app_debug'));
        dump(Config::get('default_lang'));

        dump(Config::has('default_lang'));

        dump(Config::get('database.hostname'));
    }

    public function set()
    {
        dump(Config::get('app_debug'));
        Config::set('app_debug', true);
        dump(Config::get('app_debug'));
    }

    public function helper()
    {
        //助手函数不依赖于Config
        // dump(config());
        dump(config('default_module'));
        dump(config('database.username'));
        config('database.hostname', 'localhost');
        dump(config('database.hostname'));
    }
}
