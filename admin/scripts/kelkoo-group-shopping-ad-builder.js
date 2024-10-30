(function($, exports) {
    exports.kelkoo_group_shopping = exports.kelkoo_group_shopping || {};

	var AdBuilder = function AdBuilder() {};

    AdBuilder.prototype.init = function (el, options) {
        options = options || {};
        this.el = el;
        this.$el = $(el);
        this.options = options;
        
        this.nbOffersBySize = {
            grid : {
                lrec: { value: 3, type: "up-to" },
                responsive: { value: 4, type: "fixed" }
            },
            dynamic : {
                responsive: { value: 10, type: "fixed" }
            }
        };

        var preview = this.$preview = $("#" + this.options.previewId);

        var iskelkooadsLoaded = function() {
        	return kw && typeof kw.trigger === "function";
    	};

    	var checkIfKelkooadsIsLoaded = setInterval(function() {
    		if (iskelkooadsLoaded()) {
    			clearInterval(checkIfKelkooadsIsLoaded);

    			kw.trigger('widget:setconfigs', preview.data());
    		}
    	}, 100);

        this.$el.find("select[name=nbOffers]").change(this.changeNbOffers);
        this.$el.find("[data-ad-style=font]").change(this.changeFont);
        this.$el.find("[name=templateId]").change($.proxy(this.changeTemplateId, this));
        this.$el.find("[name=templateSize]").change($.proxy(this.changeTemplateSize, this));
        this.initColorPickers(this.$el.find("input.color-picker"));
        this.$el.submit($.proxy(this.createAd, this));

        this.$el.on('click blur change', function(){ kelkoo_group_shopping.existingAds.closeModal(); });
        this.$el.children().on('click blur change', function(){ kelkoo_group_shopping.existingAds.closeModal(); });
    };

    AdBuilder.prototype.initColorPickers = function ($colorPickers) {
        $colorPickers.each(function() {
            var $this = $(this);
            var name = $(this).data("ad-style");
            var kwName = "kw" + name.charAt(0).toUpperCase() + name.slice(1);

            $this.ColorPicker({
                onSubmit: function (hsb, hex, rgb, el, parent) {
                    $this.ColorPickerHide();
                },
                onChange: function (hsb, hex, rgb) {
                    $this.css({
                        "backgroundColor": "#" + hex,
                        "color": "#" + hex
                    });
                    $this.val("#" + hex);

                    var colorConfig = {};
                    colorConfig[kwName] = hex
                    kw.trigger('widget:setconfigs', colorConfig);
                },
                onBeforeShow: function () {
                    $this.ColorPickerSetColor(this.value);
                }
            }).bind('keyup', function () {
                $this.ColorPickerSetColor(this.value);
            });
        });
    };

    AdBuilder.prototype.changeNbOffers = function(event) {
    	var $el = $(event.currentTarget);

        kw.trigger('widget:setconfigs', {
        	kwNbOffers: parseInt($el.val())
        });
    };

    AdBuilder.prototype.changeFont = function(event) {
    	var $el = $(event.currentTarget);
        kw.trigger('widget:setconfigs', {
        	kwFont: $el.val()
        });
    };


    AdBuilder.prototype.changeTemplateId = function(event) {
        var $el = $(event.currentTarget);

        var templateId = $el.val(),
        templateSizes = this.$el.find("[name=templateSize]"),
        self=this,
        firstSelected=false;

        templateSizes.find("option").each(function( index ) {
            if(self.nbOffersBySize
                    && self.nbOffersBySize.hasOwnProperty(templateId)
                    && self.nbOffersBySize[templateId].hasOwnProperty($(this).val())){
                $(this).prop("disabled", false);
                if(!firstSelected){
                    templateSizes.val($(this).val());
                    firstSelected=true;
                }
            }else{
                $(this).prop("disabled", "disabled");
            }
        });

        kw.trigger('widget:setconfigs', {
            kwTemplateId: templateId
        });
        templateSizes.trigger("change", {'customTarget': $el});

    };


    AdBuilder.prototype.changeTemplateSize = function(event) {
    	var $el = $(event.currentTarget),
            templateSize = $el.val(),
            templateId = this.$el.find("[name=templateId]").val(),
            nbOffers = 1,
            availableNbOffersValues=[1,2,3,4,10],
            x = availableNbOffersValues.length;

        kw.trigger('widget:setconfigs', {
            kwTemplateSize: $el.val()
        });

        if (this.nbOffersBySize[templateId][templateSize]['type'] === "fixed") {
            for (var i = 0; i < x; i++) {
                var j = availableNbOffersValues[i];
                if(j===this.nbOffersBySize[templateId][templateSize]['value']){
                    this.$el.find("select[name=nbOffers] option[value=" + j + "]").removeAttr("disabled");
                }else {   
                    this.$el.find("select[name=nbOffers] option[value=" + j + "]").attr("disabled", "disabled");
                }
            }
            nbOffers = this.nbOffersBySize[templateId][templateSize]['value'];
        }else{
            for (var i = 0 ; i < x; i++) {
                var j = availableNbOffersValues[i];

                if(j<=this.nbOffersBySize[templateId][templateSize]['value']){
                    this.$el.find("select[name=nbOffers] option[value=" + j + "]").removeAttr("disabled");
                }else {   
                    this.$el.find("select[name=nbOffers] option[value=" + j + "]").attr("disabled", "disabled");
                }
            }
        }
 
        this.$el.find("select[name=nbOffers]").val(nbOffers);

        kw.trigger('widget:setconfigs', {
            kwNbOffers: parseInt(nbOffers, 10)
        });

        if(templateSize==='responsive' && templateId==='dynamic'){
            new kw.Dynamic(kw.widgets[0]);
        }

    };

    AdBuilder.prototype.createAd = function(event) {
        event.preventDefault();

        var adStyle = {};
        this.$el.find("[data-ad-style]").each(function() {
            var key = jQuery(this).data("ad-style");
            adStyle[key] = jQuery(this).val();
        });

        $.ajax({
            method: "POST",
            url: ajaxurl,
            data: {
                action: 'kga_create_ad',
                adStyle: adStyle,
                queryString: '?'+ this.$el.serialize()
            }
        }).done(function(adConf) {
            exports.kelkoo_group_shopping.existingAds.add(adConf);
        }).error(function(data, error) {
            console.log("error");
        });
    };

    exports.kelkoo_group_shopping.AdBuilder = AdBuilder;

})(jQuery, window);
