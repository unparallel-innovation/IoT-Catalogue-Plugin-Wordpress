/**
 * WordPress components that create the necessary UI elements for the block
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-components/
 */


/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps,InnerBlocks } from '@wordpress/block-editor';
import { ColorPalette  } from '@wordpress/components';
import {useState } from '@wordpress/element';
/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();

	const colors = wp.data.select( 'core/block-editor' ).getSettings().colors


	function setNodeColor(node){
		if(node){
			if(attributes.borderColor){
				node.style.setProperty("background-color",attributes.borderColor , "important");
			}else{
				node.style.removeProperty("background-color");
			}			
		}

	}
	return (
		<div data-main-block="true" { ...blockProps } >
			<p>Select border color</p>
			<ColorPalette
				colors={ colors }
				value={ attributes.borderColor }
				onChange={ ( color ) =>{setAttributes({borderColor:color})}}
			/>
			<div style={{display:"flex"}}>
				<div ref={setNodeColor} className="iotcat-edit-base-card-margin" ></div>
				<div style={{flex:"1 0"}}><InnerBlocks/></div>
			</div>
			

		</div>
	);

	return (
		<div data-main-block="true" { ...blockProps } >
			<p>Select border color</p>
			<ColorPalette
				colors={ colors }
				value={ attributes.borderColor }
				onChange={ ( color ) =>{setAttributes({borderColor:color})}}
			/>
			<div style={{display:"flex"}}>
				<div ref={setNodeColor} className="iotcat-edit-base-card-margin" ></div>
				<div style={{flex:"1 0"}}><InnerBlocks/></div>
			</div>
			

		</div>
	);
}


