#!/bin/bash
set -e

echo "Warte auf Datenbank..."
until php -r "new PDO('mysql:host=db;port=3306;dbname=demo', 'demo', 'demo123');" 2>/dev/null; do
    sleep 1
done

echo "Datenbank erreichbar. Schema erstellen..."
php bin/console doctrine:schema:create --no-interaction 2>/dev/null || php bin/console doctrine:schema:update --force --no-interaction

echo "Testdaten laden..."
php bin/console app:seed-users

echo "Server starten auf Port 8080..."
php -S 0.0.0.0:8080 -t public
