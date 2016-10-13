<?php
/**
 * 模板路径定位配置
 */
define('THEMES_NAME','themes');
define('CONTENT','content.');
define('SYSTEM','setting.');
define('USER','user.');
return [ 
    'adminBaseViewPath'=>'admin.',
    'modules'=>[
        'book' => CONTENT.'book.',
        'borrow' => CONTENT.'borrow.',
        'cate'=>CONTENT.'cate.',
        'article'=>CONTENT.'article.',
        'tags'=>CONTENT.'tags.',
        'system'=>SYSTEM.'system.',
        'navigation'=>SYSTEM.'navigation.',
        'links'=>SYSTEM.'links.',
        'user'=>USER,
        'comment'=>CONTENT.'comment.'
    ],
    'class'=>'',
];