export default class Header {

	constructor($element){
		this.$header = $element;
		this.$mainMenu = this.$header.find('.main-menu');
		this.$menuIcon = this.$header.find('.menu-icon');
		this.$mainMenu.find('.menu-item-has-children').append('<div class="menu-arrow"></div>');
		this.$menuArrow = this.$mainMenu.find('.menu-arrow');

		this.initSticky();
		this.initMenu();
	}

	initSticky(){

		if( jQuery( 'body' ).hasClass( 'page-template-checkout' ) ) {
			return;
		}

		if( jQuery( 'body' ).hasClass( 'page-template-pricing' ) ) {
			return;
		}

		if( jQuery( 'body' ).hasClass( 'page-template-pricing-2' ) ) {
			return;
		}

		window.addEventListener( 'scroll', () => this.makeSticky() );
	}

	makeSticky() {

	 	if ( window.pageYOffset > 0 ) {
			this.$header.addClass( 'header--sticky' );
		} else {
			this.$header.removeClass( 'header--sticky' );
		}
	}

	initMenu() {

		this.$menuArrow.on( 'click', (e) => {
			jQuery( e.target ).toggleClass('menu-arrow--open');
			jQuery( e.target ).siblings('.sub-menu').toggleClass('sub-menu--open');
		});

		this.$menuIcon.on( 'click', () => {
			this.$menuIcon.toggleClass('menu-icon--open');
			this.$mainMenu.toggleClass('main-menu--open');
		});
	}

}


