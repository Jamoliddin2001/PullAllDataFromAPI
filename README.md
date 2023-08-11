<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



## WORK

Added AES encryption to securely retrieve the key to store the key in encrypted form in the database. Implemented a class to get the decryption key. To add a key to the database, the command:
"**php artisan app: add-key {key}**" is implemented, where the entered value is saved in encrypted form.


To get data and save it in the database, a controller is implemented where you can call it through the API. Since, apart from Stocks, other data was empty, I could not add their essence, but the logic will be the same as stocks.
