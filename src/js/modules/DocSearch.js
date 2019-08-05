export default class DocSearch {

	constructor($element){
		this.$searchInput = $element.find('input');
		this.$searchResults = $element.find('.doc-search__results');
		this.nonce = this.$searchInput.attr('data-nonce');
		this.postType = this.$searchInput.attr('data-post-type');

		//events
		this.$searchInput.on('keyup', (e) => this.onKeyUp(e) );
	}

	onKeyUp(e) {
		e.preventDefault();

		let value = this.$searchInput.val();
		clearTimeout(this.timeout);

		if (  value.length <= 3 ) {
			this.$searchResults.hide().html("");
		}
		else {
			this.$searchResults.show().html('<p class="mb-0">Searching for articles: <strong>'+ value +'</strong></p>');
			this.timeout = setTimeout( () => this.makeAjaxCall(), 500);
		}
	}

	makeAjaxCall() {
		jQuery.ajax({
			type: "POST",
			data : { action: "modula_search_articles", nonce: this.nonce, post_type: this.postType, s: this.$searchInput.val() },
			url : modula.ajaxurl,
			success: ( html ) => {
				this.$searchResults.show().html( html );
			}
		});
	}

}


