(function ($, exports) {

    exports.kelkoo_group_shopping = exports.kelkoo_group_shopping || {};

    var Settings = function Settings() {};

    Settings.prototype.init = function(el) {
        this.el = el;
        this.$el = $(el);

        this.i18n = this.$el.data("i18n");

        this.isValidate = false;

        this.$el.submit($.proxy(this.submit, this));
    };

    Settings.prototype.submit = function(event) {
        if (!this.isValidate) {
            event.preventDefault();

            var self = this;

            var trackingId = $("input[name=trackingId]").val();
            var accessKey = $("input[name=accessKey]").val();
            var country = $("select[name=country]").val()

            $.ajax({
                url: ajaxurl,
                type: "post",
                data: {
                    action: 'kga_validatesettings',
                    trackingId: trackingId,
                    accessKey: accessKey,
                    country: country
                }
            }).done(function() {
                self.isValidate = true;
                self.$el.submit();
            }).error(function() {
                self.$el.next("alert").remove();
                $('<alert class="alert warning">' + self.i18n.invalidSettings + '</alert>').insertAfter(self.$el);
            });
        }
    };

    exports.kelkoo_group_shopping.Settings = Settings;
    var settings = new Settings("#kelkoo-group-shopping-settings");
    settings.init("#kelkoo-group-shopping-settings");

})(jQuery, window);