# PayPal Express (core `Magento_Paypal`) in the Loki Checkout

## Scope
| Admin product | Method code | Handled by |
|---|---|---|
| PayPal Express Checkout with in-context / smart buttons (`payment/paypal_express/in_context = 1`) | `paypal_express` | this module |
| PayPal Express Checkout Payflow Edition (with Payflow Pro, Payflow Link or Payments Advanced) | `payflow_express` | this module |
| PayPal Credit for the Payflow Edition | `payflow_express_bml` | this module |
| PayPal Payments Standard, Payments Pro Hosted Solution, Billing Agreement | `paypal_express` (classic), `hosted_pro`, `paypal_billing_agreement` | `LokiCheckout_Paypal` |
| Payments Advanced, Payflow Pro, Payflow Link | `payflow_advanced`, `payflowpro`, `payflow_link` | `LokiCheckout_PaypalPayflow` |

## Express Checkout (`paypal_express`, in-context)
- The smart buttons are rendered by the Loki component `loki-checkout.payment.methods.paypal_express.form`.
- `Payment\Redirect\RedirectResolver` returns core `paypal/express/review` only for `paypal_express`; for all other methods it returns `false`. It is **not registered** in `RedirectResolverListing` (commented out in `etc/frontend/di.xml`), so it is not used: the smart buttons post to core `paypal/express/onAuthorization`, which returns the `redirectUrl` (review or success page) that the Alpine component follows. The classic `paypal_express` redirect (without in-context) is handled by `LokiCheckout_Paypal` (`ExpressRedirectTask`).

## Express Checkout Payflow Edition (`payflow_express`, `payflow_express_bml`)
- Magento only offers `payflow_express` when `paypal_express` is not available (`Magento\Paypal\Model\PayflowExpress::isAvailable()`), and it requires Payflow Pro, Payflow Link or Payments Advanced to be active (`Magento\Paypal\Model\Config::isMethodAvailable()`); `payflow_express_bml` additionally requires `payflow_express` to be active.
- Like Payments Standard, PayPal needs a token before the payment can be authorized, so the order cannot be placed first. `Step\FinalStep\Task\PayflowExpressRedirectTask` saves the quote and throws a `RedirectException` **before** `placeOrder()`: `payflow_express` goes to core `paypal/payflowexpress/start`, `payflow_express_bml` to core `paypal/payflowbml/start` (which forwards to `payflowexpress/start` with `bml=1`). No extra parameters are needed.
- The core controllers run SetExpressCheckout, and `paypal/payflowexpress/return` places the order (or shows the Luma page `paypal/payflowexpress/review` when the order review step is not skipped). Loki `afterPlaceOrder()` tasks are not run for these orders.
- The task is registered in `LokiCheckout\Core\Step\FinalStep\TaskListing` in the global `etc/di.xml` (an item in `etc/frontend/di.xml` would replace the Core tasks) with `sortOrder="10000"`, so all other FinalStep `beforePlaceOrder()` checks (agreements, reCAPTCHA) run before the checkout is left.

### Limitations
- Cancelling at PayPal, or a rejected SetExpressCheckout call, returns the shopper to the shopping cart (core behaviour of `paypal/payflowexpress/cancel` and `start`), not to the Loki Checkout.
- The order is placed by the core controllers, so Loki `afterPlaceOrder()` tasks (e.g. the newsletter subscription) are not run. Unlike `LokiCheckout_Paypal` (`RunCheckoutTasksPlugin`), this module does not replay them.
- `Payment\Icon\IconResolver` shows the PayPal icon for `paypal_express`, `payflow_express` and `payflow_express_bml`.
