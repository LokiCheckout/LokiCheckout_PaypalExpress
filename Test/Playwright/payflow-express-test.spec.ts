import {PaymentMethod, PlaceOrderButton, SuccessPage} from '@loki-checkout/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';
import payflowExpressConfig from './config/config';

const startRoutes = [
    {code: 'payflow_express', path: /\/paypal\/payflowexpress\/start\/?$/},
    {code: 'payflow_express_bml', path: /\/paypal\/payflowbml\/start\/?$/},
];

test.describe('PayPal Express Checkout Payflow Edition', () => {
    for (const {code, path} of startRoutes) {
        test(`should leave the checkout for ${code} before an order is placed`, async ({page, context}) => {
            await setupCheckout(page, context, payflowExpressConfig);

            await new PaymentMethod(page, code).select();
            await expect(page.locator(`input[name="payment_method"][value="${code}"]`)).toBeChecked();

            const startRequest = page.waitForRequest(request => path.test(new URL(request.url()).pathname), {timeout: 30000});
            await new PlaceOrderButton(page).click(false);
            const request = await startRequest;
            expect(request.method()).toBe('GET');

            await page.waitForURL(url => !/\/checkout\/?$/.test(url.pathname), {timeout: 30000});
            await new SuccessPage(page).expectNotToBeLoaded();

            const sectionResponse = await page.request.get(new URL('/customer/section/load/?sections=cart&force_new_section_timestamp=true', page.url()).toString());
            const sections = await sectionResponse.json();
            expect(sections.cart.summary_count).toBeGreaterThan(0);
        });
    }
});
