<?php
/**
 * Created by PhpStorm.
 * User: hh
 * Date: 2021/6/9
 * Time: 15:12
 */
//首页视频
function mv()
{   $output="";
    $output .= "<div class=\"main\"><div class=\"mv_list\"><ul>";
    $kbang = "http://www.kugou.com/mvweb/html/index_13_" . rand(1, 100) . ".html";
//    http://www.kugou.com/mvweb/html/index_13_2.html
    $data = curl_get($kbang);
    preg_match('/class="mvlist">(.*?)<\/div>/is', $data, $mvlist);
    preg_match_all("/<span>(.*)<\/span>/", $mvlist[1], $name);
    preg_match_all('/_src="(.*)"/', $mvlist[1], $img);

    $su = rand(0, 9);
    for ($i = $su; $i < $su + 8; $i++) {
        $gq = $name[1][$i];
        $mpic = $img[1][$i];
        $hash = substr(strrchr($mpic, "/"), 1, 32);
        //$hash = basename($mpic,".jpg");
        $href = str_replace("=", "", base64_encode("mv$" . $hash));
        if ($mpic) {
            $output .= "<li><a href=\"?v=" . $href . "\" target=\"_blank\"><img src=\"" . $mpic . "\" title=\"" . $gq . "\"><span class=\"mv_name\">&nbsp;" . $gq . "</span></a><span><a href=\"?v=" . $href . "\" target=\"_blank\">" . $gq . "</a></span></li>";
        }//http://imge.kugou.com/mvpic/80/0c/800c368018b49164bad29ab07a8636ad.jpg
    }
    $output .= "</ul></div></div><a href=\"http://v.yeser.cc\" target=\"_blank\"></a>";
    return $output;
}

//var_dump(mv());
//首页歌曲
function bang()
{   $main="";
    $kbang = "http://mobilecdn.kugou.com/api/v3/rank/song?pagesize=500&rankid=6666&page=1";
    $data = curl_get($kbang);
    $json = json_decode($data, true);
    $num = $json['data']['total'];
    $time = date('Y-m-d H:i:s', $json['data']['timestamp']);
    $main .= "<div class=\"main\"><div style=\"float:left;\">网络歌曲飙升榜，这里集合网络热歌红歌！</div><div style=\"float:right;\">更新时间：" . $time . "</div></div>";
    $main .= "<div class=\"main\"><ul class=\"rule_list\">";
    for ($i = 0; $i < $num; $i++) {
        $k = $i + 1;
        $name = $json['data']['info'][$i]['filename'];
        $hash = $json['data']['info'][$i]['hash'];
        $size = $json['data']['info'][$i]['filesize'];
        $href = str_replace("=", "", base64_encode("kg$" . $hash));
        if ($hash) {
            $main .= "<li><div class=\"song\"><div class=\"aleft\"><span>" . $k . "、</span><a href=\"?v=" . $href . "\" target=\"_blank\" title=\"" . $name . "\">" . $name . "</a></div></div><div class=\"size\">" . formatsize($size) . "</div></li>";
        }
    }
    $main .= "</ul></div>";
    return $main;
}

//分页随机歌曲
function random()
{   $main="";
    $kbang = "http://mobilecdn.kugou.com/api/v3/rank/song?pagesize=500&rankid=23784&page=1";
    $data = curl_get($kbang);
    $json = json_decode($data, true);
    $num = $json['data']['total'] - 20;
    $su = rand(0, $num);
    $main .= "<div class=\"main\"><ul style=\"background:#fff;overflow:hidden;\">";
    for ($i = $su; $i < $su + 20; $i++) {
        $name = $json['data']['info'][$i]['filename'];
        $hash = $json['data']['info'][$i]['hash'];
        $href = str_replace("=", "", base64_encode("kg$" . $hash));
        if ($hash) {
            $main .= "<li style=\"line-height:30px;height:30px;float:left;width:210px;margin:0 10px;white-space:nowrap;overflow:hidden;\" onmouseover=\"this.style.backgroundColor='#eee'\" onmouseout=\"this.style.backgroundColor=''\"><a href=\"?v=" . $href . "\" target=\"_blank\" title=\"" . $name . "\">" . $name . "</a></li>";
        }
    }
    $main .= "</ul></div>";
    return $main;
}

//获取源代码
function curl_get($url)
{
    $temp = parse_url($url);//解析 URL，返回其组成部分以数组的形式
    $header = array(
        "Host: {$temp['host']}",
        "Referer: http://{$temp['host']}/"
    );
    $ch = curl_init();//初始化 cURL 会话
    curl_setopt($ch, CURLOPT_URL, $url);//获取url地址
    curl_setopt($ch, CURLOPT_HEADER, 0);//启用时会将头文件的信息作为数据流输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//true 将curl_exec()获取的信息以字符串返回，而不是直接输出。
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);//在启用CURLOPT_RETURNTRANSFER的时候，返回原生的（Raw）输出。
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//false 禁止 cURL 验证对等证书（peer'scertificate
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);//允许程序选择想要解析的 IP 地址类别。只有在地址有多种 ip 类别的时候才能用
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//设置 HTTP 头字段的数组。格式： array('Content-type: text/plain', 'Content-length: 100')
    $output = curl_exec($ch);//抓取 URL 并把它传递给浏览器
    curl_close($ch);//关闭 cURL 资源，并且释放系统资源
    return $output;
}

//歌词
function song_lrc($id)
{
    $kgid = "http://m.kugou.com/app/i/krc.php?cmd=100&timelength=243000&hash=" . $id;
    $data = curl_get($kgid);
    if ($data) {
        $href = preg_replace("/\[.*?\]/", "<br>", $data);
        $output = "<h2>歌词</h2>" . $href;
    } else {
        $output = "<a href=\"https://weidian.com/i/1964964729\" target=\"_blank\"><img src=\"http://ww3.sinaimg.cn/mw690/6b229b76jw1f8qfzhnmvrj20jg0jgdpf.jpg\" width=\"280px\" height=\"200px\"/></a>";
    }
    return $output;
}

//大小转换//
function formatsize($size)
{
    $prec = 3;
    $size = round(abs($size));
    $units = array(0 => " B ", 1 => " KB", 2 => " MB", 3 => " GB", 4 => " TB");
    if ($size == 0) return str_repeat(" ", $prec) . "0$units[0]";
    $unit = min(4, floor(log($size) / log(2) / 10));
    $size = $size * pow(2, -10 * $unit);
    $digi = $prec - 1 - floor(log($size) / log(10));
    $size = round($size * pow(10, $digi)) * pow(10, -$digi);
    return $size . $units[$unit];
}

// 将UNICODE编码后的内容进行解码，编码后的内容格式：YOKA\u738b （原始：YOKA王）
function unicode_decode($name)
{
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches)) {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++) {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0) {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code) . chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            } else {
                $name .= $str;
            }
        }
    }
    return $name;
}