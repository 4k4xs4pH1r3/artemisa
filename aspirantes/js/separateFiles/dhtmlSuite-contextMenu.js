if(!window.DHTMLSuite)var DHTMLSuite=new Object();var referenceToDHTMLSuiteContextMenu;DHTMLSuite.contextMenu=function(){var menuModels;var defaultMenuModel;var menuItems;var menuObject;var layoutCSS;var menuUls;var width;var srcElement;var indexCurrentlyDisplayedMenuModel;var menuBar;this.menuModels=new Object();this.menuObject=false;this.menuUls=new Array();this.width=100;this.srcElement=false;this.indexCurrentlyDisplayedMenuModel=false;try{if(!standardObjectsCreated)DHTMLSuite.createStandardObjects()}catch(e){alert('Include the dhtmlSuite-common.js file')}}
DHTMLSuite.contextMenu.prototype=
{setWidth:function(newWidth){this.width=newWidth},setLayoutCss:function(cssFileName){},attachToElement:function(element,elementId,menuModel){window.refToThisContextMenu=this;if(!element&&elementId)element=document.getElementById(elementId);if(!element.id){element.id='context_menu'+Math.random();element.id=element.id.replace('.','')}
this.menuModels[element.id]=menuModel;menuModel.setSubMenuType(1,'sub');menuModel.setMainMenuGroupWidth(this.width);if(!this.defaultMenuModel)this.defaultMenuModel=menuModel;element.oncontextmenu=this.__displayContextMenu;element.onmousedown=function(){window.refToThisContextMenu.__setReference(window.refToThisContextMenu)};DHTMLSuite.commonObj.__addEventEl(element)
DHTMLSuite.commonObj.addEvent(document.documentElement,"click",this.__hideContextMenu)},__setReference:function(obj){referenceToDHTMLSuiteContextMenu=obj},__displayContextMenu:function(e){if(document.all)e=event;var ref=referenceToDHTMLSuiteContextMenu;ref.srcElement=DHTMLSuite.commonObj.getSrcElement(e);if(!ref.indexCurrentlyDisplayedMenuModel||ref.indexCurrentlyDisplayedMenuModel!=this.id){if(ref.indexCurrentlyDisplayedMenuModel){ref.menuObject.innerHTML=''}else{ref.__createDivs()}
ref.menuItems=ref.menuModels[this.id].getItems();ref.__createMenuItems(ref.menuModels[this.id])}
ref.indexCurrentlyDisplayedMenuModel=this.id;ref.menuObject.style.left=(e.clientX+Math.max(document.body.scrollLeft,document.documentElement.scrollLeft))+'px';ref.menuObject.style.top=(e.clientY+Math.max(document.body.scrollTop,document.documentElement.scrollTop))+'px';ref.menuObject.style.display='block';return false},__hideContextMenu:function(){var ref=referenceToDHTMLSuiteContextMenu;if(!ref)return;if(ref.menuObject)ref.menuObject.style.display='none'},__createDivs:function(){var firstChild=false;var firstChilds=document.getElementsByTagName('DIV');if(firstChilds.length>0)firstChild=firstChilds[0];this.menuObject=document.createElement('DIV');this.menuObject.style.cssText='position:absolute;z-index:100000;';this.menuObject.className='DHTMLSuite_contextMenu';this.menuObject.id='DHTMLSuite_contextMenu'+DHTMLSuite.commonObj.getUniqueId();this.menuObject.style.backgroundImage='url(\''+DHTMLSuite.configObj.imagePath+'context-menu/context-menu-gradient.gif'+'\')';this.menuObject.style.backgroundRepeat='repeat-y';if(this.width)this.menuObject.style.width=this.width+'px';if(firstChild){firstChild.parentNode.insertBefore(this.menuObject,firstChild)}else{document.body.appendChild(this.menuObject)}
this.menuBar=new DHTMLSuite.menuBar();this.menuBar.setActiveSubItemsOnMouseOver(true);this.menuBar.setTarget(this.menuObject.id);this.menuBar.addMenuItems(this.defaultMenuModel);this.menuBar.init()},__mouseOver:function(){this.className='DHTMLSuite_item_mouseover';if(!document.all){this.style.backgroundPosition='left center'}},__mouseOut:function(){this.className='';if(!document.all){this.style.backgroundPosition='1px center'}},__createMenuItems:function(menuModel){this.menuBar.deleteAllMenuItems();this.menuBar.addMenuItems(menuModel);this.menuBar.init()}}