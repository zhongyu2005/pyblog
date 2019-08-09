<?php

namespace common\utils;

use yii;

class CommonFunc
{

    /**
     * 获取客户端ip
     * @return sting
     */
    public static function getIp()
    {
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $onlineip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }
        preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
        $ip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
        return $ip;
    }

    public static function dataToStr($data)
    {
        if (!is_array($data)) {
            $data = [$data];
        }
        $data = array_map(function ($v) {
            return strval($v);
        }, $data);
        return $data;
    }

    public static function timeOfReport($time)
    {
        $ar = [];
        $ar['time_of_min'] = date('i', $time);
        $ar['time_of_hour'] = date('H', $time);
        $ar['time_of_day'] = date('Ymd', $time);
        $ar['time_of_week'] = date('Ymd', strtotime("this week", $time));
        $ar['time_of_month'] = date('Ym', $time);
        return $ar;
    }

    public static function calcRateDiv($a, $b, $prec = 2)
    {
        $b = floatval($b);
        if (empty($b)) {
            return 0;
        }
        return round($a / $b * 100, $prec);
    }

    public static function valid($str, $type = 'tel')
    {
        switch ($type) {
            case 'tel':
                $pat = array("options" => array("regexp" => "/^\d{5,11}$/"));
                if (filter_var($str, FILTER_VALIDATE_REGEXP, $pat) === false) {
                    return false;
                }
                return true;
                break;
            case 'email':
                if (filter_var($str, FILTER_VALIDATE_EMAIL) === false) {
                    return false;
                }
                return true;
                break;
            case 'url':
                if (filter_var($str, FILTER_VALIDATE_URL) === false) {
                    return false;
                }
                return true;
                break;
        }
        return false;
    }

    public static function http($url, $data, $params = [], &$error)
    {
        $timeout = isset($params['timeout']) ? $params['timeout'] : 10;// 默认超时时间是10秒
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);//超时时间
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);//在发起连接前等待的时间，如果设置为0，则不等待
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_SSLVERSION, 1);//升级ssl
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//ssl
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//ssl
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        $UserAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36 MicroMessenger/6.5.2.501 NetType/WIFI WindowsWechat QBCore/3.43.27.400 QQBrowser/9.0.2524.400';
        if (isset($params['ua'])) {
            $UserAgent = $params['ua'];
        }
        curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
        $headers = [];
        if (isset($params['json']) && $params['json']) {
            curl_setopt($curl, CURLOPT_HEADER, 0);
            $headers[] = 'Content-Type: application/json; charset=utf-8';

        }
        //获取的信息以文件流的形式返回,不直接输出
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if (isset($params['referer'])) {
            curl_setopt($curl, CURLOPT_REFERER, $params['referer']);
        }
        if (isset($params['cookie'])) {
            curl_setopt($curl, CURLOPT_COOKIE, $params['cookie']);
        }
        if (isset($params['ip'])) {
            $ip = $params['ip'];
            $headers[] = 'CLIENT-IP:' . $ip;
            $headers[] = 'X-FORWARDED-FOR:' . $ip;
        }
        count($headers) > 0 && curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        $error['error_code'] = curl_errno($curl);
        $error['error_msg'] = curl_error($curl);
        $error['http_code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error['content_type'] = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        curl_close($curl);
        return $response;
    }

    /**
     * openssl 加密
     */
    public static function opensslEncrypt(string $post, $user)
    {
        if (empty($user['aes_key'])) {
            return $post;
        }
        $aes_key = $user['aes_key'];
        $iv = substr(base64_decode($aes_key . '='), 0, 16);
        $method = in_array($user['aes_method'], openssl_get_cipher_methods()) ? $user['aes_method'] : 'aes-128-cbc';
        $encrypt = openssl_encrypt($post, $method, $aes_key, $options = OPENSSL_RAW_DATA, $iv);
        return $encrypt;
    }

    /**
     * openssl 解密
     */
    public static function opensslDecrypt(string $post, $user)
    {
        $aes_key = $user['aes_key'];
        $iv = substr(base64_decode($aes_key . '='), 0, 16);
        $method = in_array($user['aes_method'], openssl_get_cipher_methods()) ? $user['aes_method'] : 'aes-128-cbc';
        $raw_data = openssl_decrypt($post, $method, $aes_key, $options = OPENSSL_RAW_DATA, $iv);
        if (!empty($raw_data)) {
            $raw_json = json_decode($raw_data, true);
            return $raw_json;
        }
        return $raw_data;
    }

    /**
     * is web
     * 使用web运行
     */
    public static function isRunWeb()
    {
        if (Yii::$app instanceof \yii\web\Application) {
            return true;
        }
        return false;
    }

    /**
     * is console
     * 使用console运行
     */
    public static function isRunConsole()
    {
        if (Yii::$app instanceof \yii\console\Application) {
            return true;
        }
        return false;
    }

    /**
     * 获取使用的内存
     */
    public static function getMemory($real = false)
    {
        $size = memory_get_usage($real);
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    public static function get($name, $default = null)
    {
        $data = Yii::$app->request->get($name, $default);
        return $data;
    }

    public static function post($name, $default = null)
    {
        if (isset($_GET['post']) && $_GET['post'] == '1') {
            return self::get($name, $default);
        }
        $data = Yii::$app->request->post($name, $default);
        return $data;
    }

    public static function isAjax()
    {
        return Yii::$app->request->getIsAjax() || isset($_GET['ajax']);
    }

    public static function isPost()
    {
        return Yii::$app->request->getIsPost() || isset($_GET['post']);
    }

    public static function getJson()
    {
        $post = file_get_contents("php://input");
        $post = $post ? json_decode($post, true) : false;
        return $post;
    }

    public static function getSession($key)
    {
        return Yii::$app->getSession()->get($key);
    }

    public static function setSession($name, $val = null)
    {
        return Yii::$app->session[$name] = $val;
    }

    public static function getConfig($key)
    {
        return Yii::$app->params[$key];
    }

    public static function getCookie($name)
    {
        return Yii::$app->request->getCookies()->get($name);
    }

    public static function setCookie($name, $val = null, $expire = 0)
    {
        $cookie = new yii\web\Cookie([
            'name' => $name,
            'value' => $val,
            'expire' => $expire > 0 ? time() + $expire : 0 // 设置过期时间
        ]);
        return Yii::$app->response->getCookies()->add($cookie);
    }

    public static function returnJson($data = null, $message = '', $code = '0')
    {
        header('Content-Type:application/json; charset=utf-8');
        $ret = compact('data', 'message', 'code');
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        Yii::$app->end();
    }

}
