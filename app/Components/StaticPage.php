<?php
namespace App\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * 静态页面化工具类
 */
class StaticPage
{
    private $staticPagePath = '';            //静态目录系统路径   
    private $ext = 'shtml';                  //静态文件后缀
    private $expireTime = 60;                //缓存过期时间单位


    public function __construct()
    {        
        $this->setStaticPagePath(homeAssetPath() . DIRECTORY_SEPARATOR . Config::get('app.staticPage'));
        if (!is_dir($this->staticPagePath)) {
            try {
                mkdir($this->staticPagePath);
            } catch (\Exception $e){
                throw new \Exception("创建静态页面目录失败". $e->getMessage());
            }
        }
    }

    /**
    * 设置静态页面目录路径
    * @return string
    */
    public function setStaticPagePath($staticPagePath)
    {
        $this->staticPagePath = $staticPagePath;
    }

    /**
    * 前台静态页面文件路径
    * @return string
    */
    public function staticPagePath()
    {
        return $this->staticPagePath;
    }

    /**
    * 是否存在静态文件
    * @return string
    */
    public function exists($view)
    {
        if (empty($view)) {
            return false;
        }
        return file_exists($this->getStaticPageFile($view));
    }

    /**
    * 有可用的静态文件（未过期）
    * @return string
    */
    public function usable($view)
    {
        if (!$this->exists($view)) {
            return false;
        }
        $filemtime = filemtime($this->getStaticPageFile($view));
        //失效
        if (time() > $filemtime + $this->expireTime) {
            return false;
        }
        return true;
    }
    
    /**
    * 获取静态文件全路径
    * @return string
    */
    public function getStaticPageFile($view)
    {
       return $this->staticPagePath . DIRECTORY_SEPARATOR . $view . '.' .$this->ext;
    }

    /**
    * 获取静态文件内容
    * @return string
    */
    public function getContent($view)
    {
        if (empty($view)) {
            return false;
        }
        return file_get_contents($this->getStaticPageFile($view));
    }

    /**
    * 写入静态文件内容
    * @return string
    */
    public function putContent($view, $content = '')
    {
        if (empty($view)) {
            return false;
        }
        return file_put_contents($this->getStaticPageFile($view), $content);
    }

    /**
     * 设置静态页面过期时间
     */
    public function setExpireTime($expireTime)
    {
        $this->expireTime = $expireTime;
    }
}