define([], function () {
    'use strict';
    return function (originalMessages) {
        return originalMessages.extend({
            defaults: {
                hideTimeout: 100,
                hideSpeed: 100
            }
        });
    }
});
