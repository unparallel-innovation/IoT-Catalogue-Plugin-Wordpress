const { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
const { ColorPalette, TextControl, PanelBody, IconButton } = wp.components;

export default function Edit( { attributes, setAttributes } ) {

	const {
		color, image, type, endpoint
	} = attributes

	function renderColorPicker(){
		const colors = wp.data.select( 'core/block-editor' ).getSettings().colors
		return (
			<>
				<p>Select text color</p>
				<ColorPalette
					colors={ colors }
					value={ color }
					onChange={ ( color ) =>{setAttributes({color})}}
				/>
			</>
		)
	}

	function renderStatisticTypeTextBox(){
		return (
			<TextControl
			label="Statistic Type"
			value={ type }
			onChange={ ( type ) => setAttributes({type})}
		/>)
	}

	function renderStatisticEndpointTextBox(){
		return (
			<TextControl
			label="Statistic Endpoint"
			value={ endpoint }
			onChange={ ( endpoint ) => setAttributes({endpoint})}
		/>)
	}

	function renderIconImage(){
		if(image){
			return (
				<>
					<div style={{fontSize: '11px', textTransform: 'uppercase', fontWeight: '500'}}>Statistic Icon</div>
					<div style={{width: '50px', height: '50px', marginTop: '8px'}}>
						<img src={image} />
					</div>
				</>
			)
		}
		return '';
	}

	function onSelectImage(newImage){
		setAttributes({image: newImage.sizes.full.url})
	}

	return (<>
		<InspectorControls style={{marginBottom: '40px'}}>
			<PanelBody>
				<p><strong>Select an Icon Image</strong></p>
				<MediaUploadCheck>
					<MediaUpload 
						onSelect={onSelectImage}
						allowedTypes={ ['image'] }
						value={image}
						render={({open}) => (
							<IconButton 
								onClick={open} 
								icon="upload"
								className="editor-media-placeholder__button is-button is-default is-large"
							>Icon Image</IconButton>
						)}
					/>
				</MediaUploadCheck>
			</PanelBody>	
		</InspectorControls>
		
		<div { ...useBlockProps() }>
			<p >
				Statistic Card
			</p>
			{renderColorPicker()}
			{renderStatisticTypeTextBox()}
			{renderStatisticEndpointTextBox()}
			{renderIconImage()}
		</div>
		</>
	)
}