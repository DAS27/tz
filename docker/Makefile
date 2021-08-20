chmod:
	docker-compose run -T web chmod -R 777 /var/www/web/assets

mkdir:
	docker-compose run -T web mkdir -m 777 /var/www/runtime/cache

migrate:
	docker-compose exec php-fpm php yii migrate

seed:
	docker-compose exec php-fpm php yii seed