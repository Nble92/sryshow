var syrPosts;

(function($) {

    /**
     * Class for Blog Posts Module
     *
     * @since 1.6.1
     */
    syrPosts = function(settings) {

        // set params
        this.nodeClass = '.fl-node-' + settings.id;
        this.id = settings.id;
        this.wrapperClass = this.nodeClass + ' .uabb-blog-posts';
        this.postClass = this.nodeClass + ' .uabb-post-wrapper';
        this.pagination = settings.pagination;
        this.is_carousel = settings.is_carousel;
        this.infinite = settings.infinite;
        this.centerMode = settings.centerMode;
        this.variableWidth = settings.variableWidth;
        this.arrows = settings.arrows;
        this.desktop = settings.desktop;
        this.moduleUrl = settings.moduleUrl;
        this.loaderUrl = settings.loaderUrl;
        this.prevArrow = settings.prevArrow;
        this.nextArrow = settings.nextArrow;
        this.medium = settings.medium;
        this.small = settings.small;
        this.slidesToScroll = settings.slidesToScroll;
        this.autoplay = settings.autoplay;
        this.autoplaySpeed = settings.autoplaySpeed;
        this.dots = settings.dots;
        this.small_breakpoint = settings.small_breakpoint;
        this.medium_breakpoint = settings.medium_breakpoint;
        this.mesonry_equal_height = settings.mesonry_equal_height;
        this.uabb_masonary_filter_type = settings.uabb_masonary_filter_type;
        this.element_space = settings.element_space;

        if (this.is_carousel == 'carousel') {
            this._uabbBlogPostCarousel();
        }

        if (settings.blog_image_position == 'background') {
            this._uabbBlogPostImageResize();
        }

        this._openOnLink();
    };

    syrPosts.prototype = {
        nodeClass: '',
        wrapperClass: '',
        is_carousel: 'grid',
        infinite: '',
        centerMode: '',
        variableWidth: '',
        arrows: '',
        desktop: '',
        medium: '',
        small: '',
        slidesToScroll: '',
        autoplay: '',
        autoplaySpeed: '',
        small_breakpoint: '',
        medium_breakpoint: '',
        mesonry_equal_height: 'no',
        uabb_masonary_filter_type: 'buttons',

        // ==========================
        // ✅ FIXED CAROUSEL FUNCTION
        // ==========================
        _uabbBlogPostCarousel: function() {
            var $this = this;
            var grid = jQuery($this.nodeClass).find('.uabb-blog-posts-carousel');

            // Destroy existing slick if already initialized (prevents duplication)
            if (grid.hasClass('slick-initialized')) {
                grid.uabbslick('unslick');
            }

            // Initialize Slick
            grid.uabbslick({
                dots: $this.dots,
                infinite: false, // ✅ Disable infinite loop (stops repeating)
                centerMode: false,
                variableWidth: $this.variableWidth,
                arrows: $this.arrows,
                lazyLoad: 'ondemand',
                centerPadding: '20%',
                slidesToShow: $this.desktop,
                slidesToScroll: $this.slidesToScroll,
                autoplay: $this.autoplay,
                prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="' + $this.prevArrow + '"></i></button>',
                nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"><i class="' + $this.nextArrow + '"></i></button>',
                autoplaySpeed: $this.autoplaySpeed,
                adaptiveHeight: false,
                responsive: [
                    {
                        breakpoint: $this.medium_breakpoint,
                        settings: {
                            slidesToShow: $this.medium,
                            slidesToScroll: $this.medium
                        }
                    },
                    {
                        breakpoint: $this.small_breakpoint,
                        settings: {
                            slidesToShow: $this.small,
                            slidesToScroll: $this.small
                        }
                    }
                ]
            });

            // Function to mark center slide manually
            function applySlickCenter(slick, currentSlide) {
                var totalVisible = slick.options.slidesToShow;
                var middleIndex = currentSlide + Math.floor(totalVisible / 2);
                grid.find('.slick-slide').removeClass('slick-center');
                grid.find('.slick-slide[data-slick-index="' + middleIndex + '"]').addClass('slick-center');
            }

            // Bind events
            grid.on('afterChange', function(event, slick, currentSlide) {
                applySlickCenter(slick, currentSlide);
            });

            // Apply on init
            grid.on('init', function(event, slick) {
                applySlickCenter(slick, slick.currentSlide);
            });

            // Force initialization (for Beaver Builder reloads)
            setTimeout(function() {
                if (grid.hasClass('slick-initialized')) {
                    var slick = grid.slick('getSlick');
                    applySlickCenter(slick, slick.currentSlide);
                }
            }, 10);
        },

        _openOnLink: function() {
            var $this = this,
                nodeClass = jQuery($this.nodeClass);
            var layoutClass = '';

            if ($this.is_carousel == 'masonary') {
                layoutClass = '.uabb-blog-posts-masonary';
            } else if ($this.is_carousel == 'grid') {
                layoutClass = '.uabb-blog-posts-grid';
            }

            var pattern = new RegExp('^[\\w\\-]+$');
            var id = window.location.hash.substring(1);

            if (pattern.test(id)) {
                $($this.nodeClass + layoutClass).each(function() {
                    var selector = $(this);
                    var filters = nodeClass.find('.uabb-masonary-filters');

                    if (filters.length > 0) {
                        if ('' !== id) {
                            id = '.' + id.toLowerCase();
                            def_cat = id;
                            def_cat_sel = filters.find('[data-filter="' + id + '"]');

                            if (0 === def_cat_sel.length) {
                                return;
                            }

                            if (def_cat_sel.length > 0) {
                                def_cat_sel.siblings().removeClass('uabb-masonary-current');
                                def_cat_sel.addClass('uabb-masonary-current');
                            }
                        }
                    }

                    selector.isotope({
                        filter: def_cat,
                    });
                });
            }
        },

        _uabbBlogPostImageResize: function() {
            var $this = this,
                id = $this.id,
                nodeClass = $this.nodeClass,
                small_breakpoint = $this.small_breakpoint,
                medium_breakpoint = $this.medium_breakpoint,
                node = jQuery(nodeClass),
                grid = node.find('.uabb-blog-posts');

            grid.find('.uabb-post-wrapper').each(function() {
                var img_selector = jQuery(this).find('.uabb-post-thumbnail'),
                    img_wrap_height = parseInt(img_selector.height()),
                    img_height = parseInt(img_selector.find('img').height());

                if (!isNaN(img_wrap_height) && !isNaN(img_height)) {
                    if (img_wrap_height >= img_height) {
                        img_selector.find('img').css('min-height', '100%');
                    } else {
                        img_selector.find('img').css('min-height', '');
                    }
                }
            });
        }
    };

})(jQuery);
