(function($){
	FLBuilder.addHook( 'didRenderLayoutJSComplete', function() {
		FLBuilder._moduleHelpers['syr-lesson-video']._showModalPreview();
	} );
	FLBuilder.registerModuleHelper('syr-lesson-video', {
		init: function()
		{
			var form    		= $('.fl-builder-settings'),
				modal_effect_style 	= form.find('select[name=modal_effect]').val(),
				form_button  	= form.find('.fl-builder-button');

			form.attr('data-modaleffect', modal_effect_style );

			this._showModalPreview();

			form.find("#fl-field-ct_raw_nonce").hide();

			// Validation events
			form_button.on('click', $.proxy( this._closeModal, this ) );
		},

		_showModalPreview: function() {
			var form			= $('.fl-builder-modal-popup-settings:visible'),
				node_id     	= form.attr('data-node'),
				old_modal_effect_style 	= form.attr('data-modaleffect'),
				preview = FLBuilder.preview;

				if ( ! form.length || ! preview || ! preview.elements.node ) {
					return;
				}

				var settings   = FLBuilder._getSettings( form ),
					modal_node = preview.elements.node.find('#modal-'+node_id );

			if ( settings.preview_modal == 1 ) {

				modal_node.removeClass('uabb-drag-fix');

				if ( modal_node.hasClass('uabb-show') ) {
					if( old_modal_effect_style != settings.modal_effect ){
						modal_node.removeClass('uabb-show');
						modal_node.removeClass( old_modal_effect_style );
						modal_node.addClass( settings.modal_effect );

						setTimeout(function(){
							modal_node.addClass('uabb-show');
						}, 500);

						form.attr('data-modaleffect', settings.modal_effect );
					}
				}else{
					modal_node.addClass('uabb-show');

					var active_popup = preview.elements.node.find('.uamodal-' + node_id );
					if ( active_popup.find( '.uabb-content' ).outerHeight() > $(window).height() ) {
						$('html').addClass('uabb-html-modal');
						active_popup.find('.uabb-modal').addClass('uabb-modal-scroll');
					} else {
						$('html').removeClass('uabb-html-modal');
						active_popup.find('.uabb-modal').removeClass('uabb-modal-scroll');
					}
				}
			}else{
				modal_node.removeClass('uabb-show');
				modal_node.addClass('uabb-drag-fix');
			}
		},
		_closeModal: function() {
			var form		= $('.fl-builder-settings'),
				node_id     = form.attr('data-node');

			if ( $('#modal-'+ node_id ).hasClass('uabb-show') ) {
				$('#modal-'+ node_id ).removeClass('uabb-show');
				$('#modal-'+ node_id ).addClass('uabb-drag-fix');
			}
		},
	});
})(jQuery);
