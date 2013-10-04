SelectTable = function() 
{   
    //select box
    var select = $(".selectElement select").first();
    
    //attach table to here
    var tableContainer = $(".tableContainer").first();
    
    //on change remove current table then load new table    
    select.on("change", function(event)
    {
        //remove old table
        tableContainer.empty();
        
        //load selected table
        $.ajax({
          url: $(this).val()
        }).done(function(html) {
            tableContainer.append(html);
        });
    });
    
    //trigger change to get first table
    select.trigger("change");
};


$(function() 
{
    new SelectTable();
});