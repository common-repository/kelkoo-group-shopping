(function ($, exports) {
    var ExistingAds = function ExistingAds() {};

    ExistingAds.prototype.init = function (el) {
        this.el = el;
        this.$el = $(el);
        this.ads = [];
        this.body = this.$el.find('tbody');
        this.translations = this.$el.data('translations');
        this.sortParam = 'id';

        var myInstance = this;

        $.ajax({
            url: ajaxurl,
            type: "post",
            data: {'action': 'kga_getads'}
        }).done(function (data) {

            myInstance.ads = data.ads;
            myInstance.country = data.country;
            myInstance.trackingId = data.trackingId;
            myInstance.render();

        }).error(function () {
            $.proxy(myInstance.message(myInstance.translations['ws-error']), myInstance);
        });
        this.$el.find("thead th[data-id]").click($.proxy(this.changeSortOrder, this));

    };

    ExistingAds.prototype.message = function (message) {
        var table = this.$el;
        var parent = table.parent();
//        parent.remove('table');
        parent.append($('<alert></alert>').addClass("alert warning").text(message));
    };

    /*
     * Clicking on column header (to sort on this column)
     */
    ExistingAds.prototype.changeSortOrder = function (event) {
        var $el = $(event.currentTarget);

        var currentSort = (this.sortParam[0] === "-") ? this.sortParam.substr(1) : this.sortParam;
        var currentSortAscOrder = this.sortParam.indexOf($el.data('id')) === 0;

        this.$el.find("thead .sortable[data-id=" + currentSort + "] .fa").removeClass().addClass("fa fa-sort");

        this.sortParam = currentSortAscOrder ? '-' + $el.data('id') : $el.data('id');

        var faClass = currentSortAscOrder ? 'fa-sort-desc' : 'fa-sort-asc';
        $el.find(".fa").removeClass().addClass("fa " + faClass);
        this.render();
    };

    /*
     * Render the "existing ads" table
     */
    ExistingAds.prototype.render = function () {
        var tds = [], tr, $button, type, size;
        this.body.html('');

        if (this.ads.length) { 
            var adsSorted = this.ads;
            adsSorted.sort(this.sort(this.sortParam));

            for (var i = 0; i < adsSorted.length; i++) {
                tds = [];
                if (adsSorted[i].name) {
                    tds.push($('<td></td>').text(adsSorted[i].name));
                } else {
                    tds.push($('<td></td>').append($('<i></i>').attr('style', 'color: #AAA;').text('noname')));
                }
                tds.push($('<td></td>').text(adsSorted[i].id));

                type = this.translations.templateId[adsSorted[i].templateId] ? this.translations.templateId[adsSorted[i].templateId] : adsSorted[i].templateId;
                tds.push($('<td></td>').text(type));

                size = this.translations.templateSize[adsSorted[i].templateSize] ? this.translations.templateSize[adsSorted[i].templateSize] : adsSorted[i].templateSize;
                tds.push($('<td></td>').text(size));


                var shortCode = '[kelkoogroup_ad id=&quot;' + adsSorted[i].id + '&quot; kw=&quot;iphone&quot; /]';
                tds.push($('<td></td>').addClass('shortcode')
                        .html('<input type="text" onfocus="this.select();" '
                                + 'readonly="readonly" value="' + shortCode + '" >'));

                $button = $('<input></input>').attr('id', 'preview-ad-' + adsSorted[i].id)
                        .attr('type', 'button').attr('value', 'Preview Ad')
                        .addClass('button button-primary');
                tds.push($('<td></td>').addClass('preview-ad').append($button));

                tr = $('<tr></tr>').attr({'id': 'ad-' + adsSorted[i].id, 'data-id': adsSorted[i].id, 'data-template-id': adsSorted[i].templateId});
                tr.append(tds[0], tds[1], tds[2], tds[3], tds[4], tds[5]);

                this.body.append(tr);

            }
            this.body.find('.preview-ad').click($.proxy(this.previewAd, this));
        } else {
            $.proxy(this.message(this.translations['no-ads']), this);
        }

    };

    ExistingAds.prototype.sort = function (property) {
        var sortOrder = 1;
        if (property[0] === "-") {
            sortOrder = -1;
            property = property.substr(1);
        }
        return function (a, b) {
            var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
            return result * sortOrder;
        }
    }

    ExistingAds.prototype.previewAd = function (event) {
        var $el = $(event.currentTarget),
        self = this,
        adId = $el.parent().data('id'),
        adTemplateId = $el.parent().data('template-id'),
        adConfig = this.ads.filter(function (ad) {
            return ad.id == adId;
        })[0],

        topOffset = $(document).height() - $el.offset().top < 400 ? 400 : 20,
        leftOffset = $('.ad-builder-page').width() > 1000 ? 300 : 50,

        modal = $('.existing-ads .js-kga-modal'),
        style = adTemplateId === "dynamic" ? "min-width:500px" : "";

        if (modal.length === 0) {
            modal = $('<div></div>').addClass('kga-modal js-kga-modal')
                    .attr('style', 'top: -1000px; left: ' + leftOffset + 'px;');
            modal.animate({top: ($el.offset().top - topOffset) + 'px'}, 700);
        } else {
            modal.width('auto');
            modal.height('auto');

            if(modal.offset().top < 0){
                modal.animate({top: ($el.offset().top - topOffset) + 'px'}, 700);
            }
        }

        modal.html('<div class="kga-modal-head"><span class="close"><i class="fa fa-times" aria-hidden="true"></i></span>'
                + '<h3>' + adConfig.name + '</h3></div>'
                + '<div class="kga-modal-body" style="'+ style +'"><div class="js-kelkoo-widget" '
                + 'data-kw-country="' + this.country + '" '
                + 'data-kw-tracking-id="' + this.trackingId + '" '
                + 'data-kw-ad-id="' + adConfig.id + '" '
                + 'data-kw-keyword="iphone" >'
                + '<div class="kga-spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>'
                + '</div>');

        $(".existing-ads").append(modal);

        modal.draggable();      

        modal.find('.close').click(function () {
            self.closeModal(modal, leftOffset);
        });
        var l = kw.widgets.length;
        if(l>1){ kw.widgets.splice(l-1,1); }
        kw.widgets.push(new kw.Widget(modal.find('.js-kelkoo-widget')[0]));

    };

    ExistingAds.prototype.closeModal = function(modal, leftOffset){
        modal = modal || $('.existing-ads .js-kga-modal');
        leftOffset = leftOffset || $('.ad-builder-page').width() > 1000 ? 300 : 50;

        modal.animate({left: "-1000px"}, 1000, function () {
            modal.attr('style', 'top: -1000px; left: ' + leftOffset + 'px;');
        });
    };

    /*
     * Called when clicking on "Create new ad" 
     */
    ExistingAds.prototype.add = function (ad) {
        this.ads.push(ad);
        this.render();
        var $myAddedAd = this.$el.find('#ad-' + ad.id);
        $('html, body').animate({
            scrollTop: $myAddedAd.offset().top
        }, 2000)
        $myAddedAd.addClass('highlight');
        $myAddedAd.on('hover', function () {
            $(event.currentTarget).removeClass('highlight');

        });
    };

    exports.kelkoo_group_shopping.ExistingAds = ExistingAds;

})(jQuery, window);
