const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const {
	CheckboxControl,
	RadioControl,
	TextControl,
	ToggleControl,
	SelectControl,
} = wp.components;
// const {
// 	RichText,
// 	InspectorControls,
// } = wp.editor;

registerBlockType( 'templates/vimeo', {
	title: __( 'Vimeo', 'WPgutenberg' ),
	description: __( 'Insert vimeo video and configurate the output', 'WPgutenberg' ),
	category: 'media',
	icon: 'video-alt3',
	keywords: [
		__( 'video', 'WPgutenberg' ),
		__( 'vimeo', 'WPgutenberg' )
	],
	supports: {
		html: false,								// Remove support for an HTML mode
		anchor: true,								// Declare support for anchor links
		customClassName: true,			// Remove the support for the custom className
		className: false,						// Remove the support for the generated className
		align: true,								// Declare support for block's alignment
		alignWide: true,						// Remove the support for wide alignment
		defaultStylePicker: false,	// Remove the Default Style picker
		inserter: true,							// Hide this block from the inserter
		multiple: true,							// Use the block just once per post
		reusable: true							// Don't allow the block to be converted into a reusable block
	},
	// styles: [
	// 	{
	// 		name: 'default',
	// 		label: __( 'Rounded' ),
	// 		isDefault: true
	// 	},
	// 	{
	// 		name: 'outline',
	// 		label: __( 'Outline' )
	// 	},
	// 	{
	// 		name: 'squared',
	// 		label: __( 'Squared' )
	// 	},
	// ],
	attributes: {
		content: {
			type: 'string',
			source: 'html',
			selector: 'p',
		},
		checkboxField: {
			type: 'boolean',
			default: true,
		},
		radioField: {
			type: 'string',
			default: 'yes',
		},
		textField: {
			type: 'string',
		},
		toggleField: {
			type: 'boolean',
		},
		selectField: {
			type: 'string',
		},
	},

	// edit( { attributes, setAttributes } ) {
	edit: props => {
		const { content, checkboxField, radioField, textField, toggleField, selectField } = attributes;

		function onChangeContent( newContent ) {
			setAttributes( { content: newContent } );
		}

		function onChangeCheckboxField( newValue ) {
			setAttributes( { checkboxField: newValue } );
		}

		function onChangeRadioField( newValue ) {
			setAttributes( { radioField: newValue } );
		}

		function onChangeTextField( newValue ) {
			setAttributes( { textField: newValue } );
		}

		function onChangeToggleField( newValue ) {
			setAttributes( { toggleField: newValue } );
		}

		function onChangeSelectField( newValue ) {
			setAttributes( { selectField: newValue } );
		}

		return (
				<InspectorControls>

					<CheckboxControl
						heading="Checkbox Field"
						label="Tick Me"
						help="Additional help text"
						checked={ checkboxField }
						onChange={ onChangeCheckboxField }
					/>

					<RadioControl
						label="Radio Field"
						selected={ radioField }
						options={
							[
								{ label: 'Yes', value: 'yes' },
								{ label: 'No', value: 'no' },
							]
						}
						onChange={ onChangeRadioField }
					/>

					<TextControl
						label="Text Field"
						help="Additional help text"
						value={ textField }
						onChange={ onChangeTextField }
					/>

					<ToggleControl
						label="Toggle Field"
						checked={ toggleField }
						onChange={ onChangeToggleField }
					/>

					<SelectControl
						label="Select Control"
						value={ selectField }
						options={
							[
								{ value: 'a', label: 'Option A' },
								{ value: 'b', label: 'Option B' },
								{ value: 'c', label: 'Option C' },
							]
						}
						onChange={ onChangeSelectField }
					/>

				</InspectorControls>

				<RichText
					key="editable"
					tagName="p"
					onChange={ onChangeContent }
					value={ content }
				/>
		);
	},

	save( { attributes } ) {
		// const { content, checkboxField, radioField, textField, toggleField, selectField } = attributes;
		//
		// return (
		// 	<div>
		// 		<RichText.Content
		// 			value={ content }
		// 			tagName="p"
		// 		/>
		//
		// 		<h2>Inspector Control Fields</h2>
		// 		<ul>
		// 			<li>Checkbox Field: { checkboxField }</li>
		// 			<li>Radio Field: { radioField }</li>
		// 			<li>Text Field: { textField }</li>
		// 			<li>Toggle Field: { toggleField }</li>
		// 			<li>Select Field: { selectField }</li>
		// 		</ul>
		// 	</div>
		// );
	},
} );
