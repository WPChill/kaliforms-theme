export default class Accordion {

	constructor($element){
 		this.$accordion = $element;
		this.$accordionTitle = this.$accordion.children('.accordion__title');
		this.$accordionContent = this.$accordion.children('.accordion__content');

		//events
		this.$accordionTitle.on('click', (e) => this.onAccordionClick(e) );
	}

	onAccordionClick(e){
		e.preventDefault();

		this.$accordionContent.slideToggle( 300, 'swing', () => {
			this.$accordion.toggleClass( 'accordion--opened' );
		});
	}

}


