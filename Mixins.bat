start firefox http://127.0.0.1:8000
php artisan database:backup

cmd.exe /c start /min php artisan serve ^& exit
