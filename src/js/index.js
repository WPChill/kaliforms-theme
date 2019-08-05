import Header from './modules/Header';
import TopBar from './modules/TopBar';
import Sidebar from './modules/Sidebar';
import Footer from './modules/Footer';
import Accordion from './modules/Accordion';
import DocSearch from './modules/DocSearch';
import Modal from './modules/Modal';

class ST {

	constructor(){
		this.initHeader();
		this.initTopBar();
		this.initScrollAnimation();
		this.initAccordions();
		this.initDocSearch();
		this.initModals();
		this.initSidebar();
		this.initFooter();
		this.initAccountPage();
	}

	initHeader() {
		new Header( jQuery('.header') );
	}

	initTopBar() {
		new TopBar( jQuery('.topbar-section') );
	}

	initSidebar() {
		//new Sidebar( jQuery('.post-sidebar') );
	}

	initFooter() {
		//new Footer( jQuery('.footer-section') );
	}

	initAccountPage() {
		if( ! jQuery( 'body' ).hasClass( 'page-template-account' ) ) {
			return;
		}

		jQuery( '.edd-manage-license-back' ).attr('href', '/account');
	}

	initScrollAnimation() {

		jQuery( 'a[href*="#"]:not([href="#"])' ).on( 'click', function(e) {
			let target;
			if ( location.pathname.replace( /^\//, '' ) === this.pathname.replace( /^\//, '' ) && location.hostname === this.hostname ) {
				target = jQuery( this.hash );
				target = target.length ? target : jQuery( '[name=' + this.hash.slice( 1 ) + ']' );
				if ( target.length ) {
					e.preventDefault();
					jQuery( 'html, body' ).animate( { scrollTop: target.offset().top }, 1000, 'swing' );
				}
			}
		});
	}

	initAccordions( $elements = jQuery(".accordion") ){
		$elements.each(function(index) {
			new Accordion( jQuery(this) );
		});
	}

	initDocSearch( $elements = jQuery(".doc-search") ){
		$elements.each( function() {
			new DocSearch( jQuery(this) );
		});
	}

	initModals() {
		new Modal( jQuery('.modal--login'), jQuery('.login-link') );
	}


}

new ST();