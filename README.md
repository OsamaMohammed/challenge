# Challenge Project

## Notes

- The app uses sqlite database in the config file.
- Allow write permissions on the folder storage/app/public

## Install

Run these commands in the project root directory.

```
touch databases/database.sqlite
touch .env
php artisan migrate
php artisan storage:link
php artisan key:generate
php artisan serve
```