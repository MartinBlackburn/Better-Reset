#Better-Reset

Creating a better CSS reset by comparing all elements styles on each major browser and only resetting inconsistencies.

**elementStyles/allElements.html**  
This is a list of all HTML elemets on a single page, with no styling applied.

**elementStyles/getStyles.js**  
This gets all the styles for every element on the page, then post the results to the database.  
Warning, this takes a while and may lock the browser until it finishes.

**comparison/index.html**  
The index to all the comparison tables, with a way to select which table (element) to view.

**comparison/generateTables.php**  
Generates a comparison table for each browser from the database.  
This needs to be run through terminal, not a browser, as it is a little slow.

**comparison/assets/styles.css**  
Styles for the comparison tables, and the page they are on.

**comparison/assets/selectTable.js**  
JavaScript to change between each table (element).

**comparison/elements/element**  
An element's table of CSS properties across each browser.  
Only rows with differences will be displayed, as anything that is the same across browsers doesn't need to be "reset".

**reset/betterReset.css**  
This will be the new reset, worked out from the comparison tables.