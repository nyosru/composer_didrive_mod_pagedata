<?php

$file_dir = dir_serv_site_sd . 'datain' . DS;
// $file_data = dir_serv_site_sd . 'datain' . DS . $vv['now_level']['datain_name_file'];

/**
 * нашли файл данных товаров для магазина
 */
$file_all = [];
$file_parse = [];

for ($i = 0; $i <= 10; $i++) {

    if (isset($vv['now_level']['datain_file_' . $i]['datain_name_file'])) {
        $file_all[] = $vv['now_level']['datain_file_' . $i];
        if (file_exists($file_dir . $vv['now_level']['datain_file_' . $i]['datain_name_file'])) {
            $file_parse[] = $vv['now_level']['datain_file_' . $i];
        }
    }
}

if (isset($vv['now_level']['datain_name_file'])) {
    $ff = array(
        'datain_name_file_type' => $vv['now_level']['datain_name_file_type'],
        'datain_name_file' => $vv['now_level']['datain_name_file'],
        'name_var' => ( isset($vv['now_level']['name_var']) ? $vv['now_level']['name_var'] : 'datain' ),
        'datain_name_file_no_delete_after_parsing' => ( isset($vv['now_level']['datain_name_file_no_delete_after_parsing']) ? $vv['now_level']['datain_name_file_no_delete_after_parsing'] : '' ),
    );

    $file_all[] = $ff;
}

if (isset($vv['now_level']['datain_name_file']) && file_exists($file_dir . $vv['now_level']['datain_name_file'])) {
    if (file_exists($file_dir . $vv['now_level']['datain_name_file'])) {
        $file_parse[] = $ff;
    }
}



// \f\pa($file_parse);

/**
 * если есть файлы, обрабатываем их
 */
if (sizeof($file_parse) > 0) {

    // \f\pa($file_parse);

    $vv['warn'] .= '<br/>Обработали обновлённые файлы';

    require_once $_SERVER['DOCUMENT_ROOT'] . '/include/f/file.php';

    if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/site'))
        \Nyos\mod\myshop::$shop_id = 1;

    $msg = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $vv['level'] . '/' . PHP_EOL . PHP_EOL;

    foreach ($file_parse as $k => $x) {

        try {

            //\f\pa($x);

            $file_data = $file_dir . $x['datain_name_file'];
            \f\pa($file_data,'','','$file_data');
            
            $array = \f\readDataFile($file_data, (!empty($x['datain_name_file_type']) ? $x['datain_name_file_type'] : null));

            \f\pa($array,'','','$array');

            $msg .= 'Обработали файл данных ' . $x['datain_name_file'] . PHP_EOL
                    . 'значений ' . sizeof($array['data']) . PHP_EOL . PHP_EOL;

            if (file_exists($file_data . '.json.delete'))
                unlink($file_data . '.json.delete');

            if (file_exists($file_data . '.json'))
                rename($file_data . '.json', $file_data . '.json.delete');

            file_put_contents($file_data . '.json', json_encode($array));

            if (isset($x['datain_name_file_no_delete_after_parsing']) && $x['datain_name_file_no_delete_after_parsing'] == 'da') {
                
            } else {
                rename($file_data, $file_data . '.delete');
            }
        } catch (\NyosEx $ex) {
            $vv['warn'] .= ( isset($vv['warn']) ? '<br/>' : '' ) . $ex->getMessage();
        }
    }

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/include/Nyos/nyos_msg.php')) {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/include/Nyos/nyos_msg.php';
        \Nyos\NyosMsg::sendTelegramm($msg);

        if (isset($vv['now_level']['send_telegram']) && $vv['now_level']['send_telegram'] == 'send') {
            for ($d = 1; $d <= 10; $d++) {
                if (isset($vv['now_level']['send_telegram_id_' . $d]) && is_numeric($vv['now_level']['send_telegram_id_' . $d])) {
                    \Nyos\NyosMsg::sendTelegramm($msg, $vv['now_level']['send_telegram_id_' . $d]);
                }
            }
        }
        
    }
}

//\f\pa($file_all, 2, null, '$file_all');

foreach ($file_all as $k => $v1) {

    //\f\pa($v);
    if (isset($v1['datain_name_file'])) {
        $file = $file_dir . $v1['datain_name_file'] . '.json';
        if (file_exists($file)) {

            $vv['datain_time'] = date('d-m-Y H:i:s', filemtime($file));
            $vv[( isset($v1['name_var']) ? $v1['name_var'] : 'datain' )] = json_decode(file_get_contents($file), true);
            $vv[( isset($v1['name_var']) ? $v1['name_var'] : 'datain' )]['file'] = $file;
            $vv[( isset($v1['name_var']) ? $v1['name_var'] : 'datain' )]['file_time'] = date('H:i:s Y.m.d', filemtime($file));
            //echo 'обр '.$v1['name_var'].' yes<Br/>';
            //echo '<br/>' . __FILE__ . ' ' . __LINE__;
        }
//        else {
//            echo '<br/>' . __FILE__ . ' ' . __LINE__;
//        }
    }
}


/*
  // \f\pa($vv['now_mod']);

  $f = dir_serv_site_sd . 'datain/' . $vv['now_level']['datain_name_file'] . '.arr';

  //echo $f;

  if (file_exists($f)) {

  $vv['mod_data_time'] = date('d-m-Y H:i:s', filemtime($f));
  $vv['mod_data'] = unserialize(file_get_contents($f));
  } elseif (file_exists(dir_serv_site_mod . 'data.s.ar')) {

  $vv['mod_data_time'] = date('d-m-Y H:i:s', filemtime(dir_serv_site_mod . 'data.s.ar'));
  $vv['mod_data'] = unserialize(file_get_contents(dir_serv_site_mod . 'data.s.ar'));
  }
 */


$vv['tpl_0body'] = \f\like_tpl('body', dir_serv_mod_ver_tpl, dir_serv_site_mod_tpl); //  $dirmod . 'show.data.htm';
