# LokiCheckout_PaypalExpress

**This is an add-on package to the LokiCheckout. It adds compatibility for the `Magento_Paypal` module its PayPal Express payment method.**

## Installation
Install this package via composer (assuming you have setup the `composer.yireo.com` repository correctly already):
```bash
composer require loki-checkout/magento2-paypal-express
```

Next, enable this module:
```bash
bin/magento module:enable LokiCheckout_PaypalExpress
```

## Usage
Under Luma, this module brings the same functionality as in the regular Luma Checkout.

The PayPal Review page is currently not styled under Hyva. Enable the module `Hyva_ThemeFallback` and configure the URL `paypal/express/review/` to be served via a Luma theme.
