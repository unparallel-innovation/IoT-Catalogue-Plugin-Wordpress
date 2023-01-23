!function(){"use strict";var e,t={211:function(){var e=window.wp.blocks,t=window.wp.element,n=(window.wp.i18n,window.wp.blockEditor),r=window.wp.components,l=JSON.parse('{"u2":"unparallel/iotcat-component-card","WL":"Renders a component card"}');(0,e.registerBlockType)(l.u2,{edit:function(e){let{attributes:o,setAttributes:a}=e;return(0,t.createElement)(t.Fragment,null,(0,t.createElement)(n.InspectorControls,null,(0,t.createElement)(r.PanelBody,null,(0,t.createElement)("p",null,(0,t.createElement)("strong",null,"Select an image for the card")),(0,t.createElement)(n.MediaUploadCheck,null,(0,t.createElement)(n.MediaUpload,{onSelect:function(e){a({image:e.sizes.full.url})},allowedTypes:["image"],value:o.image,render:e=>{let{open:n}=e;return(0,t.createElement)(r.IconButton,{onClick:n,icon:"upload",className:"editor-media-placeholder__button is-button is-default is-large"},"Icon Image")}})))),(0,t.createElement)("div",(0,n.useBlockProps)(),(0,t.createElement)("p",null,l.WL),function(){const e=wp.data.select("core/block-editor").getSettings().colors;return(0,t.createElement)(t.Fragment,null,(0,t.createElement)("p",null,"Select color"),(0,t.createElement)(r.ColorPalette,{colors:e,value:o.color,onChange:e=>{a({color:e})}}))}(),(0,t.createElement)(r.TextControl,{label:"Card Title",value:o.title,onChange:e=>a({title:e})})))}})}},n={};function r(e){var l=n[e];if(void 0!==l)return l.exports;var o=n[e]={exports:{}};return t[e](o,o.exports,r),o.exports}r.m=t,e=[],r.O=function(t,n,l,o){if(!n){var a=1/0;for(s=0;s<e.length;s++){n=e[s][0],l=e[s][1],o=e[s][2];for(var c=!0,i=0;i<n.length;i++)(!1&o||a>=o)&&Object.keys(r.O).every((function(e){return r.O[e](n[i])}))?n.splice(i--,1):(c=!1,o<a&&(a=o));if(c){e.splice(s--,1);var u=l();void 0!==u&&(t=u)}}return t}o=o||0;for(var s=e.length;s>0&&e[s-1][2]>o;s--)e[s]=e[s-1];e[s]=[n,l,o]},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={186:0,611:0};r.O.j=function(t){return 0===e[t]};var t=function(t,n){var l,o,a=n[0],c=n[1],i=n[2],u=0;if(a.some((function(t){return 0!==e[t]}))){for(l in c)r.o(c,l)&&(r.m[l]=c[l]);if(i)var s=i(r)}for(t&&t(n);u<a.length;u++)o=a[u],r.o(e,o)&&e[o]&&e[o][0](),e[o]=0;return r.O(s)},n=self.webpackChunktest=self.webpackChunktest||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))}();var l=r.O(void 0,[611],(function(){return r(211)}));l=r.O(l)}();