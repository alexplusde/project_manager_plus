<?php

namespace Alexplusde\PMP\Cronjob;

use Alexplusde\PMP\Logger;
use rex_sql;
use rex_cronjob;
use rex;
use rex_i18n;

class Client extends rex_cronjob
{

    public function execute()
    {
        $websites = rex_sql::factory()->setDebug(0)->getArray('SELECT * FROM ' . rex::getTable('project_manager_plus_domain') . ' ORDER BY updatedate asc');

        /* Addon-Abruf */
        $multi_curl = curl_multi_init();
        $resps = array();
        $options = array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_HEADER         => false,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0',
            CURLOPT_TIMEOUT => 5 // seconds
        );
        foreach ($websites as $website) {
          
            $domain = $website['domain'];
            $cms = $website['cms'];
            $ssl = $website['is_ssl'];
            $param = $website['param'];
            $param = explode(',', $param);
            $param = '&'.implode('&', $param);
            $protocol = ($ssl == 1) ? "https://" : "http://";
            
            $timestamp = time();
            
            $url = $protocol.urlencode($domain)."/index.php?rex-api-call=project_manager_plus&api_key=".$website['api_key'].'&t='.$timestamp.$param;
            
            if ($cms == 5) {
                $url = $protocol.urlencode($domain)."/index.php?rex-api-call=project_manager_plus&api_key=".$website['api_key'].'&t='.$timestamp.$param;
            }
            
            $resps[$domain] = curl_init($url);
            curl_setopt_array($resps[$domain], $options);
            curl_multi_add_handle($multi_curl, $resps[$domain]);
            
        }
        
        $active = null;
        
        do {
            $mrc = curl_multi_exec($multi_curl, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        
        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($multi_curl) != -1) {
                do {
                    $mrc = curl_multi_exec($multi_curl, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }
        
      

        foreach ($resps as $domain => $response) {
          
            $resp = curl_multi_getcontent($response);
            curl_multi_remove_handle($multi_curl, $response);
            
            $json = json_decode($resp, true);
            $json_result = json_encode($json);
                        
            Logger::deleteFile($domain);
            Logger::init($domain);
            Logger::log($domain . ' Abruf gestartet', 'Project Manager Server');
            Logger::log($json_result . ' -> Response', 'Project Manager Server');
            
            $project_manager_plus_domain = rex_sql::factory()->setDebug(0)->getArray('SELECT * FROM ' . rex::getTable('project_manager_plus_domain') . ' WHERE domain = ? LIMIT 1', [$domain]);
            
            if (json_last_error() === JSON_ERROR_NONE && $json !== null) {
              
                if ($json['status'] == 1) {
                
                    rex_sql::factory()->setDebug(0)->setQuery('DELETE FROM ' . rex::getTable('project_manager_plus_logs') . ' WHERE domain_id = ?', [$project_manager_plus_domain[0]['id']]);
                
                    rex_sql::factory()->setDebug(0)->setQuery('INSERT INTO ' . rex::getTable('project_manager_plus_logs') . ' (`domain_id`, `createdate`, `raw`) VALUES(?,NOW(),?)', [$project_manager_plus_domain[0]['id'],  $resp]);
                    // SET STATUS
                    rex_sql::factory()->setDebug(0)->setQuery("UPDATE " . rex::getTable('project_manager_plus_domain') . " SET status = ?, updatedate = NOW() WHERE id = ?", [1, $project_manager_plus_domain[0]['id']]);
                
                    //WRITE LOGFILE
                    Logger::log('Status 1', 'Project Manager Server');
                
                
                } else {
                    // SET STATUS
                    rex_sql::factory()->setDebug(0)->setQuery("UPDATE " . rex::getTable('project_manager_plus_domain') . " SET status = ?, updatedate = NOW()WHERE id = ?", [0, $project_manager_plus_domain[0]['id']]);
                
                    // WRITE LOGFILE
                    Logger::log('Status 0', 'Project Manager Server');
                
                }
              
            } else {
               
                // SET STATUS
                rex_sql::factory()->setDebug(0)->setQuery("UPDATE " . rex::getTable('project_manager_plus_domain') . " SET status = ?, updatedate = NOW() WHERE id = ?", [-1, $project_manager_plus_domain[0]['id']]);
               
                //WRITE LOGFILE
                Logger::log('Status -1', 'Project Manager Server');
               
               
            }
            
            rex_sql::factory()->setDebug(0)->setQuery("UPDATE " . rex::getTable('project_manager_plus_domain') . " SET updatedate = NOW() WHERE id = ?", [$project_manager_plus_domain[0]['id']]);
            
            //WRITE LOGFILE
            

        }
        
        curl_multi_close($multi_curl);

        return true;

    }
    public function getTypeName()
    {
        return rex_i18n::msg('project_manager_plus_cronjob_data_name');
    }

    public function getParamFields()
    {
        return [];
    }
}
