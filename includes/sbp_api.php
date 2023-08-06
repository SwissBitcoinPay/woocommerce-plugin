<?php
namespace SwissBitcoinPayPlugin;

class API {

    static $url = 'https://api.swiss-bitcoin-pay.ch';

    public static function create_charge($amount, $memo, $order_id, $redirect_after_paid, $is_on_chain, $api_key) {
        $order = wc_get_order($order_id);
        $data = array(
            "title" => $memo,   
            "webhook" => sprintf("%s/wp-json/sbp_gw/v1/payment_complete/%s", get_site_url(), $order_id),
            "amount"=> $amount,
            "unit" => "sat",
            "redirectAfterPaid" => $redirect_after_paid,
            "onChain" => $is_on_chain
        );
        $headers = array(
            'api-key' => $api_key,
            'Content-Type' => 'application/json'
        );
        return CurlWrapper::post(API::$url.'/checkout', array(), $data, $headers);
    }

    public static function is_charge_paid($payment_id) {
        $headers = array(
            'Content-Type' => 'application/json'
        );

        $response = CurlWrapper::get(API::$url.'/checkout/'.$payment_id, array(), $headers);

        return true == $response['response']['isPaid'];
    }

}
