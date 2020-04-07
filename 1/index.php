<?php

if (1 == 2) {

    /**
     * создаём файлы папки если чего то нет
     */
    if (!is_dir(DR . dir_site_module_nowlev_tpl)) {
        mkdir(DR . dir_site_module_nowlev_tpl, 0755);
        $vv['warn'] .= '<br>создана папка для шаблонных файлов';
    }
    $page = 'body.base.htm';

    if (!file_exists(DR . dir_site_module_nowlev_tpl . $page)) {
        $vv['warn'] .= '<br>создан новый файл ' . $page;
        file_put_contents(DR . dir_site_module_nowlev_tpl . $page, ' {% include dir_site_module_nowlev_tpl~\'body.page.htm\' %} ');
    }

    $page = 'body.page.htm';

    if (!file_exists(DR . dir_site_module_nowlev_tpl . $page)) {
        $vv['warn'] .= '<br>создан новый файл ' . $page;
        file_put_contents(DR . dir_site_module_nowlev_tpl . $page, ' <p>новый файл + отредактируйте файл в панели управления</p> ');
    }

    $vv['tpl_body_in'] = dir_site_module_nowlev_tpl . 'body.page.htm';
}


// echo dir_site_module_nowlev;
// echo 
$file_data = DR . dir_site_module_nowlev . 'data.json.ar';

if (file_exists($file_data)) {
    
    // echo '<br/>'.__LINE__;
    $vv['datain'] = json_decode(file_get_contents($file_data), true);
    $vv['datain_time'] = filemtime($file_data);
    // \f\pa($vv['datain']);
    
} else {
    
    // echo '<br/>'.__LINE__;
    $vv['datain'] = [ 'x' => 'x' ];
    $vv['datain_time'] = 'x';
    
}

// \f\pa($vv['datain']);

$vv['tpl_body'] = dir_site_module_nowlev_tpl . 'body.base.htm';