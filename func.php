<?php 
if(!defined('APP_PATH')) exit();

function get_crypt_key(){
	$file = 'crypt_key.php';
	// 没有写权限
	if(!is_writable($file)){
		return '123456!@#$%^&*()';
	}else{
		$key = ltrim(file_get_contents($file), '<?php');
		$key = trim($key);
		if(empty($key)){
			$key = '#'.rand_str();
			file_put_contents($file, '<?php '.$key, LOCK_EX);
		}
		return $key;
	}
}

function rand_str(){
    $strtolower='abcdefghijklmnopqrstuvwxyz';
    $strtoupper='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $number='0123456789';
    $password = '';
    for ( $i = 0; $i < 4; $i++ ) {   
        $password .= $strtolower[ mt_rand(0, strlen($strtolower) - 1) ];  
    } 
    for ( $i = 0; $i < 4; $i++ ) {   
        $password .= $strtoupper[ mt_rand(0, strlen($strtoupper) - 1) ];  
    } 
    for ( $i = 0; $i < 4; $i++ ) {   
        $password .= $number[ mt_rand(0, strlen($number) - 1) ];  
    }
    return $password;
}

function encryptRC2($str) {
    $k = get_crypt_key();
    $len = strlen($str);
    $mod = $len % 8;
    if ($mod != 0)
        $str8 = str_repeat(chr(ord(8 - $mod) - 0x30), 8 - $mod);
    else
        $str8 = str_repeat(chr(0x08), 8);
    $str .= $str8;
    $iv = str_repeat(chr(0x00), 8);
    $code = openssl_encrypt($str, 'RC2-40-CBC', $k, 39, $iv);
    return base64_encode($code);
}

function decryptRC2($str) {
    $k = get_crypt_key();
    $iv = str_repeat(chr(0x00), 8);
    $code = openssl_decrypt(base64_decode($str), 'RC2-40-CBC', $k, 39, $iv);
    $code = str_replace(chr(ord(1) - 0x30), '', str_replace(chr(ord(2) - 0x30), '', str_replace(chr(ord(7) - 0x30), '', str_replace(chr(ord(3) - 0x30), '', str_replace(chr(ord(4) - 0x30), '', str_replace(chr(ord(5) - 0x30), '', str_replace(chr(ord(6) - 0x30), '', str_replace(chr(ord(7) - 0x30), '', str_replace(chr(0x08), '', str_replace(PHP_EOL, '', $code))))))))));
    return $code;
}

function json($data = null, $http_code = 200){
	if (!headers_sent()) {
        // 发送状态码
        http_response_code($http_code);
        // 发送头部信息
        header("status: ".$http_code);
    }
    // 跨域设置
    if(CROSS_DOMAIN){
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 1800");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With, access-token");
        header("Access-Control-Allow-Origin: *");
    }
    if(is_array($data)){
    	echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }else{
		echo (string)$data;
    }
    if (function_exists('fastcgi_finish_request')) {
        // 提高页面响应
        fastcgi_finish_request();
    }
    exit;
}

function http_method(){
    return strtoupper($_SERVER['REQUEST_METHOD']) ?: 'GET';
}

function get_token(){
    $header = c_get_headers();
    return $header['access-token'] ?: '';
}

function c_get_headers(){
    if (function_exists('apache_request_headers') && $result = apache_request_headers()) {
        $header = $result;
    } else {
        $header = [];
        $server = $_SERVER;
        foreach ($server as $key => $val) {
            if (0 === strpos($key, 'HTTP_')) {
                $key          = str_replace('_', '-', strtolower(substr($key, 5)));
                $header[$key] = $val;
            }
        }
        if (isset($server['CONTENT_TYPE'])) {
            $header['content-type'] = $server['CONTENT_TYPE'];
        }
        if (isset($server['CONTENT_LENGTH'])) {
            $header['content-length'] = $server['CONTENT_LENGTH'];
        }
    }
    $header = array_change_key_case($header);
    return $header;
}

