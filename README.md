#Better-Reset

Creating a better CSS reset by comparing all elements styles on each major browser and only resetting inconsistencies.

**elementStyles/allElements.html**  
This is a list of all HTML elemets on a single page, with no styling applied.  
(warning its not pretty)

**elementStyles/getStyles.js**  
This gets all the styles for every element on the page.  
May post the result to a database?

**comparison/index.html**  
The index to all the comparison tables, with a way to select which table to view. 
Tables will be generated from the database

**comparison/elements/element**  
An element's table of CSS properties across each browser, this gets pulled into the index.  
Only rows with differences will be displayed, as anything that is the same across browsers doesn't need to be "reset".

**reset/betterReset.css**  
This will be the new reset, worked out from the comparison tables.