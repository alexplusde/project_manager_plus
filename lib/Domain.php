<?php

namespace Alexplusde\PMP;

class Domain extends \rex_yform_manager_dataset
{

    const apiKey = "YOUR_HETRIXTOOLS_API_KEY";
    const monitorId = "YOUR_MONITOR_ID";

    public function getHetrixScore()
    {
        $api_key = \rex_config::get('project_manager_plus', 'hetrix_api_key');
        $url = 'https://api.hetrixtools.com/v2/' . $api_key . '/blacklist-check?host=' . $this->getDomain();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output, true);
        return $data;
    }

    // Funktion zum Abrufen der historischen Verfügbarkeitsdaten von HetrixTools
    public function getHetrixToolsHistoricalData($apiKey, $monitorId, $startDate, $endDate)
    {
        $startDate = date("Y-m-d", strtotime("-1 day"));
        $endDate = date("Y-m-d");
        $url = "https://api.hetrixtools.com/v2/$apiKey/uptime/$monitorId/?start_date=$startDate&end_date=$endDate";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        return $data;
    }


    public function getFavicon()
    {
        $protocol = ($this->isSsl() == 1) ? "https://" : "http://";
        $faviconUrl = self::getFavicon($protocol . $this->getDomain());
        if (is_array($faviconUrl)) {
            $favicon = $faviconUrl[0];
        } else {
            $favicon = $faviconUrl;
        }
        if ($favicon == 'FALSE') {
            $favicon = \rex::getServer() . '/assets/addons/project_manager_plus/favicon/redaxo-favicon.png';
        }
        return $favicon;
    }

    /** QualySSL Labs Score */
    public function getQualysSslLabsScore()
    {
        $url = 'https://www.ssllabs.com/ssltest/analyze.html?d=' . $this->getDomain();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output, true);
        return $data;
    }

    /** Mozilla Observer Score */
    public function getMozillaObserverScore()
    {
        $url = 'https://observatory.mozilla.org/analyze/' . $this->getDomain();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output, true);
        return $data;
    }

    public function getIp()
    {
        return gethostbyname(idn_to_ascii($this->getDomain(), INTL_IDNA_VARIANT_UTS46));
    }

    /* PageSpeed Score and PageSpeed Insights (all) */
    public function getPageSpeedScore()
    {
        $url = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . $this->getDomain();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output, true);
        return $data;
    }

    // Funktion zum Abrufen der SecurityHeaders Bewertung
    public function getSecurityHeadersScore($domain)
    {
        $url = "https://securityheaders.com/?q=$domain&followRedirects=on";
        $response = file_get_contents($url . '&hide=on');
        preg_match('/Grade: ([A-F])/', $response, $matches);
        return $matches[1] ?? 'N/A';
    }

    /** Lighthouse-Kennzahlen für Mobil/Desktop SEO/Barrierefreiheit/Leistung/Best Practices abrufen */
    public function getLighthouseMetrics()
    {
        $url = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . $this->getDomain();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output, true);
        return $data;
    }


    public function getDomain()
    {
        return $this->getValue('domain');
    }

    public function isSsl()
    {
        return $this->getValue('is_ssl');
    }
}
