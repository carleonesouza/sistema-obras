echo "generating application key..."
php artisan key:generate --show

echo "Caching event..."
php artisan event:cache

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching view..."
php artisan view:cache

#echo "Running migrations..."
#php artisan migrate --force