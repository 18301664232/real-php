<?php

/**
 * Created for moneplus.
 * User: tonghe.wei@moneplus.cn
 * Date: 2016/8/18
 * Time: 15:38
 */
class STD3DesServer extends BaseServer {

    public $key = "moneplus.cns";
    public $iv = "snc.moneplus";

    /**
     * 构造，传递二个已经进行base64_encode的KEY与IV
     *
     * @param string $key
     * @param string $iv  必须是8位向量
     */
//    function  __construct ($key,$iv)
//    {
//        if (empty($key)) {
//            echo 'key and iv is not valid';
//            exit();
//        }
//        $this->key = $key;
//        $this->iv =$iv ;
//    }

    private static function Obj() {
        $obj = new STD3DesServer;
        return $obj;
    }

    /**
     * 加密
     * @param <type> $value
     * @return <type>
     */
    public static function encrypt($value, $unsetFiled = []) {
        $obj = self::Obj();

        if (empty($value))
            return $value;
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if (in_array($k, $unsetFiled))
                    continue;
                $value[$k] = self::encrypt($v, $unsetFiled);
            }
            return $value;
        }elseif (is_string($value)) {
            $td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
            $iv = base64_decode($obj->iv);
            $value = self::PaddingPKCS7($value);
            $key = base64_decode($obj->key);
            mcrypt_generic_init($td, $key, $iv);
            $ret = base64_encode(mcrypt_generic($td, $value));
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            return $ret;
        } else {
            return $value;
        }
    }

    /**
     * 解密
     * @param <type> $value
     * @return <type>
     */
    public static function decrypt($value, $unsetFiled = []) {
        $obj = self::Obj();

        if (empty($value))
            return $value;
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if (in_array($k, $unsetFiled))
                    continue;
                $value[$k] = self::decrypt($v, $unsetFiled);
            }
            return $value;
        }elseif (is_string($value)) {
            $td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
            $iv = base64_decode($obj->iv);
            $key = base64_decode($obj->key);
            mcrypt_generic_init($td, $key, $iv);
            $ret = trim(mdecrypt_generic($td, base64_decode($value)));
            $ret = self::UnPaddingPKCS7($ret);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            return $ret;
        } else {
            return $value;
        }
    }

    private static function PaddingPKCS7($data) {
        $block_size = mcrypt_get_block_size('tripledes', 'cbc');
        $padding_char = $block_size - (strlen($data) % $block_size);
        $data .= str_repeat(chr($padding_char), $padding_char);
        return $data;
    }

    private static function UnPaddingPKCS7($text) {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, - 1 * $pad);
    }

}
