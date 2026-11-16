# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.0] - 16 November 2026
### Fixed
- Document Payflow Express limitations and unused redirect resolver
- Add `Magento_Quote` dependency and test dependencies
- Avoid empty afterPlaceOrder() in PayflowExpressRedirectTask
- Register Payflow Express redirect task globally to keep the core FinalStep tasks
- Only resolve PayPal review redirect for `paypal_express`

### Added
- Support `payflow_express` and `payflow_express_bml` via redirect before placing the order

## [1.0.5] - 09 November 2026
### Fixed
- Remove PHP 8.1 support, add PHP 8.5 support

## [1.0.4] - 24 September 2025
### Fixed
- Change containers into blocks to allow for caching
- Rename loki-components container to loki.components

## [1.0.3] - 02 September 2025
### Fixed
- Change loki-checkout.payment.payment-methods to loki-checkout.payment.methods

## [1.0.2] - 28 August 2025
### Fixed
- Add CI files
- Replace yireo/opensearch with yireo/opensearch-dummy in Gitlab CI

## [1.0.1] - 21 August 2025
### Fixed
- Replace LokiComponentsUtilBlockCssClass with LokiCssUtilsUtilCssClass
- Fix newlines after comments
- Add escaping of template code
- Document latest version of template

## [1.0.0] - 22 July 2025
### Fixed
- Rename PHP namespace from `Yireo_Loki*` to `Loki*`
- Rename composer package from `yireo/magento2-loki*` to `loki/magento2*`
- Bump loki/magento2-components to major 2.0

# 0.0.1 [8 July 2025]
- Initial release
