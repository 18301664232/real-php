<?php

class BaseServer extends CComponent {

    //组合字段
    public static function comParams($params = array(), $condition = 'and', $nub = "-4") {
        $param = '';
        foreach ($params as $k => $v) {

            $param .="$k='$v' $condition ";
        }
        $param = substr($param, 0, $nub);

        return $param;
    }

    //组合字段2
    public static function comParams2($params = []) {
        $con = '';
        $par = [];
        foreach ($params as $k => $v) {
            $con.=$k . "=:" . $k . " and ";
            $par[":" . $k] = $v;
        }
        $con = substr($con, 0, -5);

        return ['con' => $con, 'par' => $par];
    }

}
