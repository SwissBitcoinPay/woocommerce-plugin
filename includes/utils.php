<?php
namespace SwissBitcoinPayPlugin;

class Utils {
    public static function convert_to_satoshis($amount, $currency) {
        if(strtolower($currency) !== 'sat' && strtolower($currency) !== 'btc') {
            $resp = CurlWrapper::get('https://blockchain.info/tobtc', array(
                'currency' => $currency,
                'value'    => $amount
            ), array());

            if ($resp['status'] != 200) {
                throw new \Exception('Blockchain.info request for currency conversion failed. Got status ' . $resp['status']);
            }
            return $resp['response'] * 100000000;
        }
        else if(strtolower($currency) === 'sat') {
            return intval($amount);
        } else if(strtolower($currency) === 'btc') {
            return intval($amount * 100000000);
        }
    }

    public static function convert_to_chf($amount, $currency) {
        if(strtolower($currency) === 'chf') {
            return $amount;
        }

        if(strtolower($currency) !== 'sat') {
            $resp = CurlWrapper::get('https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/chf.json', array(), array());

            if ($resp['status'] != 200) {
                throw new \Exception('cdn.jsdelivr.net/gh/fawazahmed0 request for currency conversion failed. Got status ' . $resp['status']);
            }
            return round($amount / $resp['response']['chf'][strtolower($currency)], 2);
        }
        else if(strtolower($currency) === 'sat') {
            return round((intval($amount) * 100000000) / $resp['response']['chf']['btc'], 2);
        }
    }
}

class CurlWrapper {

    private static function request($method, $url, $params, $headers, $data) {
        $url = add_query_arg($params, $url);
        $r = wp_remote_request($url, array(
            'method' => $method,
            'headers' => $headers,
            'body' => $data ? json_encode($data) : ''
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
