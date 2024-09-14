<?php
namespace SwissBitcoinPayPlugin;

class CurlWrapper {

    private static function request($method, $url, $params, $headers, $data) {
        $url = add_query_arg($params, $url);
        $r = wp_remote_request($url, array(
            'method' => $method,
            'headers' => $headers,
            'body' => $data ? wp_json_encode($data) : ''
        ));

        if (is_wp_error($r)) {
            error_log('WP_Error: '.$r->get_error_message());
            return array(
                'status' => 500,
                'response' => $r->get_error_message()
            );
        }

        return array(
            'status' => $r['response']['code'],
            'response' => json_decode($r['body'], true)
        );
    }

    public static function get($url, $params, $headers) {
        return CurlWrapper::request('GET', $url, $params, $headers, null);
    }

    public static function post($url, $params, $data, $headers) {
        return CurlWrapper::request('POST', $url, $params, $headers, $data);
    }
}
