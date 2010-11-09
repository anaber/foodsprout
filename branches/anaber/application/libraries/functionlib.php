<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class functionlib {
    function functionlib() {
    }

    /*
     * This function adds/removes protocol in/from the URL to make it valid one
     */
    function removeProtocolFromUrl($urlStr)
    {
        $urlStr = trim($urlStr);
        $protocolPattern = "/^http\:\/\//";
        preg_match_all($protocolPattern, $urlStr, $matches, PREG_SET_ORDER);
        foreach($matches as $matche)
        {
            $urlStr = preg_replace( $protocolPattern , "", $urlStr);
        }
        return $urlStr;
    }

}
?>
