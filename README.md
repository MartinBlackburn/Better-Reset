#Better-Reset

Creating a better CSS reset by comparing all elements styles on each major browser and only resetting inconsistencies.

**elementStyles/allElements.html**  
This is a list of all HTML elemets on a single page, with no styling applied.  
(warning its not pretty)

**elementStyles/getStyles.js**  
This gets all the styles for every element and creates a table (for each element) at the bottom of the page.  
(warning, this make the page VERY large)

**comparison/index.html**  
This has tables of each element and their CSS properties across each browser.  
Only rows with differences will be displayed, as anything that is the same accross browsers doesn't need to be "reset".

**reset/betterReset.css**  
This will be the new reset, worked out from the comparison tables.