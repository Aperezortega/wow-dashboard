# World of Warcraft profession dashboard
This World of Warcraft Inscription Helper Dashboard is designed to help players maximize their profits by identifying the most profitable glyphs to craft, the required inks, and the most economical herbs to buy. The elements are created from Auctionator shopping lists, and item information is scraped from Wowhead using the HTML DOM parser.
## Features

- **Data tables and side tables with relevant information**:
- **Item page with detailed info, component treelike view and graphs**:
- **sales/purchases registry**:
- **Scripts for reading and uploading daily export data from auctionator export.csv**:
- **Wowhead item and item reagent scrapping**:
- **Lua addon for wow that records all AH Sales/purchases by reading mailbox**:

## How It Works

### Workflow


1. **Price comparisson **:
   - Use the Auctionator addon to create a shopping list.
   - Search for all items in the shopping list.
   - Export the data and save it as `assets/export.csv`.
   - Execute the `scripts/insertExport.php` script to insert the data into the database.

2. **Sales/Purchase data**:
   - Install Addon from subfolder wowMailLedger or from its repository: [https://github.com/Aperezortega/wowMailLedger](Github Repository)
   - Copy  the following file C:\Program Files (x86)\World of Warcraft\_classic_\WTF\Account\**YOUR ACCOUNT**\SavedVariables\AipoxMailLedger.lua" (there is a bat file in assets to automatize this)
   - Execute 'scrips/insertTransactions.php' in order to insert the transactions data into the db

### Scripts

1. **insertExport.php**:
   - **Purpose**: Reads data from a CSV file and inserts it into the database.
   - **Functionality**:
     - Opens and reads the `assets/export.csv`
     - Parses the data and selects relevant columns (Price, Name, Available).
     - Inserts the data into the `scrap` table in the database.
     - **If an item is not found in the `items` table, it creates a new item entry and look up the item in wowhead to find its reagents, and introduces them also in the database**

2. **insertTransactions.php**:
   - **Purpose**: Reads transaction data from a Lua file and inserts it into the database.
   - **Functionality**:
     - Opens and reads the `AipoxMailLedger.lua`
     - Uses regular expressions to extract transaction data.
     - Parses the data and stores it in an array.
     - Inserts the transaction data into the database.

3. **copia.bat**:
   - **Purpose**: Automates the process of copying the Lua file and executing the PHP script to insert data into the database.
   - **Functionality**:
     - Copies the `AipoxMailLedger.lua` file from the World of Warcraft directory to the GitHub repository directory.
     - Deletes the original Lua file and its backup if the copy is successful.
     - Opens a web browser to execute the `insertTransactions.php` script, which inserts the data into the database.

## Setup Instructions

### Prerequisites

- A database manager (e.g., [HeidiSQL](https://www.heidisql.com/download.php)).
- A local server capable of running PHP (e.g., [XAMPP](https://www.apachefriends.org/es/index.html)).
- The Auctionator addon for creating shopping lists in World of Warcraft. You can download it from [CurseForge](https://www.curseforge.com/wow/addons/auctionator).
- The wowMailLedger addon (that i made) for recording all auction house sales/purchases by reading the mailbox. You can download it from its repository: [wowMailLedger](https://github.com/Aperezortega/wowMailLedger).

### Installation

1. **Download and Install Prerequisites**:
   - Download and install HeidiSQL.
   - Download and install XAMPP.

### Code Structure

- **index.php**: The main entry point for the dashboard. It initializes the application and loads the main interface.
- **items.php**: Contains the logic for the items page, displaying Min, Max, AVG, and current data, a recursive reagent tree, and a price evolution line chart.
- **salespurchases.php**: Contains the logic for the sales and purchases page, including a monthly table with all transactions and a general sales data table.
- **db.php**: Manages the database connection and interactions.
- **controller.php**: Acts as the controller for handling requests and coordinating between the view and the model.
- **functions.php**: Contains various helper functions used throughout the application.
- **scripts/**: Contains various PHP scripts for data processing and database interactions:
  - **insertExport.php**: Reads data from a CSV file and inserts it into the database.
  - **insertTransactions.php**: Reads transaction data from a Lua file and inserts it into the database.
  - **copia.bat**: Automates the process of copying the Lua file and executing the PHP script to insert data into the database.
- **htmldomparser/**: Contains the HTML DOM parser library used for parsing HTML content.
- **wowMailLedger/**: Contains the submodule for handling mail ledger data.
- **assets/**: Contains static assets such as the `export.csv` file used for importing price data and copia.bat to copy and delete addon files into the repository folder.
### Customization

- **Addon Usage**: The addon can be used for any profession, not just Inscription. The elements inserted into the database are those added to the Auctionator shopping list, allowing for flexibility in tracking and managing items across different professions.

### Disclaimer

This tool is intended for educational purposes only. Please respect the terms of service of World of Warcraft.