<?php
namespace app\components\utils\detect;

use Yii;
use app\components\utils\detect\Mobile_Detect;
use app\components\utils\detect\DBIP;

class KDetect
{
    public static function getDevice()
    {
        $detect = new Mobile_Detect;
        //device, platform, browser
        $platform = $browser = '';
        $device = ($detect->isMobile() ? ($detect->isTablet() ? 'Tablet' : 'Mobile') : 'PC');

        if ($device == 'PC') {
            $platform = self::detectPlatformPC($detect->getUserAgent());
            if (preg_match("/Trident\/7.0;(.*)rv:11.0/", $detect->getUserAgent(), $match) != 0) {
                $browser = 'IE';
            } else {
                $browser = self::detectBrowserPC($detect->getUserAgent());
            }
        } else {
            $operating_systems = $detect->getOperatingSystems();

            foreach ($operating_systems as $name => $regex) {
                if ($detect->{'is' . $name}()) {
                    $platform = $name;
                    break;
                }
            }
            $version = $detect->version($platform);
            $platform .= ($platform != '') ? $version : '';		

            $all_browsers = $detect->getBrowsers();
            foreach ($all_browsers as $name => $regex) {
                if ($detect->{'is' . $name}()) {
                    $browser = $name;
                    break;
                }
            }
        }

        $version = $detect->version($browser);


        return array(
            'device' => $device,
            'platform' => $platform,
            'browser' => $browser,
            'version' => $version,
        );
    }
    
    public static function detectBrowserPC($user_agent) {
        if (preg_match('/MSIE/i', $user_agent)) {
            $platform = 'IE';
        } elseif (preg_match('/Firefox/i', $user_agent)) {
            $platform = 'Firefox';
        } elseif (preg_match('/Chrome/i', $user_agent)) {
            $platform = 'Chrome';
        } elseif (preg_match('/Safari/i', $user_agent)) {
            $platform = 'Safari';
        } elseif (preg_match('/Opera/i', $user_agent)) {
            $platform = 'Opera';
        } elseif (preg_match('/Netscape/i', $user_agent)) {
            $platform = 'Netscape';
        } else {
            $platform = Yii::t('GLB:Abbr', 'N/A');
        }
        return $platform;
    }
    
    public static function detectPlatformPC($user_agent) {
        if (preg_match('/Windows NT 6.3/i', $user_agent)) {
            $platform = 'Windows 8.1';
        } elseif (preg_match('/Windows NT 6.2/i', $user_agent)) {
            $platform = 'Windows 8';
        } elseif (preg_match('/Windows NT 6.1/i', $user_agent)) {
            $platform = 'Windows 7';
        } elseif (preg_match('/Windows NT 6.0/i', $user_agent)) {
            $platform = 'Windows Vista';
        } elseif (preg_match('/Windows NT 5.2/i', $user_agent)) {
            $platform = 'Windows Server 2003/XP x64';
        } elseif (preg_match('/Windows NT 5.1|Windows xp/i', $user_agent)) {
            $platform = 'Windows XP';
        } elseif (preg_match('/Windows NT 5.0/i', $user_agent)) {
            $platform = 'Windows 2000';
        } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
            $platform = 'Mac';
        } elseif (preg_match('/linux/i', $user_agent)) {
            $platform = 'Linux';
        } elseif (preg_match('/ubuntu/i', $user_agent)) {
            $platform = 'Ubuntu';
        } else {
            $platform = Yii::t('GLB:Abbr', 'N/A');
        }
        return $platform;
    }
    
    public static function getCityIP($ip)
    {
        $default = 'UNKNOWN';

        if (!is_string($ip) || strlen($ip) < 1 || $ip == '::1' || $ip == 'localhost') {
            return $default;
        }
        try {
            // Connect to the database
            $db = new \PDO(Yii::$app->db->dsn, Yii::$app->db->username, Yii::$app->db->password);

            // Instanciate a new DBIP object with the database connection
            $dbip = new DBIP($db);

            // Lookup an IP address
            $inf = $dbip->Lookup($ip);

            // Show the associated country
            return $inf;

        } catch (DBIP_Exception $e) {
            return $default;
        }
    }

    public static function getCountryIP($ip) 
    {
        $default = 'UNKNOWN';

        if (!is_string($ip) || strlen($ip) < 1 || $ip == '::1' || $ip == 'localhost') {
            return $default;
        }
        try {
            // Connect to the database
            $db = new \PDO(Yii::$app->db->dsn, Yii::$app->db->username, Yii::$app->db->password);

            // Instanciate a new DBIP object with the database connection
            $dbip = new DBIP($db);

            // Lookup an IP address
            $inf = $dbip->Lookup($ip);

            // Show the associated country
            //echo "country = " . $inf->country . "\n";
            return $inf->country;

        } catch (DBIP_Exception $e) {
            return $default;	
        }
    }

    public static function isCrawler()
    {
        //return preg_match('/bot|crawl|slurp|spider/i', Yii::$app->request->userAgent);

        return (boolean)Yii::$app->request->get('crawler', 0);
    }
}