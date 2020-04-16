<?php

/**
  информер
 * */
// echo '<br/>#'.__LINE__.' '.__FILE__;

if (!isset($inf_start_pagedata)) {
    $inf_start_pagedata = 123;

// echo '<br/>#'.__LINE__.' '.__FILE__;
//    echo '<br/>' . __FILE__ . ' #' . __LINE__;
    //\f\pa($w['cfg.level']);
    // \f\pa($w);
//    \f\pa(\Nyos\Nyos::$menu, 2);
//    \f\pa(\Nyos\Nyos::$menu[$w['cfg.level']], 2);

    $file_readed = [];
    $text_sms = '';

    foreach (\Nyos\Nyos::$menu as $k => $w1) {

        // \f\pa($w1);

        if (
                (isset($w1['type']) && $w1['type'] == 'pagedata' && isset($w1['version']) && $w1['version'] == 1) || (isset($w1['type']) && $w1['type'] == 'items' )
        ) {
            
        } else {
            continue;
        }

//        echo '<hr>';
//        echo '<br/>'.( $w1['cfg.level'] ?? 'x' );
//        echo '<br/>'.( $w1['name'] ?? 'x' );
//        echo '<br/>'.( $w1['datain_name_file'] ?? 'x' );
//        \f\pa($w1);
//        type = pagedata
//        version = 1

        // echo '<br/>#' . __LINE__ . ' ' . $w1['cfg.level'] . ' <br/> ' . $w1['type'];

        $file_type = $w1['datain_name_file_type'] ?? null;

        if (empty($w1['datain_name_file']))
            continue;

        if (!empty($file_readed[$w1['datain_name_file'] . $w1['cfg.level']]))
            continue;

        $file_readed[$w1['datain_name_file'] . $w1['cfg.level']] = 123;

        $file_data = $w1['datain_name_file'];
        $file_data_dir = DR . dir_site_sd . 'datain' . DS;

        $file1 = $file_data_dir . $file_data;

//        echo '<br/>#' . __LINE__ . ' ' . $w1['cfg.level'];
//        echo '<br/>#' . __LINE__ . ' ' . $file1;

        if (file_exists($file1)) {

//            echo '<br/>#' . __LINE__ . ' есть';
//echo '<br/>'.DR . dir_site_sd . 'datain' . DS . $w1['datain_name_file'];
//echo '<br/>' . __LINE__;

            $text_sms .= PHP_EOL . ' модуль ' . $w1['cfg.level'];

            $ee = \Nyos\mod\PageData::parseFile(
                            $file1
                            ,
                            $w1['cfg.level']
                            ,
                            $file_type
                            ,
                            // true
                            false
//                            ,
//                            0
//                                    ,
//                                    \Nyos\Nyos::$folder_now
            );
//            \f\pa($ee);
        }

        for ($i = 0; $i <= 5; $i ++) {

            $skip = true;

            if ($i == 0 && !empty($w1['datain_name_file'])) {
                $file_data = $w1['datain_name_file'];
                $file_type = $w1['datain_name_file_type'] ?? null;
                $data_in_items = $w1['data_in_items'] ?? null;
                $skip = false;
            } elseif (isset($w1['datain_file_' . $i]['datain_name_file'])) {
                $file_data = $w1['datain_file_' . $i]['datain_name_file'];
                $file_type = $w1['datain_file_' . $i]['datain_name_file_type'] ?? null;
                $data_in_items = $w1['datain_file_' . $i]['data_in_items'] ?? null;
                $skip = false;
            }

            if ($skip === true)
                continue;

            $file_data_dir = DR . dir_site_sd . 'datain' . DS;
            $file1 = $file_data_dir . $file_data;

            // echo '<br/>#' . __LINE__ . ' ' . $file1;

            if (file_exists($file1)) {

                $text_sms .= PHP_EOL . ' обработали дата файл ' . $file_data;

//                echo '<br/>#' . __LINE__ . ' ' . $file1;
                // echo '<br/>'.DR . dir_site_sd . 'datain' . DS . $w1['datain_name_file'];
                // echo '<br/>' . __LINE__;

                $ee = \Nyos\mod\PageData::parseFile(
                                $file1
                                ,
                                $w1['cfg.level']
                                ,
                                $file_type
                                ,
                                //true
                                false
                                ,
                                ( ( $i > 0 ) ? $i : '')
//                                    ,
//                                    \Nyos\Nyos::$folder_now
                );

                rename($file1, $file1 . '.' . date('Y_m_d_h_i') . '.old');

//                    \f\pa($ee);
                // echo '<br/>#'.__LINE__;

                if (!empty($w1['data_in_items']) && $w1['data_in_items'] == 'da') {

                    //echo '<br/>#'.__LINE__;
                    //echo
                    $data_file = DR . dir_site_module . $w1['cfg.level'] . DS . 'data.json.ar';

                    if (file_exists($data_file)) {

                        // echo '<br/>#'.__LINE__;

                        $data = json_decode(file_get_contents($data_file), true);

//\f\pa($w1['cfg.level'],2);
//\f\pa($data_file,2);
//\f\pa($data,2);

                        $text_sms .= PHP_EOL . ' пишем данные в базу (' . sizeof($data) . ' записей) модуль ' . $w1['cfg.level'];

                        \Nyos\mod\items::deleteFromDops($db, $w1['cfg.level']);
                        \Nyos\mod\items::addNewSimples($db, $w1['cfg.level'], $data);

                        rename($data_file, $data_file . '.' . date('Y_m_d_h_i') . '.old');
                        // unlink($data_file);
                        // echo '<br/>#' . __LINE__;

                        $ee = \Nyos\mod\items::get($db, $w1['cfg.level']);
                        \f\pa($ee, 2, '', $w1['cfg.level']);
                    }
                }
//                else {
//                    echo '<br/>#' . __LINE__;
//                }
            }
        }
    }


    if (!empty($text_sms))
        \nyos\Msg::sendTelegramm('нашли необработанные дата файлы, обрабатываем!' . $text_sms, null, 2);
    
}