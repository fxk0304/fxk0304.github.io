<?php
ini_set("error_reporting", "E_ALL & ~E_NOTICE");
header("Content-type: text/html;charset=utf-8");
date_Default_TimeZone_set("PRC");
$CS_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

//*******************************标题&联系*******************************//

$title = "畅享音乐";//网站标题
$QQ = "QQ: 2591049906";//网站底部联系方式

//*******************************标题&联系*******************************//




$error = "<script>alert('地址错误!');'</script>";
if (isset($_GET['v'])) {
//*******************************播放页面*******************************//
    echo '<script>alert(\'地址错误!\');\'</script>';
    $de64 = base64_decode($_GET['v']);//解码
    $expl = explode('$', $de64);//分割字符
    $le = $expl[0];
    $id = $expl[1];
    switch ($le) {
        case "kg":
            //*******************************音乐播放页面*******************************//
            $p3_url = "http://m.kugou.com/app/i/getSongInfo.php?hash=" . $id . "&cmd=playInfo";
            $p3_data = curl_get($p3_url);//获取源代码
            $p3_json = json_decode($p3_data, true);//解析数据
            $song_url = $p3_json['url'];//提取每首歌的url，
            if (empty($song_url)) {
                exit($error);
            }
            $song_name = $p3_json['fileName'];
            $title = $song_name . ",在线试听," . $title;
            $album_img = $p3_json['album_img'];
            $imgUrl = $p3_json['imgUrl'];
            if (empty($imgUrl)) {
                $imgUrl = $album_img;
            }
            $song_img = str_replace("{size}", "400", $imgUrl);
            $main = "<div class=\"main\"><div style=\"float:left;width:560px;\"><div style=\"height:140px;border-bottom:1px dashed #ccc;\"><div style=\"float:left;width:390px;\"><h2 style=\"margin-bottom:10px;width:370px;white-space:nowrap;overflow:hidden;\">" . $song_name . "<p style=\"text-align:center;margin-bottom:7px;\"><audio controls=\"controls\" autoplay=\"autoplay\" loop=\"loop\" style=\"width:250px;\"><source src=\"" . $song_url . "\" type=\"audio/mp3\" /><embed width=\"250\" height=\"30\" src=\"" . $song_url . "\" /></embed></audio><input style=\"width:0px;height:0px;border:0px\" type=\"text\" id=\"copy_value\" value=\"" . $song_url . "\" readonly=\"readonly\"></p></div><div style=\"float:right\"><a href=\"http://tao.yeser.cc\" target=\"_blank\"><img class=\"z360z\" src=\"" . $song_img . "\" width=\"120px\" height=\"120px\"></a></div></div><div><div id=\"bdshare\" class=\"bdshare_t bds_tools_32 get-codes-bdshare\"><a class=\"bds_qzone\"></a><a class=\"bds_tsina\"></a><a class=\"bds_tqq\"></a><a class=\"bds_mail\"></a><a class=\"bds_baidu\"></a><a class=\"bds_tqf\"></a><a class=\"bds_qq\"></a><a class=\"bds_mshare\"></a><a class=\"bds_douban\"></a><a class=\"bds_renren\"></a><a class=\"bds_t163\"></a><a class=\"bds_kaixin001\"></a><a class=\"bds_hi\"></a><a class=\"bds_copy\"></a></div></div></div><div style=\"float:right;width:300px;padding:10px;overflow-y:auto;height:200px;border-left:1px dashed #ccc;\">" . song_lrc($id) . "</div></div>";
            break;
        case "mv":
            //*******************************视频播放页面*******************************//
            $x_url = "http://m.kugou.com/app/i/mv.php?cmd=100&ext=mp4&hash=" . $id;
            $data = curl_get($x_url);
            preg_match('/songname":"(.*?)",/is', $data, $nm2);
            preg_match('/singer":"(.*?)",/is', $data, $nm1);
            preg_match_all('/downurl":"(.*?)",/is', $data, $mp4);
            preg_match_all('/backupdownurl":\["(.*?)"\]/is', $data, $bmp4);
            $song_name = $nm1[1] . " - " . $nm2[1];
            $mv_url = stripslashes($mp4[1][0]);//返回一个去除转义反斜线后的字符串（\' 转换为 ' 等等）。双反斜线（\\）被转换为单个反斜线（\）。
            if (empty($mv_url)) {
                exit($error);
            }
            $title = $song_name . ",mv视频在线观看," . $title;

            for ($i = 0; $i < 3; $i++) {
                $downurla = stripslashes($mp4[1][$i]);
                $downurlb = stripslashes($bmp4[1][$i]);
                if ($downurla) {
                    $down .= "";
                }
            }
            $main = "<script type=\"text/javascript\"> function player(url) { var frameid = Math.random(); window.webmvplayer = '<embed id=\"webmvplayer\" name=\"webmvplayer\" src=\"http://static.kgimg.com/common/swf/video/videoPlayer.swf\" height=\"360\" width=\"560\" allowscriptaccess=\"always\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" flashvars=\"skinurl=http%3a%2f%2fstatic.kgimg.com%2fcommon%2fswf%2fvideo%2fskin.swf&amp;aspect=true&amp;url='+url+'&amp;autoplay=true&amp;fullscreen=true&amp;initfun=flashinit\" type=\"application/x-shockwave-flash\" wmode=\"Transparent\" allowfullscreen=\"true\"></embed><script>window.onload = function() { parent.document.getElementById(\''+frameid+'\').height = document.getElementById(\'webmvplayer\').height+\'px\'; }<'+'/script>';	document.write('<iframe id=\"'+frameid+'\" src=\"javascript:parent.webmvplayer;\" frameBorder=\"0\" scrolling=\"no\" width=\"100%\" frameborder=\"0\" vsspace=\"0\" hspace=\"0\" marginwidth=\"0\" marginheight=\"0\" ></iframe>'); } </script><div class=\"main\"><div style=\"float:left;width:560px;\"><h2 style=\"margin-bottom:10px;width:550px;white-space:nowrap;overflow:hidden;\">" . $song_name . "</h2><script type=\"text/javascript\">player('" . $mv_url . "');</script><div style=\"height:35px;line-height:35px;\"><div id=\"bdshare\" class=\"bdshare_t bds_tools_32 get-codes-bdshare\"><a class=\"bds_qzone\"></a><a class=\"bds_tsina\"></a><a class=\"bds_tqq\"></a><a class=\"bds_mail\"></a><a class=\"bds_tqf\"></a><a class=\"bds_mshare\"></a><a class=\"bds_douban\"></a><a class=\"bds_renren\"></a><a class=\"bds_t163\"></a><a class=\"bds_hi\"></a><a class=\"bds_copy\"></a></div><a href=\"http://player.youku.com/embed/XMjk4MDE3MTIwMA\" target=\"_blank\"></a></div>";
            break;
        default:
            exit($error);
    }
    $main .= random() . mv();
} elseif (isset($_GET['p'])) {
//*******************************列表页面*******************************//
    $l = $_GET['p'];
    switch ($l) {
        case "1":
            $title = "恋爱的歌，献给热恋中的你们，让爱情变得更加甜美！";
            $url = "http://mobilecdn.kugou.com/api/v3/rank/song?pagesize=300&rankid=67&page=1";
            break;
        case "2":
            $title = "TOP排行榜，平民化的音乐和歌手，让音乐更贴近你的生活！";
            $url = "http://mobilecdn.kugou.com/api/v3/rank/song?pagesize=300&rankid=8888&page=1";
            break;
        case "3":
            $title = "DJ舞曲，一首首HIGH翻天，让你犹如亲临迪斯科现场！";
            $url = "http://mobilecdn.kugou.com/api/v3/rank/song?pagesize=300&rankid=70&page=1";
            break;
        default:
            exit($error);
    }
    $main = "<div class=\"main\"><div style=\"float:left;\">" . $title . "</div></div>";
    $data = curl_get($url);
    $json = json_decode($data, true);
    $main .= "<div class=\"main\"><ul style=\"overflow:hidden;\">";
    $count_json = count($json['data']['info']);
    for ($i = 0; $i < $count_json; $i++) {
        $name = $json['data']['info'][$i]['filename'];
        $hash = $json['data']['info'][$i]['hash'];
        $href = str_replace("=", "", base64_encode("kg$" . $hash));
        $main .= "<li style=\"line-height:30px;height:30px;float:left;width:210px;margin:0 10px;white-space:nowrap;overflow:hidden;\" onmouseover=\"this.style.backgroundColor='#eee'\" onmouseout=\"this.style.backgroundColor='' \" ><a href=\"?v=" . $href . "\" target=\"_blank\" title=\"" . $name . "\">" . $name . "</a></li>";
    }
    $main .= "</ul></div>";
} elseif (isset($_GET['ac'])) {
//*******************************搜索页面*******************************//
    $w = htmlspecialchars($_GET['ac']);
    $title = $w . "的搜索结果," . $title;
    $url = "http://mobilecdn.kugou.com/api/v3/search/song?format=jsonp&keyword=" . $w . "&page=1";
    $mv_url = "http://mvsearch.kugou.com/mv_search?keyword=" . urlencode($w) . "&page=1&pagesize=30&userid=489797698&platform=WebFilter&tag=em&filter=2&iscorrection=1&privilege_filter=0";
    $data = curl_get($url);
    $mv_data = curl_get($mv_url);
    preg_match_all('/"filename":"(.*?)","/is', $data, $nm);
    preg_match_all('/"hash":"(.*?)","/is', $data, $ha);
    preg_match_all('/"FileName":"(.*?)","/is', $mv_data, $mv_nm);
    preg_match_all('/"MvHash":"(.*?)","/is', $mv_data, $mv_ha);
    preg_match_all('/"Pic":"(.*?)","/is', $mv_data, $mv_im);
    $count = count($ha['1']);
    if (empty($count)) {
        exit("<script>alert('没有找到任何资料!');top.location.href='" . $_SERVER["HTTP_REFERER"] . "'</script>");
    }
    $main = "<div class=\"main\">关键词：【<font color='red'>" . $w . "</font>】的搜索结果</div><div class=\"main\"><ul style=\"overflow:hidden;\">";
    for ($i = 0; $i < $count; $i++) {
        $nnmm = $nm['1'][$i];
        $name = str_ireplace($w, "<font color='red'>" . $w . "</font>", $nnmm);//关键字红色显示
        $hash = $ha['1'][$i];
        $href = str_replace("=", "", base64_encode("kg$" . $hash));
        $main .= "<li style=\"line-height:30px;height:30px;float:left;width:210px;margin:0 10px;white-space:nowrap;overflow:hidden;\" onmouseover=\"this.style.backgroundColor='#eee'\" onmouseout=\"this.style.backgroundColor=''\"><a href=\"?v=" . $href . "\" target=\"_blank\" title=\"" . $nm1 . "\">" . $name . "</a></li>";
    }
    $main .= "</ul></div>";
    $main .= "<div class=\"main\"><div class=\"mv_list\"><ul>";
    for ($c = 0; $c < 28; $c++) {
        $gq = stripslashes($mv_nm[1][$c]);
        $mpic = "http://imge.kugou.com/mvhdpic/240/" . substr($mv_im[1][$c], 0, 8) . "/" . $mv_im[1][$c];
        $hash = $mv_ha[1][$c];
        $href = str_replace("=", "", base64_encode("mv$" . $hash));
        if ($gq) {
            $main .= "<li><a href=\"?v=" . $href . "\" target=\"_blank\"><img src=\"" . $mpic . "\" title=\"" . $gq . "\"><span class=\"mv_name\">&nbsp;" . $gq . "</span></a><span><a href=\"?v=" . $href . "\" target=\"_blank\">" . $gq . "</a></span></li>";
        }
    }
    $main .= "</ul></div></div>";
} elseif (isset($_GET['m'])) {
//*******************************MV页面*******************************//
    $p = $_GET['m'];
    if (preg_match("/^\+?[1-9][0-9]*$/", $p)) {
        $mvurl = "http://www.kugou.com/mvweb/html/index_9_" . $p . ".html";
        $data = curl_get($mvurl);
    } else {
        exit($error);
    }
    preg_match('/id="mvNum">(.*?)<\/label>/is', $data, $total);
    preg_match('/class="mvlist">(.*?)<\/div>/is', $data, $mvlist);
    $num = "20";
    $nums = $total[1];
    $pnum = ceil($nums / $num);
    $Prev_page = $p - 1;   //上页
    $next_page = $p + 1;   //下页
    if ($p > $pnum) {
        exit($error);
    } elseif ($p < 2) {
        $page = "<a class=\"btn\">上一页</a>&nbsp;&nbsp;<a href=\"?m=" . $next_page . "\" class=\"btn\">下一页</a>";
    } elseif ($p > $pnum - 1) {
        $page = "<a href=\"?m=" . $Prev_page . "\" class=\"btn\">上一页</a>&nbsp;&nbsp;<a class=\"btn\">下一页</a>";
    } else {
        $page = "<a href=\"?m=" . $Prev_page . "\" class=\"btn\">上一页</a>&nbsp;&nbsp;<a href=\"?m=" . $next_page . "\" class=\"btn\">下一页</a>";
    }
    $main = "<div class=\"main\"><div style=\"float:left;\">热舞MV大放送！给你意想不到的试听盛宴！</div><div style=\"float:right;\"><a class=\"btn\">共" . $pnum . "页</a>&nbsp;&nbsp;<a class=\"btn\">第" . $p . "页</a>&nbsp;&nbsp;" . $page . "&nbsp;&nbsp;<span class=\"btn\" title=\"输入页数按回车健!\">电梯直达: <input type=\"text\" style=\"width:30px;\" onkeydown=\"javascript:if((event.keyCode==13)&&(!isNaN(this.value))){location='?m='+this.value;return false;}\"> 页</span></div></div>";
    $title = "热舞MV大放送 - 第" . $p . "页 " . $title;
    $main .= "<div class=\"main\"><div class=\"mv_list\"><ul>";
    preg_match_all("/<span>(.*)<\/span>/", $mvlist[1], $name);
    preg_match_all('/_src="(.*)"/', $mvlist[1], $img);
    for ($i = 0; $i < 20; $i++) {
        $gq = $name[1][$i];
        $mpic = $img[1][$i];
        $hash = substr(strrchr($mpic, "/"), 1, 32);
        $href = str_replace("=", "", base64_encode("mv$" . $hash));
        if ($mpic) {
            $main .= "<li><a href=\"?v=" . $href . "\" target=\"_blank\"><img src=\"" . $mpic . "\" title=\"" . $gq . "\"><span class=\"mv_name\">&nbsp;" . $gq . "</span></a><span><a href=\"?v=" . $href . "\" target=\"_blank\">" . $gq . "</a></span></li>";
        }
    }
    $main .= "</ul></div></div>";
} else {
    $main = mv() . bang();
}


?>