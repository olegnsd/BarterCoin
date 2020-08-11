Options +FollowSymLinks
Options All -Indexes
RewriteEngine on 


RewriteEngine On
#RewriteCond %{HTTP_HOST} bartercoin.ru
#RewriteRule (.*) http://bartercoin.holding.bz/$1 [R=301,L]


RewriteCond %{REQUEST_FILENAME} !-f 
RewriteCond %{REQUEST_FILENAME} !-d 
RewriteRule ^(.*)$ $1.php [L,QSA]
AddDefaultCharset UTF-8
