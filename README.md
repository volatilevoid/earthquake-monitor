# Earthquake monitoring app

## Description
API for tracking earthquake data and notify users if the earthquake magnitude is greater than the previously set threshold. 

External API docs: <https://earthquake.usgs.gov/fdsnws/event/1/>

Command for fetching  data from external API is running via cron each hour (check `app/Console/Commands/ProcessEarthquakes.php`). 

On each run it fetches earthquake data from last run datetime until the current moment.
Fetched data are filtered and only earthquakes with magnitude larger than minimal threshold in config table are passed 
further for saving into DB. Only entries that are not already persisted are passed for notifying users via email.

## Requirements
- MySql
- Redis
- PHP ^8.4
- For the list of required PHP extensions please check official Laaravel 12 docs
- make sure that web server process owner has permission to write to the cache and storage directories
- Mailgun email service accout

## Installation guide:
- Add mysql connection details in .env file
- Run `php artisan migrate`
- Run `php artisan db:seed` (before that define SUPER_ADMIN_EMAIL  and SUPER_ADMIN_PASSWORD in .env in order to not have default values for super admin) 
- Insert cron config `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1` in crontab file

## Endpoints

### Public
>GET `/api/earthquakes-public` - public endpoint for fetching earthquakes
>>NOTE: This endpoint is rate limited to 1 request per minute

>POST `/api/auth/login` - fetch auth token
>>Required parameters
>>- email
>>- password

### Protected
>POST `/api/auth/logout`- delete auth token

>GET `/api/auth/me` - logged in user details

>GET `/api/users` - list all users (only available to super admin)

>POST `/api/create-user` - create new user (only available to super admin)
>>Required parameters
>>- name
>>- email
>>- password

>GET `/api/earthquakes` - get all persisted earhquakes with magnitude larger than threshold value 

>POST `/api/set-magnitude-threshold` - set threshold for logged in user (global for super admin)
>>Required parameters
>>- threshold

For authentication user token issued via `/api/auth/login` enddpoint
