export default class Footer {

	constructor($element){
		this.$footer = $element;

		this.initOdometer();

	}

	initOdometer() {
		if (typeof Waypoint === "undefined") {
			return;
		}


		new Waypoint({
			element: this.$footer,
			offset: '70%',
			handler: ( direction ) => {
				this.$footer.find('.odometer').html(1093111);
			}
		});
	}



}


