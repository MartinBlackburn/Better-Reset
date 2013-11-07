/*
 * Get all styles of an element
 * 
 * Thanks to Dakota on Stackoverflow
 * http://stackoverflow.com/questions/754607/can-jquery-get-all-css-styles-associated-with-an-element 
 * Which lead to this:
 * https://github.com/moagrius/copycss
 */
(function($)
{        
    $.fn.getStyles = function(only, except)
    {
        // the map to return with requested styles and values as KVP
        var product = {};

        // the style object from the DOM element we need to iterate through
        var style;

        // recycle the name of the style attribute
        var name;

        // get everything
        var dom = this.get(0);
        
        // format all names to be the same (background-image, not backgroundImage)
        // helps to resolve duplicate names in IE
        var sanitiseString = function(string)
        {
            // put a "-" before uppercase letters
            var newString = string.replace( /([A-Z])/g, "-$1" );
            
            // lowercase the string
            return newString.toLowerCase();
        };

        // standards
        if (window.getComputedStyle)
        {
            // make sure we're getting a good reference
            if (style = window.getComputedStyle(dom, null))
            {
                var sanitisedName, value;
                
                // opera doesn't give back style.length - use truthy since a 0 length may as well be skipped anyways
                if (style.length)
                {
                    for ( var i = 0, l = style.length; i < l; i++)
                    {
                        name = style[i];
                        sanitisedName = sanitiseString(name);
                        value = style.getPropertyValue(name);
                        product[sanitisedName] = value;
                    }
                } else {
                    // opera
                    for (name in style)
                    {
                        sanitisedName = sanitiseString(name);
                        value = style.getPropertyValue(name) || style[name];
                        product[sanitisedName] = value;
                    }
                }
            }
        }
        // IE - first try currentStyle, then normal style object - don't bother with runtimeStyle
        else if (style = dom.currentStyle) {
            for (name in style) {
                sanitisedName = sanitiseString(name);
                product[sanitisedName] = style[name];
            }
        } else if (style = dom.style) {
            for (name in style)
            {
                if (typeof style[name] != 'function') {
                    sanitisedName = sanitiseString(name);
                    product[sanitisedName] = style[name];
                }
            }
        }

        return product;
    };

})(jQuery);