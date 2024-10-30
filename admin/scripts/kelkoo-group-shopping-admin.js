(function ($, exports) {

    exports.kelkoo_group_shopping = exports.kelkoo_group_shopping || {};
    exports.kelkoo_group_shopping.existingAds = new exports.kelkoo_group_shopping.ExistingAds();
    exports.kelkoo_group_shopping.existingAds.init(".js-kelkoo-group-shopping-existing-ads");
    
    var adBuilder = new exports.kelkoo_group_shopping.AdBuilder();
    adBuilder.init("#kelkoo-group-shopping-ad-builder", {
        previewId: "preview-ad"
    });

})(jQuery, window);
