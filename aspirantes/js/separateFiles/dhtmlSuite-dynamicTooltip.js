if(!window.DHTMLSuite)var DHTMLSuite=new Object();DHTMLSuite.dynamicTooltip=function(){var x_offset_tooltip;var y_offset_tooltip;var ajax_tooltipObj;var ajax_tooltipObj_iframe;var dynContentObj;var layoutCss;var waitMessage;this.x_offset_tooltip=5;this.y_offset_tooltip=0;this.ajax_tooltipObj=false;this.ajax_tooltipObj_iframe=false;this.layoutCss='dynamic-tooltip.css';this.waitMessage='';try{if(!standardObjectsCreated)DHTMLSuite.createStandardObjects()}catch(e){alert('Include the dhtmlSuite-common.js file')}}
DHTMLSuite.dynamicTooltip.prototype={setWaitMessage:function(waitMessage){this.waitMessage=waitMessage},displayTooltip:function(externalFile,inputObj,staticContent){DHTMLSuite.commonObj.loadCSS(this.layoutCss);if(!this.dynContentObj){try{this.dynContentObj=new DHTMLSuite.dynamicContent();if(this.waitMessage)this.dynContentObj.setWaitMessage(this.waitMessage)}catch(e){alert('Include dhtmlSuite-dynamicContent.js')}}
if(!this.ajax_tooltipObj&&document.getElementById('DHTMLSuite_ajax_tooltipObj')){DHTMLSuite.discardElement('DHTMLSuite_ajax_tooltipObj')}
if(!this.ajax_tooltipObj){this.ajax_tooltipObj=document.createElement('DIV');this.ajax_tooltipObj.style.position='absolute';this.ajax_tooltipObj.id='DHTMLSuite_ajax_tooltipObj';document.body.appendChild(this.ajax_tooltipObj);var leftDiv=document.createElement('DIV');leftDiv.className='DHTMLSuite_ajax_tooltip_arrow';leftDiv.id='DHTMLSuite_ajax_tooltip_arrow';leftDiv.style.backgroundImage='url(\''+DHTMLSuite.configObj.imagePath+'dynamic-tooltip/dyn-tooltip-arrow.gif'+'\')';this.ajax_tooltipObj.appendChild(leftDiv);var contentDiv=document.createElement('DIV');contentDiv.className='DHTMLSuite_ajax_tooltip_content';this.ajax_tooltipObj.appendChild(contentDiv);contentDiv.id='DHTMLSuite_ajax_tooltip_content';if(DHTMLSuite.clientInfoObj.isMSIE){this.ajax_tooltipObj_iframe=document.createElement('<IFRAME frameborder="0">');var fr=this.ajax_tooltipObj_iframe;fr.style.position='absolute';fr.id='DHTMLSuite_ajax_tooltipObjIframe';fr.border='0';fr.frameborder=0;fr.style.backgroundColor='#FFF';fr.src='about:blank';contentDiv.appendChild(fr);fr.style.left='0px';fr.style.top='0px'}}
this.ajax_tooltipObj.style.display='block';if(externalFile){this.dynContentObj.loadContent('DHTMLSuite_ajax_tooltip_content',externalFile)}else{this.ajax_tooltipObj.innerHTML=staticContent}
if(DHTMLSuite.clientInfoObj.isMSIE){this.ajax_tooltipObj_iframe.style.width=this.ajax_tooltipObj.clientWidth+'px';this.ajax_tooltipObj_iframe.style.height=this.ajax_tooltipObj.clientHeight+'px'}
this.__positionTooltip(inputObj)},setLayoutCss:function(newCssFileName){this.layoutCss=newCssFileName},hideTooltip:function(){this.ajax_tooltipObj.style.display='none'},__positionTooltip:function(inputObj){var leftPos=(DHTMLSuite.commonObj.getLeftPos(inputObj)+inputObj.offsetWidth);var topPos=DHTMLSuite.commonObj.getTopPos(inputObj);var tooltipWidth=document.getElementById('DHTMLSuite_ajax_tooltip_content').offsetWidth+document.getElementById('DHTMLSuite_ajax_tooltip_arrow').offsetWidth;this.ajax_tooltipObj.style.left=leftPos+'px';this.ajax_tooltipObj.style.top=topPos+'px'}}