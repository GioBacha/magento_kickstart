define([
    'uiComponent',
    'ko',
    'mage/storage',
    'jquery',
    'mage/translate',
    'Macademy_InventoryFulfillment/js/model/sku'
], function (
    Component,
    ko,
    storage,
    $,
    $t,
    skuModel
) {
    'use strict';

    return Component.extend({
        defaults: {
            sku: skuModel.sku,
            placeholder: $t('Example: %1').replace('%1', '24-MB01'),
            messageResponse: ko.observable(''),
            success: skuModel.success
        },
        initialize() {
            this._super();
            console.log('The skuLookup component has been loaded.');
        },

        handleSubmit() {
            $('body').trigger('processStart');
            this.messageResponse('');
            this.success(false);

            storage.get(`rest/V1/products/${this.sku()}`)
                .done(response => {
                    this.messageResponse($t('Product found! %1').replace('%1', `<strong>${response.name}</strong>`));
                    this.success(true);
                })
                .fail(() => {
                    this.messageResponse($t('Product not found!'));
                    this.success(false);
                })
                .always(() => {
                    $('body').trigger('processStop');
                })
        }
    });
});
