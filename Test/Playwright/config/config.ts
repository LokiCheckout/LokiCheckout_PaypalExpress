import coreConfig from '@loki-checkout/config';

export default {
    ...coreConfig,
    profile: 'usa-la',
    catchErrors: false,
    modules: [
        'LokiCheckout_PaypalExpress',
        'Magento_Paypal',
    ],
    config: {
        ...coreConfig.config,
        'currency/options/base': 'USD',
        'currency/options/default': 'USD',
        'currency/options/allow': 'USD',
        'paypal/general/merchant_country': 'US',
        'payment/wps_express/active': 0,
        'payment/paypal_express/active': 0,
        'payment/hosted_pro/active': 0,
        'payment/payflowpro/active': 0,
        'payment/payflow_advanced/active': 0,
        'payment/payflow_link/active': 1,
        'payment/payflow_link/partner': 'PayPal',
        'payment/payflow_link/vendor': 'loki-dummy-vendor',
        'payment/payflow_link/sandbox_flag': 1,
        'payment/payflow_express/active': 1,
        'payment/payflow_express/payment_action': 'Authorization',
        'payment/payflow_express_bml/active': 1,
    },
    secure_config: {
        'payment/payflow_link/user': 'loki-dummy-user',
        'payment/payflow_link/pwd': 'loki-dummy-password',
    },
};
