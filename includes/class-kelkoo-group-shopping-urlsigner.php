<?php

/**
 * KelkooGroupShoppingUrlSigner is used to sign URL to Kelkoo web-services
 *
 * @author Kelkoo group
 */
class KelkooGroupShoppingUrlSigner {

    public static function signUrl($urlDomain, $urlPath, $trackingId = null, $accessKey = null, $country = null) {
        if (!$trackingId || !$accessKey || !$country) {
            $options = get_option('kelkoo-group-shopping');
        }

        $trackingId = $trackingId ? $trackingId : $options['trackingId'];
        $accessKey = $accessKey ? $accessKey : $options['accessKey'];
        $country = $country ? $country : $options['country'];

        return self::signUrlTime($urlDomain, $urlPath, time(), $trackingId, $accessKey, $country);
    }
    
    public static function signUrlTime($urlDomain, $urlPath, $time, $trackingId, $accessKey, $country) {
        
        $fistParamGlue = strpos($urlPath, '?')!==false ? '&':'?';
        
        $URLtmp = str_replace(' ', '+', $urlPath) 
           . $fistParamGlue.'country=' . $country
           . '&trackingId=' . $trackingId
           . '&timestamp=' . $time;

        $s = $URLtmp . $accessKey;
        $t = base64_encode(pack('H*', md5($s)));
        $tokken = str_replace(array("+", "/", "="), array(".", "_", "-"), $t);

//        error_log($urlDomain . $URLtmp . "&hash=" . $tokken);

        return $urlDomain . $URLtmp . "&hash=" . $tokken;
        
    }

    public static function customSignForTest($urlDomain, $urlPath, $time, $trackingId, $accessKey) {

        $fistParamGlue = strpos($urlPath, '?')!==false ? '&':'?';

        $URLtmp = str_replace(' ', '+', $urlPath)
           . $fistParamGlue
           . 'timestamp=' . $time;

        $s = $URLtmp . $accessKey;
        $t = base64_encode(pack('H*', md5($s)));
        $tokken = str_replace(array("+", "/", "="), array(".", "_", "-"), $t);

        return $urlDomain . $URLtmp . "&hash=" . $tokken;

    }

}
