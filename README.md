## Salla Integration App

This is a simple Laravel API project to integrate with Salla Apis and manage some operations of salla ecommerce platform.<br />
This app can be used to implement anthoer ecommerce platform by implementing the needed interfaces and overrides thier methods to integrate with the new ecommerce service provider (Using Factory desgin pattern)<br />
This app contains the handling of apis(store details - create customer - List Products - product details - create order) beside the apis of handling the creation of access token and refresh token api.

The App has two paths <br />
First for the admin which will be create automatically using a seeder and the admin can login and call all the apis including the apis of getting the access token for the app (just first time after that will use refresh token to get it).<br />
Second for user who can be register and login and call specific apis ( List Products - product details - create order ).

## After running the below Setup steps you need to be aware of that
1- In first time calling Salla api need to get access token so there is an api in the app called 'ecommerce/auth' which return the login url to you Salla APP.Open this link in the browser and login with app email and password and give it the permission then you will see this message "Integrated Successfully with Salla" and this mean we got the access token and we do not need this step again because we will depend on refresh token in case of the access token expired.<br />
2- in .env file change the value of QUEUE_CONNECTION to be database (QUEUE_CONNECTION=database). <br />
3- run "php artisan queue:work --queue=order_creation" to run the queue of creating order api.<br />
4- There is a postman collection of apis in the attached.<br />


## Setup steps
Clone the repository

git clone git@github.com:MohamedElMansy/salla-app.git

Switch to the repo folder

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Install passport

    php artisan passport:install

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run Admin Seeder to create the Admin

    php artisan db:seed --class=AdminSeeder
    
Start the local development server

    php artisan serve



[salla integration app.postman_collection.json](https://github.com/MohamedElMansy/salla-app/files/14488609/salla.integration.app.postman_collection.json)
