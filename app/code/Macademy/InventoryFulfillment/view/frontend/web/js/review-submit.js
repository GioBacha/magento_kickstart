define([
    'uiComponent',
    'ko',
    'Macademy_InventoryFulfillment/js/model/sku',
    'Macademy_InventoryFulfillment/js/model/box-configurations'
], function (
    Component,
    ko,
    skuModel,
    boxConfigurationsModel
) {
    'use strict';

    return Component.extend({

        defaults: {
            numberOfBoxes: boxConfigurationsModel.numberOfBoxes(),
            shipmentWeight: boxConfigurationsModel.shipmentWeight(),
            billableWeight: boxConfigurationsModel.billableWeight(),
            isTermsChecked: ko.observable(false),
            boxConfigurationsSuccess: boxConfigurationsModel.success,
        },

        initialize() {
            this._super();
            console.log('review submit component initialized yes!');
            this.canSubmit = ko.computed(() => {
                return skuModel.success()
                    && boxConfigurationsModel.success()
                    && this.isTermsChecked();
            });
        },

        handleSubmit() {
            if (this.canSubmit()) {
                console.log('review has been submitted!');
            } else {
                console.log('there is an error!');
            }
        }
    });
});
