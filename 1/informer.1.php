<?php

/**
  информер
 * */
if (!isset($inf_start_pagedata)) {

    $inf_start_pagedata = 123;

//    echo '<br/>' . __FILE__ . ' #' . __LINE__;
    //\f\pa($w['cfg.level']);
    // \f\pa($w);
//    \f\pa(\Nyos\Nyos::$menu, 2);
//    \f\pa(\Nyos\Nyos::$menu[$w['cfg.level']], 2);

    foreach (\Nyos\Nyos::$menu as $k => $w1) {

        // \f\pa($w1);
//        echo '<br/>'.( $w1['cfg.level'] ?? 'x' );
//        echo '<br/>'.( $w1['datain_name_file'] ?? 'x' );

        if ( isset($w1['type']) && $w1['type'] == 'pagedata' && isset($w1['version']) && $w1['version'] == 1 ) {
            
        } else {
            continue;
        }

//        type = pagedata
//        version = 1

        if (isset($w1['datain_name_file']) && file_exists(DR . dir_site_sd . 'datain' . DS . $w1['datain_name_file'])) {

            // echo '<br/>'.DR . dir_site_sd . 'datain' . DS . $w1['datain_name_file'];
            // echo '<br/>' . __LINE__;

            $ee = \Nyos\mod\PageData::parseFile(
                            DR . dir_site_sd . 'datain' . DS . $w1['datain_name_file']
                            ,
                            \Nyos\Nyos::$folder_now
                            ,
                            $w1['cfg.level']
                            ,
                            ( $w1['datain_name_file_type'] ?? null)
            );
            \f\pa($ee);
        }
    }
}