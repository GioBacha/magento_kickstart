define([
    'uiComponent',
    'ko',
    'Macademy_InventoryFulfillment/js/model/box-configurations',
    'Macademy_InventoryFulfillment/js/model/sku',
    'jquery'
], function (
    Component,
    ko,
    boxConfigurationsModel,
    skuModel,
    $
) {
    'use strict';

    return Component.extend({
        defaults: {
            boxConfigurationsModel: boxConfigurationsModel,
            skuModel: skuModel
        },

        initialize() {
            this._super();
            console.log('The boxConfigurations component has been loaded');
        },

        handleAdd() {
            boxConfigurationsModel.add();
        },

        handleDelete(index) {
            boxConfigurationsModel.delete(index)
        },

        handleSubmit() {
            $('.box-configurations form input').removeAttr('aria-invalid');
            if ($('.box-configurations form').valid()) {
                console.log('Box configuration success.');
                boxConfigurationsModel.success(true);
            } else {
                console.log('Box configuration error.');
                boxConfigurationsModel.success(false);
            }
        }
    });
});
