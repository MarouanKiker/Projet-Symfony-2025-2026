start:
	docker compose up -d

stop:
	docker compose down

install-packages:
	docker compose run --rm php composer install

init-database:
	docker compose run --rm php php bin/console doctrine:database:create --if-not-exists
	docker compose run --rm php php bin/console doctrine:migrations:migrate --no-interaction

enter:
	docker compose exec $(service) bash
