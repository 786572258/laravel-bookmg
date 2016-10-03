前言
--
本项目非常利于学习和理解laravel，理解laravel的开发思想，面向对象开发，组件化开发，降低耦合度，有利于项目后期的扩展。虽然laravel文件目录多，不过层次清晰，类库是通过命名空间按需加载，所以看似庞大实际速度不慢。

实用为主，本项目写的代码都是平常开发最经常用到的功能（很多人的演示项目都只是简单的单一的增加显示修改的功能）。鉴于在实际在工作开发中必定会要求实现的功能却没有一个好的例子，本项目是以代码实用为主实现实际开发会碰到的需求的功能。
比如一些实用后台功能：搜索+分页+多表，很多教程都很浅显单单实现单表分页而已，于是自己写了些例子供以后工作用到。
图1
![这里写图片描述](http://img.blog.csdn.net/20161012192941221)
######  　#####
图2
![这里写图片描述](http://img.blog.csdn.net/20161012193213714)
######  　#####
例如图2搜索借书表的书本名和作者，借书表存的是图书id（book_id）需要去关联图书表（books）才能取到图书的名称和作者，还要配合分页这就需要连表操作了，比较复杂，不过laravel还是能实现的，需要用到php的闭包和use传送变量来多维筛选，关键代码如下：
```
	/**
     * 筛选并分页
     * @param $schParams 搜索的表单字段
     */
    private function filterBorrow($schParams)
    {
        return Borrow::select("borrows.*", "b.id as b_id", "b.bookname", "b.author")
            ->leftJoin("books as b", "borrows.book_id", "=", "b.id")
            ->where(function($query) use ($schParams) {
                if ($keyword = $schParams["keyword"]) {
                    $query->where(function($query) use ($keyword) {
                        $query->where("b.bookname", "like", "%$keyword%")
                        ->orWhere("b.author", "=", $keyword);
                    });
                }
                if ($name_or_number = $schParams["name_or_number"]) {
                    $query->where(function($query) use ($name_or_number) {
                        $query->where("borrows.name", "=", $name_or_number)
                        ->orWhere("borrows.number", "=", $name_or_number);
                    });
                }
            })->orderBy("borrows.id", "DESC")->paginate(10);
    }
```
以上代码实现了多表搜索加分页的功能，第一个if的作用是搜索所有借书记录存在某书本名或作者的or模糊搜索。闭包里面再闭包，为了包装查询条件，实际上是属于设计模式里面的装饰模式（Decorator Pattern）
还有ajax提交表达也很少教程提到，所以本图书管理项目也有例子在里面。laravel的表单提交需要验证csrf跨域攻击，ajax的话要加上这段代码才能访问得到控制器的方法：
```
 headers: {
	"X-CSRF-TOKEN": "{{ csrf_token() }}"
 },
```
######  　#####
前台部分首页使用了页面真静态化的手段缓存一个静态模板，静态页面工具类缓存一分钟，过期会的话第二次访问页面就会重写模板。这个类是我按自己思路写出来的，不合理的地方大家可以交流指正。把类放到app/Components下并给他一个命名空间，想要用这个类的时候use命名空间就可以实现自动加载。这恰恰碰到了如何将自己的类库集成到laravel的实际问题。
图3
![这里写图片描述](http://img.blog.csdn.net/20161012200950826)

比如图3是首页的图书列表界面，首次第一个人访问会到数据库访问所有数据，一共执行了7条SQL。
第二个人刷新页面页面将会从服务器上寻找静态缓存文件然后直接输出模板，不经过数据库。看图4。
图4
![这里写图片描述](http://img.blog.csdn.net/20161012201445503)


静态页面类默认是一分钟缓存，可以通过代码配置时长。
静态页面大大提高了访问速度，时候内容更新不频繁不要求实时的页面。

图书数据也通过redis放到了内存上，个人不推荐实际项目这样做，要是图书多了数据多内存会爆。这个只作为学习用一下。

到时再把项目发布到github上面，现在先说环境搭建。
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
   bootstrap/cache/
   public/themes/default/staticPage/  （存放静态页面）


----------
克隆到本地

	git clone https://www.github.com/786572258/laravel-bookmg

有时候github克隆太慢可以到群
【459735113】http://jq.qq.com/?_wv=1027&k=40HDl2N
提供下载

进入laravel-bookmg目录	

	cd laravel-bookmg/
	composer install
复制修改我的备份样例laravel配置文件
	
	修改myenv_bak 为 .env 并可以根据自己需求修改

手动创建一个数据库（数据库名为.env里面的配置名）
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

如果范围页面一片空白，应该是权限问题，查看日志找出问题

	vim /var/log/nginx/error.log
或查看
	
	laravel-bookmg/storage/logs/ 里面的日志
		
结束语
---
搭建环境没搭过的朋友也许会觉得麻烦，不过沉下心一步一步来做并理清程序流程，理解laravel开发思想，你会学到很多的。本项目非常适合学习之用。有不足和疑问的地方欢迎来群大家交流一起学习！
【459735113】http://jq.qq.com/?_wv=1027&k=40HDl2N

