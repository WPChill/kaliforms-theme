export default class Modal {

	constructor($element, $trigger){
 		this.$modal = $element;
		this.$trigger = $trigger;

		//events
		this.$trigger.on('click', (e) => this.openModal(e) );
		this.$modal.find('.modal__overlay, .modal__close').on('click', (e) => this.closeModal(e) );
	}

	openModal(e){
		e.preventDefault();
		this.$modal.addClass('modal--open');
	}

	closeModal(e){
		e.preventDefault();
		this.$modal.removeClass('modal--open');
		document.dispatchEvent( new Event('modal-closed') );
	}

}


