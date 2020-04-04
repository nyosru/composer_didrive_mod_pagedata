<?php

if ( isset($_FILES['data']) 
    && isset($_FILES['data']['size']) 
    && $_FILES['data']['size'] > 100 ) {

    /*
    if (file_exists($vv['dir_mod_site'] . 'didrive.load.php')) {

        $file123 = $_FILES['data']['tmp_name'];
        require $vv['dir_mod_site'] . 'didrive.load.php';

    } else {
        file_put_contents( $vv['dir_mod_site'] . 'didrive.load.php', '<?php // создали на автомате так как должен быть этот файл');
    }
    */
    
    // require_once './../class.php';
    $res = Nyos\mod\PageData::parseFile( $_FILES['data']['tmp_name'], $vv['folder'], $_GET['level'], ( isset($vv['now_mod']['type_file_data']) ? $vv['now_mod']['type_file_data'] : null), false);
    
    //f\pa($res);
    if( $res['status'] == 'ok' ){ $vv['warn'] .= 'Данные обновлены'; }
    
}

if( file_exists($vv['dir_mod_site'] . 'data.s.ar') ){
$vv['d_file']['time'] = date('d-m-Y h:i:s',filemtime( $vv['dir_mod_site'] . 'data.s.ar' ));
$vv['mod_data'] = unserialize(file_get_contents($vv['dir_mod_site'] . 'data.s.ar' ));
}

/*
  $dirmod = $_SERVER['DOCUMENT_ROOT'].DS.'9.site'.DS.$now['folder'].DS.'module'.DS.$vv['level'].DS.'tpl'.DS;

  if( isset( $_POST['editor'] ) )
  {
  $vv['warn'] .= '<div class="warn" >Данные записаны (<a href="/'.$vv['level'].'/" target="_blank" >страница на сайте</a>)</div>';
  file_put_contents( $dirmod.'page.txt.data.htm', $_POST['editor'] );
  }

  $vv['sys']['ckeditor'] = 112;
  $vv['sys']['ckeditor_in'][] = 'editor1';

  $vv['html'] = ( file_exists( $dirmod.'page.txt.data.htm' ) ) ? file_get_contents( $dirmod.'page.txt.data.htm' ) : 'файл данных не обнаружен, записывайте новый' ;
 */

$vv['tpl_body'] = didr_tpl . 'body.htm';
