/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Internal dependencies
 */
import Edit from './components/edit';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;

/**
 * Block constants
 */
const name = 'plugin-card';

const title = __( 'Plugin Card' );

const icon = 'feedback';

const keywords = [
	__( 'plugin' ),
	__( 'w.org' ),
	__( 'card' ),
];

const blockAttributes = {
	pluginSlug: {
		type: 'string',
		default: '',
	},
	pluginName: {
		type: 'string',
		default: '',
	},
/* 	align: {
		type: 'string',
	},
	backgroundColor: {
		type: 'string',
	},
	textColor: {
		type: 'string',
	},
	customBackgroundColor: {
		type: 'string',
	},
	customTextColor: {
		type: 'string',
	},
	fontSize: {
		type: 'string',
	},
	customFontSize: {
		type: 'number',
	}, */
};

const settings = {

	title: title,

	description: __( 'Display info a WordPress plugin from w.org.' ),

	keywords: keywords,

	attributes: blockAttributes,

	edit: Edit,

	save() {
		return null;
	},
};

export { name, title, icon, settings };
