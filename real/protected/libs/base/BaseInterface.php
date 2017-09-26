<?php

/**
 * 接口基类
 */
class BaseInterface extends CComponent {

    /**
     * curl 访问接口
     *
     * @param string   $url            url
     * @param array    $post           是否为post访问
     * @param int      $timeout        访问限时
     * @param string   $decode			是否自动解析成数据
     * 
     */
    public static function curlOpen($url, $post = '', $timeout = 30, $decode = 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //The URL to fetch.
        curl_setopt($ch, CURLOPT_HEADER, 0); //TRUE to include the header in the output.
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1); //TRUE to do a regular HTTP POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post); //The full data to post in a HTTP "POST" operation.
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); //TRUE to return the raw output
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); //The maximum number of seconds to allow CURL functions to execute.

        $data = curl_exec($ch);
        curl_close($ch);

        if ($decode == 1 && !is_null(json_decode($data))) {
            $data = json_decode($data, true);
        }

        return $data;
    }

    public static function postCurl($url, $post = '', $json = false, $timeout = 30) {
        $header = array(
            'Content-Type: application/json',
            'Content-Length:' . strlen($post),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //The URL to fetch.
        curl_setopt($ch, CURLOPT_HEADER, 0); //TRUE to include the header in the output.
        //post
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        if ($json)
            return json_decode($data, true);
        return $data;
    }

}
