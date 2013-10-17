StyleList = function() 
{	
    /*
     * Get all styles of an element
     * 
     * Thanks to marknadal on Stackoverflow
     * http://stackoverflow.com/questions/754607/can-jquery-get-all-css-styles-associated-with-an-element 
     */
    jQuery.fn.allcss = (function(css) {
        return function() {
            var dom = this.get(0);
            var style;
            var allStyles = {};
            
            if(window.getComputedStyle) {                
                style = window.getComputedStyle(dom, null);
                
                for(var i=0;i<style.length;i++) {
                    var prop = style[i];
                    var val = style.getPropertyValue(prop);
                    allStyles[prop] = val;
                }
                
                return allStyles;
            }
            
            if(dom.currentStyle) {
                style = dom.currentStyle;
                
                for(var prop in style) {
                    allStyles[prop] = style[prop];
                }
                
                return allStyles;
            }
            return this.css();
        };
    })(jQuery.fn.allcss);
    
    
    //form to attach inputs to
    var form = document.getElementById("form");
    
    //fragment to attach inputs to.
    var fragment = document.createDocumentFragment();
    
    //list of elements, so dont do the same one more than once
    var elements = new Array();
    
    
    //get browser id
    var browser = "";
    
    $.ajax({
	    type: "POST",
	    url: "post.php",
	    async: false,
    	data: {browserName: "Chrome", broswerVersion: "30.0"},
    	success: function(data) {
    		browser = data;
    		console.log("browser id = " + data);
    	}
    });
    
    
    /*
     * Loop over every element
     */
    $("*").each(function()
    {        
        //cache element
        var element = $(this).get(0);
        
        //get element name
        var name = element.tagName;
        
        //add type if it exists (for inputs)
        if(element.type) {
            name = name + " - " + element.type;
        }
        
        //add nesting level for LIs, ULs and OLs
        if(element.tagName == "LI" || element.tagName == "UL" || element.tagName == "OL") {
            name = name + " (depth  " + $(this).parents("ol, ul").length + ")";
        }
        
        //if not already done, add elements inputs
        if(jQuery.inArray(name, elements) == -1) {
            //add to array of elements
            elements.push(name)
            
            //save all the styles for this element
            var styles = $(this).allcss();        
            postStyles(name, styles);
        }
    });
    
    //attach button to fragment
    var button = document.createElement("input");
    button.type = "submit";
    button.value = "Update DB";
    fragment.appendChild(button);
    
    //attach fragment to the form
    form.appendChild(fragment);
    
    
    /*
     * save all styles to database
     */
    function postStyles(name, styles)
    {
    	//save the element and returns its ID
    	var element = "";
        
        $.ajax({
    	    type: "POST",
    	    url: "post.php",
    	    async: false,
        	data: {elementName: name},
        	success: function(data) {
        		element = data;
        		console.log(name + " = " + data);
        	}
        });
    	
        //post each property for the element
        $.each(styles, function(key, value) {
        	$.ajax({
        	    type: "POST",
        	    url: "post.php",
        	    async: false,
            	data: {propertyName: key, propertyValue: value, elementID: element, browserID: browser},
            	success: function(data) {
            		console.log(key + " = " + data);
            	}
            });
        });
    }
}

$(function() 
{
    var styleList = new StyleList();
});