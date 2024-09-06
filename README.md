# Swiss Bitcoin Pay payment gateway plugin for WooCommerce

## Introduction

Accept Bitcoin on chain and lightning payments on your web store within few minutes through Swiss Bitcoin Pay.

You will need first an account on [Swiss Bitcoin Pay](https://swiss-bitcoin-pay.ch/).

Follow the instructions below to install and configure the plugin.

## Accept Bitcoin payment on WooCommerce through Swiss Bitcoin Pay payment gateway.

### Install Swiss Bitcoin Pay payment gateway plugin
1. Install the plugin using your Wordpress admin panel by searching for "Swiss Bitcoin Pay Payment Gateway" or drop this repo into your `wp-content/plugins` directory

### Swiss Bitcoin Pay payment gateway configuration
1. From your WordPress dashboard, go to _WooCommerce -> Settings -> Payments_ and activate the Swiss Bitcoin Pay payment method, then click _manage_
2. Enter your API key, that you can get from your [Swiss Bitcoin Pay dashboard](https://dashboard.swiss-bitcoin-pay.ch/settings)
3. Enter your API secret (HMAC), that you can also get from your [Swiss Bitcoin Pay dashboard](https://dashboard.swiss-bitcoin-pay.ch/settings)
4. Click save. You're ready to accept bitcoin payment through Swiss Bitcoin Pay

## License
This plugin is released under the [MIT license](https://github.com/SwissBitcoinPay/woocommerce-plugin/blob/main/LICENSE).

## Acknowledgements
This plugin is based on the [LNBits WooCommerce plugin](https://github.com/lnbits/woocommerce-payment-gateway) which was already a fork of Phaedrus' original [LNBits For WooCommerce](https://gitlab.com/sovereign-individuals/lnbits-for-woocommerce).

Thanks to Phaedrus and LNBits for the work done.
