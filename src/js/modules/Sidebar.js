export default class TopBar {

	constructor($element){
		this.$sidebar = $element;

		if (typeof Waypoint === "undefined") {
			return;
		}

		if( jQuery('.post-sidebar').length == 0 ) {
			return;
		}

		if( jQuery( 'body' ).hasClass( 'page-template-extension' ) ) {
			return;
		}

		this.initSticky();
	}

	initSticky() {

		// make the post navigation stick
		new Waypoint({
			element: jQuery('.post-content'),
			offset: '200px',
			handler: ( direction ) => {
			 	if( 'down' === direction ) {
					this.$sidebar.addClass('stick');
				}
				if( 'up' === direction ) {
					this.$sidebar.removeClass('stick');
				}
			}
		});


		// hide the post sidebar when reaching the bottom of the post
		new Waypoint({
			element: jQuery('.main-section'),
			offset: 'bottom-in-view',
			handler: ( direction ) => {
				if( 'down' === direction ) {
					this.$sidebar.css( { 'top': jQuery('.post-content').height() - this.$sidebar.height() } );
					this.$sidebar.removeClass('stick');
				}
				if( 'up' === direction ) {
					this.$sidebar.css( { 'top': '' } );
					this.$sidebar.addClass('stick');
				}
			}
		});

		// hide/show the post navigation when hovering over alignwide and alignfull elements
		jQuery('.post-content .alignwide, .post-content .alignfull').on('mouseenter', () => {
			this.$sidebar.addClass('invisible');
		});

		jQuery('.post-content .alignwide, .post-content .alignfull').on('mouseleave', () => {
			this.$sidebar.removeClass('invisible');
		});

	}


}


