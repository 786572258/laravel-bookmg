<?php


if (!function_exists('adminView')) {
    /**
     * 展示后台view
     * @param  string $view
     * @param  array $data
     * @param  array $mergeData
     * @return \Illuminate\View\View
     */
    function adminView($view = null, $data = array(), $mergeData = array())
    {
        $factory = app('Illuminate\Contracts\View\Factory');
        if (func_num_args() === 0) {
            return $factory;
        }
        $baseViewPath = Config::get('path.adminBaseViewPath');
        $module = Config::get('path.class');
        if (!empty($module)) {
            $baseViewPath .= Config::get('path.modules.' . $module);
            Config::set('path.class', '');
        }
        return $factory->make($baseViewPath . $view, $data, $mergeData);
    }
}
if (!function_exists('conversionClassPath')) {
    /**
     * 转换class 名
     * @param  string $className
     * @return string
     */
    function conversionClassPath($className)
    {
        $className = str_replace('\\', '-', $className);
        if (preg_match("/.*-(.*)Controller/is", $className, $matches)) {
            Config::set('path.class', strtolower($matches[1]));
        } else {
            return response('conversionClassPathError', 500);
        }
    }
}
if (!function_exists('homeView')) {
    /**
     * 展示前台view
     * @param  string $view
     * @param  array $data
     * @param  array $mergeData
     * @return \Illuminate\View\View
     */
    function homeView($view = null, $data = array(), $mergeData = array())
    {
        $factory = app('Illuminate\Contracts\View\Factory');
        if (func_num_args() === 0) {
            return $factory;
        }
        $themes = THEMES_NAME . '.' . Config::get('app.themes');
        return $factory->make($themes . '.' . $view, $data, $mergeData);
    }
}

if (!function_exists('getFinderPath')) {
    /**
     * 获取模板的系统路径（前台）
     * @param  string $view
     * @return \Illuminate\View\View
     */
    function getFinderPath($view = null)
    {
        $factory = app('Illuminate\Contracts\View\Factory');
        $finder = $factory->getFinder();
        dd($factory->exists('themes.default.shtml.index'));
        if (func_num_args() === 0) {
            return $finder->path;
        }
        $themes = THEMES_NAME . '.' . Config::get('app.themes') . '.' .$view;
        return $path = $finder->find($themes);
    }
}

if (!function_exists('homeAsset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string $path
     * @param  bool $secure
     * @return string
     */
    function homeAsset($path, $secure = null)
    {
        $themes = THEMES_NAME . DIRECTORY_SEPARATOR . Config::get('app.themes');
        return app('url')->asset($themes . $path, $secure);
    }
}

if (!function_exists('homeAssetPath')) {
    /**
     * 前台公共主题的系统路径
     *
     * @return string
     */
    function homeAssetPath()
    {
        return public_path(). DIRECTORY_SEPARATOR. THEMES_NAME . DIRECTORY_SEPARATOR . Config::get('app.themes');
    }
}

if (!function_exists('strCut')) {
    /**
     * 字符串截取
     * @param string $string
     * @param integer $length
     * @param string $suffix
     * @return string
     */
    function strCut($string, $length, $suffix = '...')
    {
        $resultString = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strLength = strlen($string);
        for ($i = 0; (($i < $strLength) && ($length > 0)); $i++) {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0')) {
                if ($length < 1.0) {
                    break;
                }
                $resultString .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            } else {
                $resultString .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $resultString = htmlspecialchars($resultString, ENT_QUOTES, 'UTF-8');
        if ($i < $strLength) {
            $resultString .= $suffix;
        }
        return $resultString;
    }
}

if (!function_exists('viewInit')) {
    /**
     * 前台公共数据
     * @param string $string
     * @param integer $length
     * @param string $suffix
     * @return string
     */
    function viewInit()
    {
        $book = app('App\Model\Book');
        $tags = app('App\Model\Tag');
        $view = app('view');
        $nav = app('App\Model\Navigation');
        $category = app('App\Model\Category');
        $links = app('App\Model\Links');


        //$view->share('hotArticleList', $article::getHotArticle(3));
        $view->share('tagList', $tags::getHotTags(12));
        $view->share('navList', $nav::getNavigationAll());
        $view->share('linkList', $links::getLinkList());
        $view->share('topCategory', $category::getTopCategory());
    }
}

if (!function_exists('conversionMarkdown')) {
    /**
     * @param $markdownContent
     * @return string
     */
    function conversionMarkdown($markdownContent)
    {
        $endaEditor = app('YuanChao\Editor\Facade\EndaEditorFacade');
        return !empty($markdownContent) ? $endaEditor::MarkDecode($markdownContent) : '';
    }
}

if (!function_exists('uploadFile')) {
    /**
     * @param $type
     * @param $field
     * @param $path
     * @return bool|string
     */
    function uploadFile($type, $field, $path)
    {
        $allowType = array(
            'img' => array(
                'image/gif',
                'image/ief',
                'image/jpeg',
                'image/png',
                'image/tiff',
                'image/x-ms-bmp',
            )
        );
        $url = '';
        if (!isset($allowType[$type])) {
            return false;
        }
        $request = app('Request');
        if ($request::hasFile($field)) {
            $pic = $request::file($field);
            if (in_array($pic->getMimeType(), $allowType[$type])) {
                if ($pic->isValid()) {
                    $newName = md5(rand(1, 1000) . $pic->getClientOriginalName()) . "." . $pic->getClientOriginalExtension();
                    $pic->move($path, $newName);
                    $url = $newName;
                }
            }
        }
        return $url;
    }
}

if (!function_exists('tree')) {
    function tree($model, $parentId = 0, $level = 0, $html = '-')
    {
        $data = array();
        foreach ($model as $k => $v) {
            if ($v->parent_id == $parentId) {
                if ($level != 0) {
                    $v->html = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                    $v->html .= '|';
                }
                $v->html .= str_repeat($html, $level);
                $data[] = $v;
                $data = array_merge($data, tree($model, $v->id, $level + 1));

            }
        }

        return $data;
    }
}

if (!function_exists('catetree')) {
    //重新写分类树
    function catetree($model, $parentId = 0, $level = 0, $html = '-')
    {
        static $list = array();
        foreach ($model as $k => $v) {
            if ($v->parent_id == $parentId) {
                if ($level != 0) {
                    $v->html = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                    $v->html .= '|';
                }
                $v->html .= str_repeat($html, $level);
                $list[] = $v;
                catetree($model, $v->id, $level + 1);
            }
        }

        return $list;
    }
}
/**
 * 获取系统设置
 */
if (!function_exists('systemConfig')) {
    function systemConfig($field, $default = '')
    {
        $system = app('App\Model\System');
        $val = $system->getSystem($field);
        return !empty($val) ? $val : $default;
    }
}

if (!function_exists('getArticleImg')) {
    function getArticleImg($image = '')
    {
        $imageUrl = 'images/01.jpg';
        if (!empty($image)) {
            $imageUrl = 'uploads' . '/' . $image;
        }
        return asset($imageUrl);
    }
}

/**
 * 调试
 */
if (!function_exists('debug')) {
    function debug($d)
    {
        echo '<pre>';
        print_r($d);
    }
}