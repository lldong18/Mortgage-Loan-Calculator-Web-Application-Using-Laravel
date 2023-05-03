# Mortgage Loan Calculator Web Application Using Laravel

Intended for [Info Websight EDM Solutions](http://websightedmsolutions.com/) &reg;

Development & Design by Ehsan Marufiazar &ndash; May 3<sup>rd</sup>, 2023.

Follow the instructions below to setup and run the application.

1. Download an appropriate version of XAMPP for your system from [here](https://www.apachefriends.org/download.html) (the codebase has been developed with Laravel v8.83.27 & PHP v8.1.4).
2. Using XAMPP, create a database to be latter connected to the webapp.
3. Create a directory and `cd` into it; for example:
   ```
   mkdir c:\mortgage-loan-calculator
   cd c:\mortgage-loan-calculator
   ```
4. Make sure you have [Git](https://git-scm.com/downloads) installed on your system. 
5. Clone the codebase from the Github repository:
   ```
   git clone https://github.com/EhsanMarufi/Mortgage-Loan-Calculator-Web-Application-Using-Laravel.git .
   ```
6. Make sure you have [Composer](https://getcomposer.org/download/) installed. Install all of the framework's dependencies using the following command:
   ```
   composer install
   ```
7. Edit the `.env` file and enter the database credentials you've assigned in step #2 above; The following is an excerpt of the `.env` file displaying the appropriate database entries to be modified:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mortgage_loan_webapp
   DB_USERNAME=root
   DB_PASSWORD=
   ``` 
8. Migrate the selected database with the data structure imposed by the webapp:
   ```
   php artisan migrate
   ```
9. You can start by running the provided software tests by entering the following command:
   ```
   php artisan test
   ```
10. Finally, to run the app in your browser, simply start a configured Webserver; you may utilize the PHP Built-in Webserver using the following command:
   ```
   php artisan serve
   ```
   
Thank you :)
