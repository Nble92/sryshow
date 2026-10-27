(function ($) {
    SYRTabs = function (settings) {
        this.settings = settings;
        this.node = settings.id;

        this._initTabs();

        this.tabLinks.on("click", this._switchTab)
    };

    SYRTabs.prototype = {

        settings: {},
        node: '',
        tabLinks: [],

        _initTabs: function() {
            $this = this;

            this.tabLinks = $('.fl-node-' + $this.node + ' .tabs-nav li')
        },

        _switchTab: function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            var index = $(this).data('index'),
                currentTab = $('.fl-node-' + $this.node + ' .tabs-content #section-' + index);

            currentTab.siblings().removeClass('active');
            currentTab.addClass('active');
        }
    }

})(jQuery);
