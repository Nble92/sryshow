<?php
/**
 *  UABB Progress Bar Module front-end JS php file
 *
 * @package UABB Progress Bar Module
 */

?>

(function ($) {

    UABBProgressBar = function (settings) {
        this.settings = settings;
        this.viewport_position = 90;
        this.nodeClass = '.fl-node-' + settings.id;
        this._init();
    };

    UABBProgressBar.addCommas = function (n) {

        var rgx = /(\d+)(\d{3})/;

        n += '';
        x = n.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';

        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }

        return x1 + x2;
    };

    UABBProgressBar.prototype = {

        settings: {},
        nodeClass: '',
        animation: '',
        animation_speed: '1000',
        animation_delay: 0,
        viewport_position: 90,

        _init: function () {
            if (typeof jQuery.fn.waypoint !== 'undefined') {
                $(this.nodeClass).waypoint({
                    offset: this.viewport_position + '%',
                    handler: $.proxy(this._initProgressBar, this)
                });
            }
        },

        /**
         * Initiate animation.
         *
         * @since 0.0.7
         * @access private
         * @method _initProgressBar
         */

        _initProgressBar: function () {
                this._executeProgressBarHorizontal();
                this._countProgressNumber();
        },

        _countProgressNumber: function () {
            var ani_speed = parseInt('1000');

            jQuery('.fl-node-<?php echo esc_attr($id); ?>').find('.uabb-layout-horizontal').each(function (index) {
                var form = jQuery('.fl-node-<?php echo esc_attr($id); ?>').find('.uabb-layout-horizontal.uabb-progress-bar-' + index);

                var text_field = form.find('.uabb-progress-value');
                var number = form.data('number');

                var completeClass = form.hasClass('uabb-progress-complete-number');
                if (!completeClass) {

                    text_field.animate({
                        Counter: number
                    }, {
                        duration: (ani_speed),
                        easing: 'linear',
                        step: function (now) {
                            text_field.text(UABBProgressBar.addCommas(Math.ceil(now)) + '%');
                        }
                    });
                    form.addClass('uabb-progress-complete-number');
                }
            });
        },

        _executeProgressBarHorizontal: function () {
            var ani_speed = parseInt('1000');

            jQuery('.fl-node-<?php echo esc_attr($id); ?>').find('.uabb-layout-horizontal').each(function (index) {
                var form = jQuery('.fl-node-<?php echo esc_attr($id); ?>').find('.uabb-layout-horizontal.uabb-progress-bar-' + index);
                var completeClass = form.hasClass('uabb-progress-complete');
                if (!completeClass) {
                    var number = Math.ceil(form.data('number'));
                    form.find('.uabb-progress-bar').animate({
                        width: number + '%'
                    }, {
                        duration: ani_speed,
                        easing: 'linear',
                        queue: false
                    });

                    form.addClass('uabb-progress-complete');
                }
            });
        },
    };

    new UABBProgressBar({
        id: '<?php echo esc_attr($id); ?>',
        viewport_position: 90
    });

})(jQuery);