function is_ssl(){
    if ($_SERVER['HTTPS'] && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))) {
        return true;
    } elseif ('https' == $_SERVER['REQUEST_SCHEME']) {
        return true;
    } elseif ('443' == $_SERVER['SERVER_PORT']) {
        return true;
    } elseif ('https' == $_SERVER['HTTP_X_FORWARDED_PROTO']) {
        return true;
    }
    return false;
}

function domain(){
    return (is_ssl() ? 'https://' : 'http://') . strval($SERVER['HTTP_X_FORWARDED_HOST'] ?: $_SERVER['HTTP_HOST']) . $_SERVER['SCRIPT_NAME'];
}

function get_client_ip(){
    $onlineip = '';
    if(!empty($_SERVER['REMOTE_ADDR'])){
        $onlineip = $_SERVER['REMOTE_ADDR'];
    }else if(getenv('HTTP_CLIENT_IP')) { 
        $onlineip = getenv('HTTP_CLIENT_IP');
    } else if(getenv('HTTP_X_FORWARDED_FOR')) { 
        $onlineip = getenv('HTTP_X_FORWARDED_FOR');
    } else if(getenv('REMOTE_ADDR')) { 
        $onlineip = getenv('REMOTE_ADDR');
    } else { 
        $onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
    }
    if(!filter_var($onlineip, FILTER_VALIDATE_IP)){
        $onlineip = '0.0.0.0';
    }
    return $onlineip;
}

function basecurl($action = '', $data = [], $header = [], $request = 'POST', $timeout = 120){
    if(!empty(API_URL) && strpos(API_URL, 'https://') !== 0 && strpos(API_URL, 'http://') !== 0){
        return ['code'=>500, 'data'=>['error'=>'接口访问失败,配置地址格式错误']];
    }
    if(empty(API_URL)){
        $url = (is_ssl() ? 'https://' : 'http://') . strval($SERVER['HTTP_X_FORWARDED_HOST'] ?: $_SERVER['HTTP_HOST']) . '/user/v1/'.$action;
    }else{
        $url = rtrim(API_URL, '/') . '/user/v1/'.$action;
    }
    $request = strtoupper($request);
    $curl = curl_init();
    if($request == 'GET'){
        $s = '';
        $s = http_build_query($data);
        // if(!empty($data)){
        //     foreach($data as $k=>$v){
        //         $s .= $k.'='.urlencode($v).'&';
        //     }
        // }
        if($s){
            $s = '?'.trim($s, '&');
        }
        curl_setopt($curl, CURLOPT_URL, $url.$s);
    }else{
        curl_setopt($curl, CURLOPT_URL, $url);
    }
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    if($request == 'GET'){
        curl_setopt($curl, CURLOPT_HTTPGET, 1);
    }else if($request == 'POST'){
        curl_setopt($curl, CURLOPT_POST, 1);
        if(is_array($data)){
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }else{
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
    }else if($request == 'PUT' || $request == 'DELETE'){
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request);
        if(is_array($data)){
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }else{
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
    }
    if(!empty($header)){
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }
    $content = curl_exec($curl);
    $error = curl_error($curl);
    if(!empty($error)){
    	// if(APP_DEBUG){
            return ['code'=>500, 'data'=>['error'=>'curl_error:'.$error]];
    	// }else{
     //        return ['code'=>500, 'data'=>['error'=>'接口访问失败']];
    	// }
    }
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if($http_code >= 400 || $http_code < 200){
    	$content = json_decode($content, true);
    	if(isset($content['error'])){
    		return ['code'=>$http_code, 'data'=>$content];
    	}else{
    		return ['code'=>500, 'data'=>['error'=>'接口访问失败,HTTP状态码:'.$http_code]];
    	}
    }
    // 直接返回
	return ['code'=>$http_code, 'data'=>$content];
}

if(!function_exists('str_ends_with')){
    function str_ends_with(string $haystack, string $needle): bool{
        return 0 === substr_compare($haystack, $needle, -strlen($needle));
    }
}
