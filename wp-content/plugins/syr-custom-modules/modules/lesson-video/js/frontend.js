jQuery(document).ready(function( $ ) {
	if (  ! $('html').hasClass('fl-builder-edit') ){

		$('.uabb-modal-parent-wrapper').each(function(){
			$(this).appendTo(document.body);
		});
	}
});

(function($) {
	syrLessonVideo = function( settings )
	{
		this.settings       	 = settings;
		this.node           	 = settings.id;
		this.modal_on       	 = settings.modal_on;
		this.modal_custom   	 = settings.modal_custom;
		this.modal_content  	 = settings.modal_content;
		this.video_autoplay  	 = settings.video_autoplay;
		this.enable_cookies 	 = settings.enable_cookies;
		this.expire_cookie  	 = settings.expire_cookie;
		this.responsive_display  = settings.responsive_display;
		this.medium_device 		 = settings.medium_device;
		this.small_device 		 = settings.small_device;
		this.lesson 			 = settings.lesson;
		this.cloudinaryCloudName = settings.cloudinaryCloudName;
		this.security 			 = settings.security;

		this._initModalPopup();

		var modal_resize = this;

		$( window ).resize(function() {
			modal_resize._centerModal();
			modal_resize._resizeModalPopup();
		});

	};

	syrLessonVideo.prototype = {

		settings			: {},
		node   				: '',
		modal_trigger   	: '',
		overlay         	: '',
		modal_popup			: '',
		modal_on   			: '',
		modal_custom 		: '',
		modal_content 		: '',
		enable_cookies  	: '',
		expire_cookie   	: '',
		overlay_click   	: '',
		video_autoplay  	: 'no',
		responsive_display 	: '',
		medium_device 		: '',
		small_device 		: '',
		cloudinary 			: '',
		cloudinaryCloudName	: '',

		/**
		 * Initiate animation.
		 *
		 * @since 1.1.0.2
		 * @access private
		 * @method _initAnimations
		 */

		_initModalPopup: function() {
			$this = this;
			$node_module = $( '.fl-node-'+$this.node );
			$popup_id = $( '.uamodal-'+$this.node );

			this.overlay        = $popup_id.find( '.uabb-overlay' );

			$node_module.find( '.uabb-trigger' ).each(function( index ) {
				$this.modal_trigger = $(this);
				$this.modal_popup   = $( '#modal-' + $this.node );
				var	modal_trigger = $(this),
					modal_close   = $popup_id.find( '.uabb-modal-close' ),
					modal_popup   = $( '#modal-' + $this.node );


				modal_trigger.bind("click", function(){return false;});
				modal_trigger.on( "click", $.proxy( $this._showModalPopup, $this ) );

				modal_close.on( "click", $.proxy( $this._removeModalHandler, $this ) )

				$popup_id.find('.uabb-modal').on( "click", function( e ) {
					if( e.target == this ){
						modal_close.trigger( "click" );
					}
				} );
			});

			this._centerModal();
			this._iphonecursorfix();
		},
		_showModalPopup: function() {

			if ( $('html').hasClass('fl-builder-edit') && !$('html').hasClass('uabb-active-live-preview') ) {
				return;
			}

			if( ! this._isShowModal() ) {
				return;
			}

			var active_modal = $('.fl-node-' + this.node ),
				active_popup = $('.uamodal-' + this.node ),
				trigger_args = '.uamodal-' + this.node + ' .uabb-modal-content-data';

			if ( active_popup.find( '.uabb-content' ).outerHeight() > $(window).height() ) {
				$('html').addClass('uabb-html-modal');
				active_popup.find('.uabb-modal').addClass('uabb-modal-scroll');
			}

			jQuery(".uabb-modal-title-wrap").siblings(".uabb-modal-close").css("top", "0");

			var modal = $( '#modal-' + this.node );

			modal.addClass('uabb-show' );

			this.overlay.on( 'click',$.proxy( this._removeModalHandler, this ) );

			//this.overlay.addEventListener( 'click', this._removeModalHandler );
			current_this = this;
			if( this.modal_trigger.hasClass('uabb-setperspective' ) ) {
				setTimeout( function() {
					current_this.modal_trigger.addClass('uabb-perspective' );
				}, 25 );
			}

			$(document).on('keyup.uabb-modal',function(e) {

				if ( e.keyCode == 27) {
					current_this._removeModalHandler();
				}
			});

			inner_content_close = active_popup.find( '.uabb-close-modal' );
			if ( inner_content_close.length  ) {
				inner_content_close.on( 'click',$.proxy( this._removeModalHandler, this ) );
			}

			this._initCloudinary();

			UABBTrigger.triggerHook( 'uabb-modal-click', trigger_args );
		},
		_removeModal: function( hasPerspective ) {
			var active_modal = $('.fl-node-' + this.node ),
				active_popup = $('.uamodal-' + this.node ) ;

			this.modal_popup.removeClass('uabb-show' );

			this._stopVideo();

			if( hasPerspective ) {
				this.modal_trigger.removeClass( 'uabb-perspective' );
			}

			setTimeout(function() {
				$('html').removeClass('uabb-html-modal');
				active_popup.find('.uabb-modal').removeClass('uabb-modal-scroll');
			}, 300);

			$(document).unbind('keyup.uabb-modal');

			UABBTrigger.triggerHook( 'uabb-modal-after-close', active_popup );

		},
		_removeModalHandler: function( ev ) {
			this._removeModal( this.modal_trigger.hasClass('uabb-setperspective' ) );
		},
		_resizeModalPopup: function() {
			var active_modal = $('.fl-node-' + this.node ),
				active_popup = $('.uamodal-' + this.node );
			if (  active_popup.find('.uabb-modal').hasClass('uabb-show') ) {
				if ( active_popup.find( '.uabb-content' ).outerHeight() > $(window).height() ) {
					$('html').addClass('uabb-html-modal');
					active_popup.find('.uabb-modal').addClass('uabb-modal-scroll');
				}else{
					$('html').removeClass('uabb-html-modal');
					active_popup.find('.uabb-modal').removeClass('uabb-modal-scroll');
				}
			}
		},
		_stopVideo: function() {
			if (this.cloudinary !== '') {
				this.cloudinary.stop();
			}
		},
		_isShowModal: function() {

			if ( this.responsive_display != '' ) {

				var responsive_display = this.responsive_display,
					current_window_size = $(window).width(),
					medium_device = parseInt( this.medium_device ),
					small_device = parseInt( this.small_device );

				if ( ( responsive_display == 'desktop' || responsive_display.includes("desktop") ) && current_window_size > medium_device ) {

					return true;
				}else if( ( responsive_display == 'desktop-medium' || responsive_display.includes("large") ) && current_window_size > small_device ){

					return true;
				}else if( ( responsive_display == 'medium' || responsive_display.includes("medium") ) && current_window_size < medium_device && current_window_size > small_device ){

					return true;
				}else if( ( responsive_display == 'medium-mobile' || responsive_display.includes("mobile") ) && current_window_size < medium_device ){

					return true;
				}else if( ( responsive_display == 'mobile' || responsive_display.includes("mobile") ) && current_window_size < small_device ){

					return true;
				}else{

					return false;
				}
			}

			return true;
		},
		_centerModal: function () {

			$this 		 = this;
			popup_wrap = $('.uamodal-' + this.node );
			modal_popup  = '#modal-' + $this.node;
			node 		 = '.uamodal-' + $this.node;

			if ( $( '#modal-' + this.node ).hasClass('uabb-center-modal') ) {
				$( '#modal-' + this.node ).removeClass('uabb-center-modal');

			}

			if( $( '#modal-' + this.node + '.uabb-show' ).outerHeight() != null ) {

				var top_pos  = (($(window).height() - $( '#modal-' + this.node + '.uabb-show' ).outerHeight()) / 2);

				if ( popup_wrap.find( '.uabb-content' ).outerHeight() > $(window).height() ) {
					$(node).find( modal_popup ).css( 'top', '0' );
					$(node).find( modal_popup ).css( 'transform', 'none' );
				} else {
					$(node).find( modal_popup ).css( 'top', + top_pos +'px' );
					$(node).find( modal_popup ).css( 'transform', 'none' );
				}

			} else {

				if ( popup_wrap.find( '.uabb-content' ).outerHeight() > $(window).height() ) {
					$(node).find( modal_popup ).css( 'top', '0' );
					$(node).find( modal_popup ).css( 'transform', 'none' );
				} else {
					$(node).find( modal_popup ).css( 'top', '50%' );
					$(node).find( modal_popup ).css( 'transform', 'translateY(-50%)' );
				}
			}

		},
		_iphonecursorfix: function () {

			$this 		 = this;
			popup_wrap = $('.uamodal-' + this.node );
			modal_popup  = '#modal-' + $this.node;
			node 		 = '.uamodal-' + $this.node;

			iphone = (( navigator.userAgent.match(/iPhone/i) == 'iPhone' ) ? 'iphone' : '' );
			ipod = (( navigator.userAgent.match(/iPod/i) == 'iPod' ) ? 'ipod' : '' );

			jQuery('html').addClass(iphone).addClass(ipod);
			jQuery( 'html.iphone .uabb-modal-action-wrap .uabb-module-content .uabb-button.uabb-trigger, html.ipod .uabb-modal-action-wrap .uabb-module-content .uabb-button.uabb-trigger' ).click ( function() {
				jQuery('body').css( 'position', '' );
			});

			jQuery(document).on('click', '.uabb-overlay', function() {
				if( jQuery('html').hasClass('iphone') || jQuery('html').hasClass('ipod') ) {
					jQuery('body').css( 'position', 'relative' );
				}
			});

			jQuery(document).on('click', '.uabb-modal-close', function() {
				if( jQuery('html').hasClass('iphone') || jQuery('html').hasClass('ipod') ) {
					jQuery('body').css( 'position', 'relative' );
				}
			});
		},
		_initCloudinary: function() {
			const player = this.node + '-player';
			current_this = this;

			if (this.cloudinary === '') {
				this.cloudinary = cloudinary.videoPlayer(player, { cloudName: this.cloudinaryCloudName });

				this.cloudinary.on('fullscreenchange', function(e) {
					current_this._centerModal();
				})

				this.cloudinary.on('ended', function(e) {
					current_this._markLessonAsCompleted();
				})
			}

			this._centerModal();
		},
		// TODO: finish up mark as completed
		_markLessonAsCompleted: function () {
			let self = this;

			let data = {
				action: 'mark_lesson_as_completed',
				lesson: self.lesson,
				security: self.security
			};

			$.ajax({
				type: 'post',
				url: wpAjaxUrl,
				data: data,
				dataType: 'json',
				async: true,
				success: function(response) {
				}
			});
		},
	}

})(jQuery);
