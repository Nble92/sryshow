(function($) {

	SYRSearchModule = function(settings) {
		this.settings   = settings;
		this.nodeClass  = '.fl-node-' + settings.id;
		this.searchForm = $(this.nodeClass + ' .syr-search-form');
		this.form       = this.searchForm.find('form');
		this.input      = this.form.find('input[type=search]');
		this.button     = this.searchForm.find('a.syr-search-button');
		this.resultsEl  = $(this.nodeClass + ' .syr-search-results-content');
		this.overlay    = this.searchForm.find( '.syr-search-overlay' );

		this._init();
	};

	SYRSearchModule.prototype = {

		settings: {},
		nodeClass: '',
		searchForm: '',
		form: null,
		input: null,
		button: null,
		resultsEl: '',
		searching: false,
		prevSearchData: {},
		request: null,

		_init: function() {
			this._bindEvents();
			this._popupSearch();
		},

		_bindEvents: function(){
			var $this        = this,
				keyCode      = null,
				keyType      = null,
			    enterPressed = false,
				t, et;

			$this.button.on('click', $.proxy($this._buttonClick, $this));
		},

		_search: function(e) {
			e.preventDefault();
			var $this = this;

			if ($.trim($this.input.val()).length < 1) {
				return;
			}

			this.form.submit();

			return false;
		},

		_popupSearch: function() {
			var $this     = this,
				inputWrap = this.searchForm.find('.syr-search-form-input-wrap');

			if ('button' != $this.settings.display || 'fullscreen' != $this.settings.btnAction) {
				return;
			}

			$( $this.searchForm ).find('.syr-search-close').click( function(){
				$this.searchForm.removeClass('search-active');
			});

			$(document).on('keyup.syr-search-form-input-wrap form',function(e) {
				if (e.keyCode == 27) { 
					$this.searchForm.removeClass('search-active');
				}
			});

			$this.overlay.on( 'click', function( ev ) {
				$this.searchForm.removeClass('search-active');
			} );

			$this.resultsEl.appendTo( inputWrap );
		},

		_buttonClick: function(e) {
			e.stopImmediatePropagation();
			$this = this;

			$this._search(e);

			if ('button' == $this.settings.display && 'fullscreen' == $this.settings.btnAction) {
				$this.searchForm.addClass('search-active');
				$this.searchForm.find('.syr-search-text').focus();
			}
		},
	}

})(jQuery);
