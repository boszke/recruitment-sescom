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

Wyświetlenie logów:
1. Podsumowanie jest wyświetlane zawsze
2. Parametr `-v` - wyświetlenie istotnych zdarzeń
3. Paramter `-vv` - wyświetlenie wszystkich zdarzeń