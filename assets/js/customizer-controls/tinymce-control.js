( function( api ) {

	api.MTTinymceControl = api.Control.extend( {

		ready: function() {

			var control = this;

			wp.editor.initialize( control.id , {
				mediaButtons: true,
				tinymce: {
					wpautop: false,
					toolbar1: control.params.toolbar1,
					toolbar2: control.params.toolbar2,
				},
				quicktags: true
			});

			$( document ).on( 'tinymce-editor-init' , function( event, editor ) {
				editor.on( 'Change Paste ExecCommand NodeChange' , function( e ) {
					$( '#'+editor.id ).trigger( 'change' );
					tinyMCE.triggerSave();
				});
			});

		}
	});

 	$.extend( api.controlConstructor, {
		'mt-tinymce-control': api.MTTinymceControl,
    });

})( wp.customize );