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
        
        //create a table of all the styles for this element
        var styles = $(this).allcss();        
        createInputs(name, styles);
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
        	table.append('<tr><td>' + key + '</td><td>' + value + '</td></tr>');
        });
        
        //add table to end of page
        $('body').append(table);
    }
    
    /*
     * Format all styles into inputs, for updating a database
     */
    function createInputs(name, styles)
    {
        var input = document.createElement("input");
        input.name = "element[" + name + "][name]";
        input.value = name;
        input.type = "hidden";
        document.body.appendChild(input);
        
        //each property
        var count = 0;
        $.each(styles, function(key, value) {
            input = document.createElement("input");
            input.name = "element[" + name + "][property][" + count + "][name]";
            input.value = key;
            input.type = "hidden";
            document.body.appendChild(input);
            
            input = document.createElement("input");
            input.name = "element[" + name + "][property][" + count + "][name]";
            input.value = value;
            input.type = "hidden";
            document.body.appendChild(input);
            
            count++;
        });
    }
}

$(function() 
{
    var styleList = new StyleList();
});