项目环境搭建
------
 - 基于laravel5.1 
 - php5.6（个人环境，5.5应该也可以）
 - ubuntu14.04（个人）
 - mysql
 - redis（必备，不然报错）
 - linux权限问题（有一些目录需要写权限，嫌目录太多直接全部给777权限（正式项目最好不要这样））
    storage/ 
    public/uploads/
    public/themes/default/staticPage/  （存放静态页面）


----------
克隆到本地

    git clone https://www.github.com/786572258/laravel-bookmg


进入laravel-bookmg目录  

    cd laravel-bookmg/
    composer install
复制修改我的备份样例laravel配置文件
    
    修改myenv_bak 为 .env 并可以根据自己需求修改
接下来要用laravel 的 artisan工具来导入表

    php artisan migrate #安装数据表结构
    php artisan db:seed #填充数据
或者直接执行这条命令
        
        php artisan migrate:refresh --seed

把你的域名绑定到 laravel-bookmg/public 目录下
nginx服务器的话配个虚拟主机的同时需要指定主机文件
    
    server {
        ...
        include 你的项目路径/public/.htaccess_nginx;
        ...
    }
这个主机重写文件是我从原来的.htaccess翻译到nginx里面的。需要引入然后重启nginx服务器才能正常访问图书管理系统项目。

配置域名（我配置的是www.laravelbookmg.com）然后访问。
后台登录页地址是：www.laravelbookmg.com/admin，默认账户：admin@admin.com,123456

访问可能会报配置、目录权限的错误，找出需要权限的目录本给他写入权限就ok。

结束语
---
搭建环境没搭过的朋友也许会觉得麻烦，不过沉下心一步一步来做并理清程序流程，理解laravel开发思想，你会学到很多的。本项目非常适合学习之用。有不足和疑问的地方欢迎来群大家交流一起学习！
【459735113】http://jq.qq.com/?_wv=1027&k=40HDl2N
