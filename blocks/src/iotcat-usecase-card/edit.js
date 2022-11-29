/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

import { TextControl, Button } from '@wordpress/components';
import { useState } from '@wordpress/element';
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import metadata from './block.json';

import {Icon,ColorPalette} from "@wordpress/components";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

const cssPrefix = "iotcat-usecase-card-";

export default function Edit( { attributes, setAttributes } ) {
	console.log("attributes",attributes)
	const [boxLabel, setBoxLabel] = useState();
	const [boxValue, setBoxValue] = useState();
	
	function deleteBox(i){

		const boxes = [...attributes.boxes];
		boxes.splice(i,1);
		setAttributes({boxes});
	}

	function renderTitleTextBox(){
		return (
			<TextControl
			label="Card Title"
			value={ attributes.title }
			onChange={ ( title ) => setAttributes({title})}
		/>
		)
	}

	function renderBox(box,i){
		return (
			<div className={cssPrefix + "box-entry"} key={i}>
				<div className={cssPrefix +"box-entry-element"}>{box.label}</div>
				<div className={cssPrefix +"box-entry-element"}>{box.value}</div>
				<Icon icon="no" role="button" onClick={()=>{deleteBox(i)}} className={cssPrefix +"icon"}/>
			</div>
		)
	}




	function addNewBox(){
		const boxes = attributes.boxes || [];
		const newBoxes = ([
			...boxes,
			{label:boxLabel,value:boxValue}
		])
		setAttributes({boxes:newBoxes})
		setBoxLabel("");
		setBoxValue("");
		
	}

	function renderBoxes(){
		if(attributes.boxes?.length > 0){
			return <div className={cssPrefix +"box-entries"}>{attributes.boxes.map((box,i)=>renderBox(box,i))}</div>
		}
	}


	function renderAddBoxElement(){
		return (
			<>


				<label>Add New Box</label>
			<div className={cssPrefix + "add-box"}>
					<TextControl
						className={cssPrefix + "flex-2"}
						label="Label"
						value={ boxLabel }
						onChange={ setBoxLabel}
				/>
			
					<TextControl
						className={cssPrefix + "flex-2"}
						label="Value"
						value={ boxValue }
						onChange={ setBoxValue}
				/>
					<Button onClick={addNewBox} disabled={!boxLabel || !boxValue }>
						Add new box
					</Button>
			
					</div>
			</>
		)
	}

	function renderColorPicker(){
		const colors = wp.data.select( 'core/block-editor' ).getSettings().colors
		return (
			<>
				<p>Select color</p>
				<ColorPalette
					colors={ colors }
					value={ attributes.color }
					onChange={ ( color ) =>{setAttributes({color})}}
				/>
			</>
		)
	}


	return (
		<div { ...useBlockProps() }>
			<p >
				{ metadata.description}
			</p>
			{renderColorPicker()}
			{renderTitleTextBox()}
			{renderAddBoxElement()}
			{renderBoxes()}
		</div>

	);
}
