StyleList = function() 
{
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
        
        //all css
        var styles = $(this).allcss();        
        createTable(name, styles);
    });
    
    //format all styles into a table.
    function createTable(name, styles)
    {
        //table heading with name
        var table = $("<table></table>");
        table.append('<thead><tr><th colspan="2">' + name + '</th></tr></thead>');
        
        //rows for each style
        $.each(styles, function(key, value) {
            table.append('<tr><td>' + key + '</td><td>' + value + '</td></tr>');
        });
        
        $('body').append(table);
    }
}

$(function() 
{
    var styleList = new StyleList();
});