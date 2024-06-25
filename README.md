## INTRODUCTION

This is a helper dashboard for World of Warcraft Inscription profession. 

### What do you need to know if you don´t know world of warcraft:
* players have professions.
* professions can be used to craft and sell common trade goodies in a marketplace.
* this particular profession have 350+ different items  called **Glyphs**.
* Glyphs are crafted using **inks** which in turn are crafted using **Herbs** that can be harvested or bought.

___

This leaves us with the following problematic:

What are the most expensive Glyphs that i can craft?
What are the inks that i need for such glyphs?
What are the cheapest herbs that i can buy to craft said inks?

**This project answers such questions easily and provide us with useful indicators**

## FEATURES:

### On Main Page:
* Daily dataTables with fields for current price, average price, difference with yesterday and profit from selling said items.
![Main Panel](assets/screenshots/mainTable.png)
* side table with the top 10 most expensive Glyphs available for sale and which ink is needed for crafting.
![Main Panel](assets/screenshots/top10.png)
* side table that shows what is the cheapest Herb on the market for each ink (multiple herbs can be used to craft the same ink).
![Main Panel](assets/screenshots/inkHerbs.png)
___

### On Items Page:
* Table with Min, Max, AVG and current Data.
* Recursive reagent tree displaying reagent, number of them  needed and individual price.
* Line chart displaying the evolution of price over time.
 ![Main Panel](assets/screenshots/itemsPage.png)
___

### On Sales Page:
* Monthly table with all the transactions with fields for item, date, price, quantity, AVG price and % with AVG **(Anything bought over AVG or sold below AVG will be flagged as red. Likewise anything bought below AVG or sold above AVG will be marked as green)**
* Aside table with General sales data.
![Main Panel](assets/screenshots/salesPage.png)