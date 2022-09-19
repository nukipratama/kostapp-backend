# Kost App Backend
A Mini Project for Kost's Management by using CRUD from Database. This project is built on Laravel 8.

# Specification
- PHP 7.4.3
- Laravel 8.75
- Laravel Sanctum 2.15

# Documentation
Please open this [documentation link](https://documenter.getpostman.com/view/9430219/2s7YtXhD4L) for how to use this API.

# Scheduling Task
This project also implement scheduled task for recharging credit on the first day of every month at 00:00 named **recharge:credit**.
To run manually the scheduling:
1. Check the task
```
    php artisan schedule:list
```
2. Run the task
```
    php artisan recharge:credit
```
or you can use **Crontab**:
1. Open crontab file
```
    crontab -e
```
2. Edit crontab file and add
```
    0 0 1 * * cd /your-project-path && php artisan recharge:credit >> /dev/null 2>&1
```

# Installation
1. Clone this Repo
```
    git clone https://github.com/nukipratama/kostapp-backend.git
```
2. Copy file .env.example and rename it to .env
```
    cp .env.example .env
```
3. Edit .env, fill DB setting and save
4. Run this command to initialize migrations, seeds, config / route cache, and starting the project
```
    php artisan project:init
```

# Dummy Account
If you run the project via 'project:init' or runnning 'db:seed' then the seeders will automatically create 3 acccount with different roles, for testing purpose. 
Here is the details of the seeded accounts (email / password / role):
- owner@kostapp.dev / password / Owner
- regular@kostapp.dev / password / Regular User
- premium@kostapp.dev / password / Premium User