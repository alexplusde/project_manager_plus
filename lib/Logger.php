<?php

namespace Alexplusde\PMP;

use rex_path;
use rex_log_file;
use rex_file;

class Logger extends rex_log_file
{
  public static $init = false;
  public static $logfile;
  public const DATE_FORMAT = 'Y-m-d H:i:s';
  
  public static function init($domain)
  {
    self::$logfile = new parent(rex_path::log('project_manager_plus_'.$domain.'_last.log'), 100000);      
  }
  
  public static function log($logstr, $logname = 'Projekt Manager')
  {    
    $data = [
      date(self::DATE_FORMAT, time()),
      $logname,
      $logstr
    ];
    
    self::$logfile->add($data);
  }
  
  public static function getPath($domain)
  {
    return rex_path::log('project_manager_plus_'.$domain.'_last.log');
  }
  
  public static function deleteFile($domain)
  {
    rex_file::delete(rex_path::log('project_manager_plus_'.$domain.'_last.log'));;
  }
  
  public static function close()
  {
    self::$logfile = null;
    self::$init = false;
  }
}
