<?php
/**
 * Global functions
 * @package core
 * @version 1.1.0
 */

function alt(...$args){
    foreach($args as $arg){
        if(!!$arg)
            return $arg;
    }
}

function autoload_class_exists(string $class): bool{
    return !!(Mim::$_config->autoload->classes->$class ?? false);
}

function array_flatten(array $array, string $prefix=''): array{
    $result = [];
    foreach($array as $key => $val){
        $c_prefix = $prefix . $key;
        if(is_array($val) || is_object($val)){
            $val = (array)$val;
            if(is_indexed_array($val)){
                if(!$val){
                    $result[$c_prefix] = '';
                }elseif(is_object($val[0]) || is_array($val[0])){
                    $res = array_flatten($val, $c_prefix . '.');
                    $result = array_merge($result, $res);
                }else{
                    $result[$c_prefix] = implode(', ', $val);
                }
            }else{
                $res = array_flatten($val, $c_prefix . '.');
                $result = array_merge($result, $res);
            }
        }else{
            $result[$c_prefix] = $val;
        }
    }
    
    return $result;
}

function arrayfy($arr){
    if(!is_object($arr) && !is_array($arr))
        return $arr;
    $arr = (array)$arr;
    foreach($arr as $key => $val)
        $arr[$key] = arrayfy($val);
    return $arr;
}

function deb(...$args): void{
    $is_cli = php_sapi_name() === 'cli';
    ob_start();
    
    if(!$is_cli)
        echo '<pre>';
    foreach($args as $arg){
        if(is_null($arg)){
            echo 'NULL';
        }elseif(is_bool($arg)){
            echo $arg ? 'TRUE' : 'FALSE';
        }else{
            $arg = print_r($arg, true);
            if(!$is_cli)
                $arg = hs($arg);
            echo $arg;
        }
        echo PHP_EOL;
    }
    if(!$is_cli)
        echo '</pre>';
    
    $ctx = ob_get_contents();
    ob_end_clean();
    
    echo $ctx;
    exit;
}

function get_prop_value(object $object, string $fields){
    $obj = clone $object;
    $keys = explode('.', $fields);
    foreach($keys as $ky){
        $obj = $obj->$ky;
        if(!is_object($obj))
            return $obj;
    }
    return $obj;
}

function group_by_prop(array $array, string $prop): array{
    $res = [];
    foreach($array as $arr){
        $key = is_object($arr) ? $arr->$prop : $arr[$prop];

        if(is_object($key))
            $key = $key->__toString();
        
        if(!isset($res[$key]))
            $res[$key] = [];
        $res[$key][] = $arr;
    }
    
    return $res;
}

function hs(string $str): string{
    return htmlspecialchars($str, ENT_QUOTES);
}

function is_dev(): bool{
    return ENVIRONMENT === 'development';
}

function is_indexed_array(array $array): bool{
    if(!$array)
        return true;
    return array_keys($array) === range(0, count($array) - 1);
}

function module_exists(string $name): bool{
    return in_array($name, Mim::$_config->_modules);
}

function object_replace(object $origin, object $new): object{
    $cloned = clone $origin;
    foreach($new as $key => $val)
        $cloned->$key = $val;
    return $cloned;
}

function objectify($arr){
    if(!is_array($arr))
        return $arr;
    foreach($arr as $key => $val)
        $arr[$key] = objectify($val);
    if(is_indexed_array($arr))
        return $arr;
    return (object)$arr;
}

function prop_as_key(array $array, string $prop): array{
    $res = [];
    foreach($array as $arr){
        $key = is_array($arr) ? $arr[$prop] : $arr->$prop;
        if(is_object($key))
            $key = (string)$key;
        $res[$key] = $arr;
    }
    
    return $res;
}

function to_attr(array $attrs): string{
    $tx = '';
    if(!$attrs)
        return '';
    foreach($attrs as $name => $val){
        $tx.= ' ' . $name;
        if(!is_null($val))
            $tx.= '="' . hs($val) . '"';
    }
    return $tx;
}

function to_ns(string $str): string{
    return str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $str)));
}

function to_route($opt, object $obj=null): string{
    if(is_string($opt))
        $opt = [$opt];

    if(!isset($opt[1]))
        $opt[1] = [];
    if(!isset($opt[2]))
        $opt[2] = [];

    if($obj){
        foreach($opt[1] as $okey => $oval){
            if(substr($oval,0,1) === '$')
                $opt[1][$okey] = get_prop_value($obj, substr($oval,1));
        }
    }

    return \Mim::$app->router->to($opt[0], (array)$opt[1], (array)$opt[2]);
}

function to_source($data, $space=0, $escape=true) {
    if(is_string($data)){
        if($escape){
            $data = addslashes($data);
            $data = str_replace('\\"', '"', $data);
        }
        return "'" . $data . "'";
    }
    if(is_numeric($data))
        return $data;
    if(is_bool($data))
        return $data ? 'TRUE' : 'FALSE';
    if(is_null($data))
        return 'NULL';
    if(is_resource($data))
        return "'*RESOURCE*'";
    $is_array  = is_array($data);
    $is_object = is_object($data);
    
    if(!$is_object && !$is_array)
        return "'UNKNOW_DATA_TYPE'";
    
    $inner_space = $space + 4;
    $nl = PHP_EOL;
    
    $tx = $is_array ? '[' : '(object)[';
    
    if($is_array && is_indexed_array($data)){
        if(count($data) && (is_array($data[0]) || is_object($data[0]))){
            foreach($data as $ind => $val){
                $tx.= $nl . str_repeat(' ', $inner_space);
                $tx.= to_source($val, $inner_space, $escape) . ',';
            }
            $tx = chop($tx, ',');
            $tx.= $nl;
            $tx.= str_repeat(' ', $space);
        }else{
            foreach($data as $ind => $val)
                $tx.= to_source($val, $inner_space, $escape) . ',';
            $tx = chop($tx, ',');
        }
    }else{
        $prop_len = count((array)$data);
        if($prop_len){
            foreach($data as $key => $val){
                $tx.= $nl . str_repeat(' ', $inner_space);
                $tx.= to_source($key, $inner_space, $escape) . ' => ' . to_source($val, $inner_space, $escape);
                $tx.= ',';
            }
            $tx = chop($tx, ',');
            $tx.= $nl;
            $tx.= str_repeat(' ', $space);
        }
    }
    $tx.= ']';
    
    return $tx;
}

function dd($arg) {
    die(var_dump($arg));
}

function array_pluck($array, $prop, $key="") {
    $res = [];

    foreach($array as $i => $arr){
        if(!empty($key))
            $i = is_array($arr) ? $arr[$key] : (string)($arr->$key);
        $res[$i] = is_array($arr) ? $arr[$prop] : (string)($arr->$prop);
    }

    return $res;
}

function date_month_range() {
    $ts = strtotime(date('Y-m-d'));
    $start = date('Y-m-01', $ts);

    $range = [];
    for ($i=0;$i<date('t', $ts);$i++) {
        $range[] = date('Y-m-d', strtotime('+'.$i.' day', strtotime($start)));
    }

    return $range;
}

function get_minute_diff($date){
    $start_date = new DateTime(date('Y-m-d H:i:s', strtotime($date)));
    $since_start = $start_date->diff(new DateTime());

    $minutes = $since_start->days * 24 * 60;
    $minutes += $since_start->h * 60;
    $minutes += $since_start->i;
    return $minutes;
}

function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}