( function( $ ) {

	FLBuilder.registerModuleHelper( 'syr-icon', {

		init: function() {
			var form  = $( '.fl-builder-settings' ),
				icon = form.find( 'input[name=icon]' ),
				size = form.find( '#fl-field-size input[type=number]' );

			this._flipSettings();

			icon.on( 'change', this._previewIcon );
			icon.on( 'change', this._flipSettings );
		},

		_previewIcon: function() {
			var ele = FLBuilder.preview.elements.node.find( '.fl-icon i' ),
				form  = $( '.fl-builder-settings' ),
				icon = form.find( 'input[name=icon]' );

			ele.attr( 'class', icon.val() );
		},

		_flipSettings: function() {
			var form  = $( '.fl-builder-settings' ),
					icon = form.find( 'input[name=icon]' );
			if ( -1 !== icon.val().indexOf( 'fad fa') ) {
				$('#fl-field-duo_color1').show();
				$('#fl-field-duo_color2').show();
				$('#fl-field-color').hide();
				$('#fl-field-hover_color').hide()
			} else {
				$('#fl-field-duo_color1').hide();
				$('#fl-field-duo_color2').hide();
				$('#fl-field-color').show();
				$('#fl-field-hover_color').show()
			}
		},
	});

} )( jQuery );
