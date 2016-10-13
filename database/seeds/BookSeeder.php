<?php

use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
            'bookname' => '图书管理系统说明',
            'publisher' => 'maimai',
            'author' => 'maimai',
            'price' => '0',
            'content' => '
前言
--
实用为主，本项目写的代码都是平常开发最经常用到的功能（很多人的演示项目都只是简单的单一的增加显示修改的功能）。鉴于在实际在工作开发中的是必定会要求实现的功能却没有一个好的例子，本项目是以代码实用为主实现实际开发会碰到的需求。
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
---
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

    git clone 待上传。。。


进入laravel-bookmg目录  

    cd laravel-bookmg/
    composer install
复制修改我的备份样例laravel配置文件
    
    修改myenv_bak 为 .env 并可以根据自己需求修改
接下来要用laravel 的 artisan工具来导入表

    php artisan migrate #安装数据表结构
    php artisan db:seed #填充数据
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
',
            'cid' => '2',
            'tags' => '1,2',
            'pic' => '893f697ce2acecb1697e6a44ea81d28e.jpg',
            'user_id' => '1',
            'price' => '0',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),

        ],
        [
            'bookname' => 'PHP编程（第3版）',
            'publisher' => '电子工业出版社',
            'author' => 'Kevin Tatroe(凯文.塔特罗 )',
            'price' => '0',
            'content' => '      当作者第一次问我是否有兴趣写一下该书的序言，我急切回复了是——这是多么有面子的事儿。我回去读了前一个版本的序言后备受打击。我开始质疑为什么让我第一个写。我不是作者，我也没有传奇的故事，我就是个喜欢PHP的普通人！你可能已经知道用PHP写的应用是多么流行：Facebook、Wikipedia、Drupal 和 Wordpress。我能写些什么呢？
    我能说的就是我希望你不久可以读到这本书。当我读这本书的时候我会尝试第一次理解PHP编程。我得到了很多，然后有机会加入 Boston PHP（北美最大的PHP 用户组）并且领导整个小组4年。我见到了很多传奇的PHP开发者，他们很多都是自学成材的。机会像很多PHP人都知道的一样（包括我）：意外地就陷进去了。你只是希望用它来做些新东西。
　　我们的用户组举办了一次活动，邀请人们展示和交流使用PHP的新方式。一个房产经纪人向我们展示了如何用线上虚拟现实应用在自己的领域发现真实美好的愿景。一个教育玩具设计者展示了他的网站，出售他的独一无二的教育游戏。一个音乐家用PHP为著名的音乐大学创建了乐谱学习工具。还有一些人演示了他用来帮助研究癌症的一个程序。
  
    如你所见，PHP很容易做任何事情。不同背景、技能和目标的用户群体都有。你不需要很高的计算机科学学位在当下就能做一些大事。你需要这样一本书，社区可以帮你成长，多点执著和辛苦，你也可以用自己的方式打造一个全新的工具。
　　学习PHP是简单有趣的。作者已经做了很伟大的工作，将基础知识做了转换让你快速开始学习，然后带你正确地深入主题，比如面向对象编程。要更深入地练习从该书上学到的，你可以经常看PHP社区或我们的用户组，每个地方都有，可以帮你前进。有很多PHP会议开始逐渐进入世界上其他地方，具体可以看每年八月都会和其他用户组举办PHP会议，可以碰到很多不错的朋友（比如该书的联合作者 Peter MacIntrre，我也会去）并且了解他们，参与社区，你会是更好的 PHPer。
  
　　— Michael P.Bourque
  
　　VP, PTC
  
　　Boston PHP 用户组组织者
  
　　Northeast PHP 会议组织者
  
　　反向创业组织者
  
',
            'cid' => '1',
            'tags' => '1',
            'pic' => '4c0b4a3e1cc63ee2af8a41798dc4f6d8.jpg',
            'user_id' => '1',
            'price' => '82.99',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),

        ]
    ];
        DB::table('books')->insert($data);
    }
}
