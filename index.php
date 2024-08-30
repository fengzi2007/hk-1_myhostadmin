<?php 
define('APP_DEBUG', false);
define('CROSS_DOMAIN', false);
define('APP_PATH', __DIR__);

require_once 'config.php';
require_once 'func.php';

if(APP_DEBUG){
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}else{
	error_reporting(0);
}

// if(empty(API_URL)){
// 	json(['error'=>'请配置魔方云地址'], 500);
// }
// if(version_compare(PHP_VERSION, '7.0.0') == -1){
// 	json(['error'=>'PHP版本需要7.0以上'], 500);
// }

// 判断当前请求
$method = http_method();
if(!in_array($method, ['GET','POST','PUT','DELETE'])){
	json(['error'=>'不支持的请求方式'], 400);
}

$path = trim($_GET['path'], ' /');
unset($_GET['path']);

if($method == 'GET'){
	$vars = $_GET ?: [];
}else{
	$vars = $_POST ?: [];
	if(!empty($_GET)){
		$path .= '&'.http_build_query($_GET);
	}
    if(empty($vars)){
        $data = file_get_contents("php://input");
        if(!empty($data)){
            $vars = json_decode($data, true) ?: [];
        }
        if(empty($vars)){
            $vars = [];
            if(!empty($data)){
                parse_str($data, $vars);
            }
        }
    }
}

// 获取所有请求头
$all_headers = c_get_headers();
$access_token = $all_headers['access-token'] ?: '';
$headers = [];
$headers[] = "zjmf-http-client-ip: ".get_client_ip();
if(!empty($access_token)){
	$headers[] = "access-token: ".$access_token;
}
$lang = $_GET['lang'] ?: $all_headers['think-lang'];
if(in_array($lang, ['zh-cn', 'en-us'])){
    $headers[] = "think-lang: ".$lang;
}

// 当前客户端语言
if($path === 'language' && $method == 'GET'){
    $dir = APP_PATH . '/lang';
    $country_img_dir = "common/country/";
    $handle = opendir($dir);
    $res = [];
    if($handle){
        while(($file = readdir($handle)) !== false){
            if($file != "." && $file != ".."){
                if(!is_dir("$dir/$file") && str_ends_with($file, '.js')){
                    $str = file_get_contents($dir . '/' . $file);
                    preg_match("/display_name(.+?),/", $str, $display_name_ing);
                    preg_match("/display_flag(.+?),/", $str, $display_flag_ing);
                    #data
                    $display_name = preg_replace("/:|'|,|\"/", '', $display_name_ing[1]);
                    $display_flag = preg_replace("/:|'|,|\"/", '', $display_flag_ing[1]);
                    $file_name = str_replace(strrchr($file, "."), "", $file);
                    if($file_name == 'lang'){
                        continue;
                    }
                    $display_config_now['display_name'] = trim($display_name);
                    $display_config_now['display_flag'] = trim($display_flag);
                    $display_config_now['file_name'] = trim($file_name);
                    $display_config_now['country_imgUrl'] = $country_img_dir . $display_config_now['display_flag'] . '.png';
                    $res[] = $display_config_now;
                }               
            }
        }
        closedir($handle);
    }
    json($res);
}

// vnc特殊处理
if(preg_match("#^clouds/\d+/vnc#", $path) && $method == 'POST'){
    $res = basecurl($path, $vars, $headers, $method);
    if($res['code'] == 200){
        $res_data = json_decode($res['data'], true);
        $res['data'] = [];
        if(!empty($res_data['vnc_url_http']) && !empty($res_data['vnc_url_https'])){
            // 外部vnc地址
            if(is_ssl()){
                $res['data']['url'] = $res_data['vnc_url_https'];
            }else{
                $res['data']['url'] = $res_data['vnc_url_http'];
            }
        }else{
            $res['data']['url'] = domain().'?path=novnc&token='.urlencode(encryptRC2($res_data['vnc_pass'])).'&url='.urlencode(encryptRC2($res_data['vnc_url'])).'&ip='.$res_data['ip'];
        }
    }
    json($res['data'], $res['code']);
}else if(strpos($path, 'novnc') === 0 && $method == 'GET'){
    $template = file_get_contents('./noVNC/vnc_lite.html');
    $template = str_replace(['{$vnc_token}', '{$url}', '{$host_token}', '{$ip}'], [decryptRC2($_GET['token']), decryptRC2($_GET['url']), '', $_GET['ip']], $template);

    header("content-type: text/html; charset=utf-8");
    header("status: 200");
    echo $template;exit;
}else{
    if($path == 'node_images'){
        $vars['client_hidden'] = 0;
    }else if(preg_match("#^clouds/\d+/reinstall#", $path) && $method == 'PUT'){
        if(strpos($path, '?') !== false){
            $path .= '&image_client_hidden=0';
        }else{
            $path .= '?image_client_hidden=0';
        }
    }
    $res = basecurl($path, $vars, $headers, $method);
    json($res['data'], $res['code']);
}
