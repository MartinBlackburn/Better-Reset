StyleList = function(browserName, browserVersion) 
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
        
    
    //list of elements, so dont do the same one more than once
    var elements = new Array();    
    
    //get browser id
    var browser = "";
    
    $.ajax({
        type: "POST",
        url: "post.php",
        async: false,
        data: {browserName: browserName, broswerVersion: browserVersion},
        success: function(data) {
            browser = data;
            console.log("browser id = " + data);
        }
    });
        
    
    /**
     * Loop over every element
     */
    var count = 0;
    $("*").each(function()
    {        
        //cache element
        var element = $(this).get(0);
        
        //get element name
        var name = element.tagName;
        
        //remove slashes in names
        //to fix duplicate elements in IE8
        name = name.replace(/\\/g, '').replace(/\//g,'');
        
        //add element type if needed
        var type = "";
        
        //add type if it exists (for inputs)
        if(element.type) {
            type = element.type;
        }
        
        //add nesting level for LIs, ULs and OLs
        if(name.toLowerCase() == "li" || name.toLowerCase() == "ul" || name.toLowerCase() == "ol") {
            type = type + " (depth  " + $(this).parents("ol, ul").length + ")";
        }
        
        //if element is select, fieldset or textarea, remove type
        //to fix duplicate elements in IE
        if(name.toLowerCase() == "select" || name.toLowerCase() == "fieldset" || name.toLowerCase() == "textarea") {
            type = "";
        }
        
        //if not already done, add elements inputs
        if(jQuery.inArray(name + type, elements) == -1) {
            //add to array of elements
            elements.push(name + type)
            
            //save all the styles for this element
            var styles = $(this).allcss();        
            postStyles(name, type, styles);
        }
    });
        
    
    /*
     * save all styles to database
     */
    function postStyles(name, type, styles)
    {
    	//save the element and returns its ID
    	var element = "";
        
        $.ajax({
    	    type: "POST",
    	    url: "post.php",
    	    async: false,
        	data: {elementName: name, elementType: type},
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
    setTimeout(function() {
        var styleList = new StyleList("IE", "10");
    }, 1000);
});