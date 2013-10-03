StyleList = function() 
{
	/*
     * Ignore these properties
     */
	var ignoreProperties = ["image-rendering", "direction", "empty-cells", "letter-spacing", "orphans", "pointer-events", "speak", "transition-delay", 
	                        "transition-duration", "transition-property", "transition-timing-function", "unicode-bidi", "widows", "word-spacing", "caption-side",
	                        "order", "buffered-rendering", "mask", "filter", "flood-color", "flood-opacity", "lighting-color", "stop-color", "z-index",
	                        "stop-opacity", "clip-path", "clip-rule", "color-interpolation", "color-interpolation-filters", "color-rendering", "fill", "fill-opacity", 
	                        "fill-rule", "marker-start", "marker-mid", "marker-end", "mask-type", "shape-rendering", "stroke", "stroke-dasharray", "stroke-dashoffset", 
	                        "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity", "stroke-width", "alignment-baseline", "baseline-shift", 
	                        "dominant-baseline", "kerning", "text-anchor", "writing-mode", "glyph-orientation-horizontal", "glyph-orientation-vertical", 
	                        "vector-effect", "page-break-after", "page-break-before", "page-break-inside", "text-transform", "tab-size", "align-self", "align-content",
	                        "align-items", "text-rendering", "-webkit-font-kerning", "-webkit-font-smoothing", "-webkit-font-variant-ligatures", "-webkit-backface-visibility"];
	
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
    
    
    /*
     * Loop over every element
     */
    $("*").each(function()
    {        
        //get element name
        var name = $(this).get(0).tagName;
        
        //add type if it exists (for inputs)
        if($(this).get(0).type) {
            name = name + " - " + $(this).get(0).type;
        }
        
        //add nesting level for LIs
        if($(this).get(0).tagName == "LI") {
            name = name + " (depth  " + $(this).parents("ol, ul").length + ")";
        }
        
        //create a table of all the styles for this element
        var styles = $(this).allcss();        
        createTable(name, styles);
    });
    
    /*
     * Format all styles into a table
     */
    function createTable(name, styles)
    {
        //table heading with name
        var table = $("<table></table>");
        table.append('<thead><tr><th colspan="2">' + name + '</th></tr></thead>');
        
        //rows for each style
        $.each(styles, function(key, value) {
        	if(jQuery.inArray(key, ignoreProperties) == -1) {        		
        		table.append('<tr><td>' + key + '</td><td>' + value + '</td></tr>');
        	}
        });
        
        //add table to end of page
        $('body').append(table);
    }
}

$(function() 
{
    var styleList = new StyleList();
});