start firefox 192.168.1.5:8080
php artisan database:backup

cmd.exe /c start /min php artisan serve --host 192.168.1.5 --port 8080 ^& exit
