/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Placeholder, Dashicon, TextControl } = wp.components;
const { Component, Fragment } = wp.element;

/**
 * Block edit function
 */
export default class Edit extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	render() {

		const { attributes, setAttributes } = this.props;
		const { pluginSlug, pluginName } = attributes;

		console.log('pluginName', pluginName);

		if( pluginName === '' ) {
			return [
				<Placeholder
						icon="admin-plugins"
						label={ __( 'Plugin Card' ) }
				>
					<div class="search-plugin-field">
						<Dashicon icon="search" />
						<TextControl
							type="text"
							placeholder={ __( 'Search for a plugin' ) }
							value={ pluginSlug }
							onChange={ ( value ) => setAttributes( {  } ) }
							onKeyDown={ ( e ) => {
								if ( e.keyCode === ENTER ) {
									console.log('hello enter');
									//searchPlugins( event.target.value );
								}
							}}
						/>
					</div>
				</Placeholder>
			];
		}

		return [
			<Fragment>
				<div>ceva</div>
			</Fragment>
		];
	}
};


