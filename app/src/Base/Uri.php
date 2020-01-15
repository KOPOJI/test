<?php


namespace Koj\Base;


class Uri
{
    /**
     * @param $pageParams
     * @param array $deletedParams
     * @return string|string[]|null
     */
    public static function getUri($pageParams, array $deletedParams = array())
    {
        $newParams = $_GET;
        //delete params
        foreach($deletedParams as $param) {
            if(isset($newParams[$param]))
                unset($newParams[$param]);
        }

        //merge data
        if(is_array($pageParams))
            $newParams = array_merge($newParams, $pageParams);

        //get current uri
        $currentUri = preg_replace('~\\?.*$~u', '', $_SERVER['REQUEST_URI']);

        //build uri
        $uri = http_build_query($newParams);

        //empty data, return current uri
        if(empty($uri) && empty($pageParams))
            return $currentUri;

        //build query string
        if(!empty($pageParams) && is_string($pageParams)) {
            if(empty($uri))
                $uri = $pageParams;
            else
                $uri .= '&' . $pageParams;
        }

        return $currentUri . '?' . $uri;
    }
}