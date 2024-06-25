@echo off
:: Copy
copy "C:\Program Files (x86)\World of Warcraft\_classic_\WTF\Account\**YOUR ACCOUNT**\SavedVariables\AipoxMailLedger.lua" "C:\**YOUR ROUTE TO GITHUB REPO**\wowscrap\"

:: If copied Delete
if %errorlevel% equ 0 (
    del "C:\Program Files (x86)\World of Warcraft\_classic_\WTF\Account\**YOUR ACCOUNT**\SavedVariables\AipoxMailLedger.lua"
    del "C:\Program Files (x86)\World of Warcraft\_classic_\WTF\Account\**YOUR ACCOUNT**\SavedVariables\AipoxMailLedger.lua.bak"
)
:: Execute insert into DB
"C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe" http://localhost/wowscrap/scripts/insertTransactions.php
