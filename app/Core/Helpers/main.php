<?php

function model($alias, $param = null)
{
    //ga pake app(config('model.nama_model')) lagi karena sedikit nambah beban query

    //translate model alias -> class
    $class_alias = strtolower($alias);
    if (config('model.' . $class_alias)) {
        $class_name = config('model.' . $class_alias);
        if ($param) {
            return new $class_name($param);
        }
        return new $class_name;
    }
    //translate class string -> class object
    if (class_exists($alias)) {
        if ($param) {
            return new $alias($param);
        }
        return new $alias;
    }

    //if the classname or alias not found, throw an error
    throw new Exception('Class alias ' . $alias . ' is not exists');
}

function generateAdminRoute($url_name, $controller, $route_name = null)
{
    $bs_url = $url_name;
    $bs_route = strlen($route_name) > 0 ? $route_name : $url_name;
    $bs_controller = $controller;

    include base_path('app/Core/Routes/autocrud.php');
}

function setting($hint, $default = '')
{
    return Setting::get($hint, $default);
}

function admin_url($url = '')
{
    $prefix = admin_prefix();
    if (strlen($prefix) <= 1) {
        return url($url);
    }
    return url($prefix . '/' . $url);
}

function storage_url($path = '')
{
    return Storage::url($path);
}

function admin_prefix($path = '')
{
    return config('cms.admin.prefix', 'p4n3lb04rd') . (strlen($path) > 0 ? '/' . $path : '');
}

function api_response($type, $message = '')
{
    return response()->json([
        'type' => $type,
        'message' => $message,
    ]);
}

function ajax_response($type, $message = '')
{
    return api_response($type, $message);
}

function canSendPushNotif()
{
    //push notif can be sent if all .env below is filled
    return config('cms.config.fcm_server_key') && config('cms.config.fcm_sender_id') && config('cms.config.fcm_api_key') && config('cms.config.fcm_project_id') && config('cms.config.fcm_app_id');
}

// will remove stored cached for key defined in cms setting
function removeCache($key)
{
    if (strlen($key) == 0) {
        // clear all cache
        \Artisan::call('cache:clear');
        return true;
    }
    $cache_key = config('cms.cache_key.' . $key);
    if ($cache_key) {
        \Cache::forget($cache_key);
        return true;
    }

    // cache key not found
    return false;
}

function filenameOnly($fullpath = '')
{
    $pch = explode('/', $fullpath);
    return $pch[(count($pch) - 1)];
}

function getExtension($filename)
{
    $pch = explode('.', $filename);
    return $pch[(count($pch) - 1)];
}

function filesize_formatted($path)
{
    $size = filesize($path);
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}
