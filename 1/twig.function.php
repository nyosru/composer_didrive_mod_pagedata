<?php

/**
  определение функций для TWIG
 */
/**
 * достаём инфу из файла другого модуля
 */
$function = new Twig_SimpleFunction('pagedata__get_info_file', function ( $module ) {

    $return = [];

//    for ($i = 0; $i <= 5; $i++) {
//
//        $nn = ( $i == 0 ? '' : $i );

        // $file_data = DR . dir_site . 'module' . DS . $module . DS . 'data' . $nn . '.json.ar';
        $file_data = DR . dir_site . 'module' . DS . $module . DS . 'data.json.ar';
        
        // echo '<br/>#'.__LINE__.' '.$file_data;
        
        // $file_data = DR . dir_site_module_nowlev . 'data'.$nn.'.json.ar';

        if (file_exists($file_data)) {
            
            // echo '<br/>#' . __LINE__;

            // echo '<br/>'.__LINE__;
            $return['data'] = json_decode(file_get_contents($file_data), true);
            $return['time'] = filemtime($file_data);
            // \f\pa($vv['datain']);
        }
        //
//        else {
//             echo '<br/>#' . __LINE__;
//        }
    // }
    return $return;
});
$twig->addFunction($function);
