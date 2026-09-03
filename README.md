# LokiCheckout_PaypalExpress

<!-- badges.specs.start -->
![Magento version](https://img.shields.io/badge/Magento-2.4.6%20%7C%202.4.9-orange)
![PHP version](https://img.shields.io/badge/PHP-8.2%E2%80%938.5-777BB4)
![License](https://img.shields.io/badge/License-OSL--3.0-blue)
![Latest Version](https://img.shields.io/packagist/v/loki-checkout/magento2-paypal-express)
<!-- badges.specs.end -->


**This Magento 2 module is an add-on package to the LokiCheckout. It adds compatibility for the `Magento_Paypal` module its PayPal Express payment method.**

## Installation
Install this package via composer:
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

## Current status

<!-- badges.test.start -->
![Static Tests](https://img.shields.io/github/actions/workflow/status/LokiCheckout/LokiCheckout_PaypalExpress/static-tests.yml?label=static-tests)
![Unit Tests](https://img.shields.io/github/actions/workflow/status/LokiCheckout/LokiCheckout_PaypalExpress/unit-tests.yml?label=unit-tests)
![Integration Tests](https://img.shields.io/github/actions/workflow/status/LokiCheckout/LokiCheckout_PaypalExpress/integration-tests.yml?label=integration-tests)
![Playwright](https://img.shields.io/github/actions/workflow/status/LokiCheckout/LokiCheckout_PaypalExpress/playwright.yml?label=playwright)
![DI Compilation](https://img.shields.io/github/actions/workflow/status/LokiCheckout/LokiCheckout_PaypalExpress/compile.yml?label=compile)
<!-- badges.test.end -->
