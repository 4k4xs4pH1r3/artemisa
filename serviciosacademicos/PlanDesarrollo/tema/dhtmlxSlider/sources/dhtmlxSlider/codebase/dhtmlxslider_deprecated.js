/*
Product Name: dhtmlxSlider 
Version: 5.0 
Edition: Standard 
License: content of this file is covered by GPL. Usage outside GPL terms is prohibited. To obtain Commercial or Enterprise license contact sales@dhtmlx.com
Copyright UAB Dinamenta http://www.dhtmlx.com
*/

window.dhtmlxSlider = window.dhtmlXSlider;

dhtmlXSlider.prototype.setOnChangeHandler = function(fun) {
	if (typeof fun == "function") {
		this.attachEvent("onChange", fun);
	}
};

dhtmlXSlider.prototype.init = function() {
	// no longer used
};

dhtmlXSlider.prototype.setImagePath = function() {
	// no longer used
};

