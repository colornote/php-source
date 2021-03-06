<?php

class Map_EweiShopV2Page extends PluginMobilePage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $merchid = intval($_GPC["merchid"]);
        $store = pdo_fetch("select * from " . tablename("ewei_shop_merch_user") . " where id=:merchid and uniacid=:uniacid Limit 1", array(":uniacid" => $_W["uniacid"], ":merchid" => $merchid));
        $store["storename"] = $store["merchname"];
        $lat_num = explode(".", $store["lat"]);
        if (1 < sizeof($lat_num)) {
            $decimal = end($lat_num);
            $count = strlen($decimal);
            if (6 < $count) {
                $gcj02 = $this->Convert_BD09_To_GCJ02($store["lat"], $store["lng"]);
                $store["lat"] = $gcj02["lat"];
                $store["lng"] = $gcj02["lng"];
            }
        }
        include $this->template();
    }
    public function Convert_BD09_To_GCJ02($lat, $lng)
    {
        $x_pi = 3.14159265358979 * 3000 / 180;
        $x = $lng - 0.0065;
        $y = $lat - 0.006;
        $z = sqrt($x * $x + $y * $y) - 2.0E-5 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 3.0E-6 * cos($x * $x_pi);
        $lng = $z * cos($theta);
        $lat = $z * sin($theta);
        return array("lat" => $lat, "lng" => $lng);
    }
}

?>