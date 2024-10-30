(function (tinymce, $) {

    tinymce.PluginManager.add('kelkoo_group_shopping', function (editor, url) {

        editor.addButton('kelkoogroup_ad_shortcode', {
            title: 'Insert shortcode for Kelkoogroup Ad',
            cmd: 'kga_shortcode',
            image: url + '/../images/icon_color.png'
        });

        editor.addCommand('kga_shortcode', function () {
            var spinner = $('.kga-editor-spinner');
            if (spinner.length) {
                spinner.show();
            } else {
                var mce = $('.mce-container-body');
                spinner = $('<div></div>').addClass('kga-editor-spinner')
                        .attr('style', 'position: absolute; left: ' + (mce.offset().left + (mce.width() / 2) - 35) + 'px; top: ' + mce.offset().top + 'px;')
                        .html('<div class="kga-spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');
                $('body').append(spinner);
            }
            $.ajax({
                url: ajaxurl,
                type: "post",
                data: {'action': 'kga_getads'},
                success: function (data) {
                    $('.kga-editor-spinner').hide();
                    if (Array.isArray(data.ads) && data.ads.length) {
                        var ads = data.ads.map(function (e) {
                            return {value: e.id, text: e.name + " (" + e.id + ")"};
                        });

                        editor.windowManager.open({
                            title: 'Insert a shortcode for a Kelkoo group Ad',
                            body: [
                                {
                                    type: 'listbox',
                                    name: 'id',
                                    label: 'The Ad id',
                                    values: ads,
                                },
                                {
                                    type: 'textbox',
                                    name: 'keywords',
                                    label: 'Some keywords',
                                    placeholder: 'Enter here one or more keywords'
                                }],

                            onsubmit: function (e) {
                                if (!e.data.keywords) {
                                    editor.windowManager.alert("Please enter one or more keywords");
                                    return false;
                                }

                                var id = (e.data.id !== null && e.data.id != '') ? ' id="' + e.data.id + '"' : '';
                                var keywords = ' kw="' + e.data.keywords.replace('"', ' ') + '"';

                                editor.insertContent('[kelkoogroup_ad' + id + keywords + ' /]');
                            }

                        });
                    } else {
                        editor.windowManager.open({
                            title: 'sorry, error while fetching available ads...',
                            body: [{
                                    name: 'no',
                                    type: 'textbox',
                                    value: 'Be sure you have correctly filled your settings',
                                    heigth: 25
                                }
                            ],
                            onsubmit: function (e) {
                                editor.insertContent('');
                            }
                        });

                    }

                },
                error: function () {
                    $('.kga-editor-spinner').hide();
                    editor.windowManager.open({
                        title: 'sorry, error while fetching available ads...',
                        onsubmit: function (e) {
                            editor.insertContent('');
                        }
                    });
                }

            });


        });

    });

})(window.tinymce, jQuery);