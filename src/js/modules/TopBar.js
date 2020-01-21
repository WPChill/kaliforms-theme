export default class TopBar {

	constructor($element){
		this.$topbar = $element;

		//events
		this.$topbar.find('.topbar-section__close').on('click', (e) => this.onCloseClick(e) );
	}

	onCloseClick(e) {
		e.preventDefault();
		this.$topbar.addClass('topbar-section--closed');

		var exdate = new Date();
		exdate.setDate( exdate.getDate() + 10 );
		document.cookie = "st_top_bar_section_closed=true; expires="+exdate.toUTCString();
	}


}


