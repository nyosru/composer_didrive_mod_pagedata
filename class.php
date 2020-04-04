<?php

namespace Nyos\mod;

//echo __FILE__.'<br/>';
// строки безопасности
if (!defined('IN_NYOS_PROJECT'))
    die('<center><h1><br><br><br><br>Cтудия Сергея</h1><p>Сработала защита <b>TPL</b> от злостных розовых хакеров.</p>
    <a href="http://www.uralweb.info" target="_blank">Создание, дизайн, вёрстка и программирование сайтов.</a><br />
    <a href="http://www.nyos.ru" target="_blank">Только отдельные услуги: Дизайн, вёрстка и программирование сайтов.</a>');

class PageData {

    public static $skip_polya = array();

    /*
      function putKeyArray($key, $data) {

      // echo '<pre>'; print_r($key); echo '</pre>';
      // echo '<pre>'; print_r($data); echo '</pre>';

      $w = array();

      foreach ($data as $k1 => $v1) {
      if ( isset($v1{0}) ) {
      $w[( isset($key[$k1]) ? $key[$k1] : $k1)] = $v1;
      //echo '<Br/>'.$k1.' - '.$v1;
      }
      }

      // echo '<pre>'; print_r($w); echo '</pre>';

      return $w;
      }
     */

    
    
    public static function readFile($file){
        
        \f\pa(\Nyos\Nyos::$folder_now);
        
        
    }
    
    
    
    
    /**
     * обработка файла данных
     * @global string $status
     * @param type $file
     * ссылка на файл данных
     * @param type $folder
     * @param type $module
     * @param type $type
     * 1c_win1251 - если файд выгрузки из 1с в кодировке вин1251
     * @param type $save_old_file
     * (по умолчанию true) сохраняем дата файл как старый если true
     * @return type
     */
    public static function parseFile($file, $folder, $module, $type = null, $save_old_file = true) {

        //echo 'public static function parseFile('.$file.', '.$folder.', '.$module.', '.$type.' = null, '.$save_old_file.' = true ) {';
        // $show_status = true;

        if (1 == 1) {

            if (isset($show_status) && $show_status === true) {
                $status = '';
                $_SESSION['status1'] = true;
            }

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                global $status;

                $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
            }
        }

        if (file_exists($file)) {
            
        } else {

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true)
                $status .= 'файл указан не верно<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            return \f\end2('Ошибка в указании ссылки на файл', false, array(), 'array');
        }

        if ($type == 'win1251') {

            $t_head = null;
            $t_all = array();

            $handle = @fopen($file, "r");

            if ($handle) {

                while (( $stroka = fgets($handle, 4096)) !== false) {

                    // echo '<br/>'.$stroka;


                    $stroka = trim(iconv('windows-1251', 'UTF-8', $stroka));

                    // обработка полученной строки

                    if ($t_head === null) {
                        $t_head = explode(';', $stroka);
                    } else {
                        $t_all[] = self::putKeyArray($t_head, explode(';', $stroka));
                    }

                    // // echo __LINE__.'<br/>';
                    // echo iconv('windows-1251', 'UTF-8', $buffer) . '<br/>';
                }

                if (!feof($handle)) {
                    echo "Ошибка чтения файла\n";
                }

                fclose($handle);
            }

            // удаляем старый старый файл
            if (file_exists($file . '.delete'))
                unlink($file . '.delete');

            // делаем из обработанного файла старый файл
            // если перменная определена
            if ($save_old_file === true && file_exists($file))
                rename($file, $file . '.delete');
        }

        //elseif ($type == '1c_win1251') {
        else{

            $t_head = null;
            $t_all = array();

            $handle = @fopen($file, "r");

            if ($handle) {

                while (( $stroka = fgets($handle, 4096)) !== false) {

                    // echo '<br/>'.$stroka;

                    if (isset($r) && $r === true) {

                        $stroka = trim(iconv('windows-1251', 'UTF-8', $stroka));

                        // обработка полученной строки

                        if ($t_head === null) {

                            $t_head = explode(';', $stroka);
                        } else {

                            $t_all[] = self::putKeyArray($t_head, explode(';', $stroka));
                        }

                        // // echo __LINE__.'<br/>';
                        // echo iconv('windows-1251', 'UTF-8', $buffer) . '<br/>';
                    }

                    if (( ( isset($r) && $r !== true ) || !isset($r) ) && substr($stroka, 0, 4) == '@@@=') {
                        //echo __LINE__.'<br/>';
                        $r = true;
                    }
                }

                if (!feof($handle)) {
                    echo "Ошибка чтения файла\n";
                }

                fclose($handle);
            }

            // удаляем старый старый файл
            if (file_exists($file . '.delete'))
                unlink($file . '.delete');

            // делаем из обработанного файла старый файл
            // если перменная определена
            if ($save_old_file === true && file_exists($file))
                rename($file, $file . '.delete');
        }

        //\f\pa($t_all);
        //\f\pa($t_all);

        file_put_contents($_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $folder . DS . 'module' . DS . $module . DS . 'data.s.ar', serialize($t_all));

        // $vv['warn'] .= ( isset($vv['warn']{5}) ? '<br/>' : '' ) . );

        if (2 == 2) {
            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

                if (isset($show_status) && $show_status === true)
                    echo $status;
            }
        }

        return \f\end3('окай, сохранено строк информации: ' . sizeof($t_all), true);
    }

    public static function putKeyArray($key, $data) {

        // $show_status = true;

        if (1 == 1) {

            if (isset($show_status) && $show_status === true) {
                $status = '';
                $_SESSION['status1'] = true;
            }

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                global $status;

                $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
            }
        }

        /*
          if (file_exists($file)) {

          } else {

          if (isset($_SESSION['status1']) && $_SESSION['status1'] === true)
          $status .= 'файл указан не верно<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

          return f\end2('Ошибка в указании ссылки на файл', false, array(), 'array');
          }
         */


        $w = array();

        /*
          foreach ($data as $k1 => $v1) {
          if (isset($v1{0})) {
          $w[( isset($key[$k1]) ? $key[$k1] : $k1)] = $v1;
          //echo '<Br/>'.$k1.' - '.$v1;
          }
          }
         */
        foreach ($key as $k1 => $v1) {
            $w[$v1] = isset($data[$k1]{0}) ? $data[$k1] : '';
            //echo '<Br/>'.$k1.' - '.$v1;
        }

        // echo '<pre>'; print_r($w); echo '</pre>';

        if (2 == 2) {
            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

                if (isset($show_status) && $show_status === true)
                    echo $status;
            }
        }

        return $w;
        //return \f\end3( 'ok', true, $w);
    }

    public static function blank($file, $folder, $module) {

        // $show_status = true;

        if (1 == 1) {

            if (isset($show_status) && $show_status === true) {
                $status = '';
                $_SESSION['status1'] = true;
            }

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                global $status;

                $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
            }
        }


        if (file_exists($file)) {
            
        } else {

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true)
                $status .= 'файл указан не верно<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            return f\end2('Ошибка в указании ссылки на файл', false, array(), 'array');
        }


        if (2 == 2) {
            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

                if (isset($show_status) && $show_status === true)
                    echo $status;
            }
        }

        return f\end3($res['summa'], true);
    }

}
