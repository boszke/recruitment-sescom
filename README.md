Uruchomienie za pomocą Dockera:

```bash
docker-compose run app
composer install
```

Uruchomienie skryptu:
```bash
php src/index.php reports:generate data/recruitment-task-source.json
```

Testy jednostkowe:
```bash
vendor/bin/phpunit
```
