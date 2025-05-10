
# Online Wallet Application

## Description:
This is a simple laravel 12 application that provides two REST endpoints for handling payment operations: one for receiving payment notifications and another to let user sending payment requests.

Endpoints
- Receive Payment Notification:
    - Purpose: Handles incoming payment notifications from external sources (e.g. banks).
    - Process: Accepts a batch of payment transactions and Dispatches a background job for each transaction, Parses transaction data based on the bank format and stores it in the database.

- Send Payment Request
    - Purpose: Accepts payment request from user with basic validation.
    - Process: Builds an XML-formatted payload based on the request data. and  Logs the generated XML for further processing.

- Postman Collection
    - https://www.postman.com/orange-astronaut-877368/online-wallet/overview 

## Tech Highlights
- Regarding Receive Payment Notification Endpoint:
    - Used background jobs to process received transactions, created a factory method to return bank parser based on the transaction format.
    - Mapped Parsed Transactions to DTOs to provide some sort of Data encapsulation & validation, and to make it cleaner.
    - Used Laravel horizon to handle background jobs.
    - Locked transaction creation from application level, to prevent race condition.
    - Also added unique key on `reference` to prevent race condition on database level.
    - For simplicity, to Assign user to a transaction, i retireived the first user form the db.
- Regarding Send Payment Request Endpoint:
    - Used Background jobs to build the xml body from the request data.
    - Used laravel pipeline to build xml body based on pipes.
    - Used DTO to pass the request data over pipes.
    - Used Constants/Enums to prevent magic numbers/types and make more readable.
    - Added a proper logs to track request processing.
    - User calling this API should be authenticated but For simplicity instead of implementing authentication, we got some of User (sender) data from the request.
- Wrote feature and unit tests for the solution.

## Tech Stack:
- This project is built with the following technologies:
    - Framework: Laravel 12
    - Language: PHP 8.3
    - Database: MySQL 8
    - Queue & Cache: Redis
    - Job Processing: Laravel Queues (Redis driver)
    - Logging: Laravel built-in logging
    - XML Handling: Custom XML builder with Pipeline pattern

## Setup Instructions
 ### 1. Clone the Repository
    git clone git@github.com:Abdulaziz-Aladwi/online-wallet-application.git
    cd your-repo
 ### 2. Install Dependencies
    composer install
 ### 3. Configure Environment
    cp .env.example .env
### 4. Generate the application key:
    php artisan key:generate
### 5. Configure Database
##### Update your .env with your MySQL 8 settings, then run:
    php artisan migrate
### 6. Queue Setup
##### Make sure that redis is running then run:
    php artisan horizon
###  To run tests
    php artisan test    
###  To run Seeder
    php artisan db:seed    
