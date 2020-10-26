# MyLibrary<h5>Развертывание Symfony приложения из git репозитория</h5>

### Шаг 1 - клонирование проекта git

git clone https://github.com/AlisaRaevskaya/MyLibrary.git

### Шаг 2 -установка зависимостей проекта
Чтобы развернуть все нужные компоненты нужен composer. Качаем c [https://getcomposer.org/], ставим.

Открываем терминал в директории проекта symfony, запускаем команду:
composer install. 

### Шаг 3 - Настраиваем базу данных

php app/console doctrine:schema:validate

Результат команды обычно такой:

Output
[Mapping]  OK - The mapping files are correct.
[Database] FAIL - The database schema is not in sync with the current mapping file.
]

Строка FAIL говорит о том что нет сязи с БД - нужно создать её.

Настраиваем базу данных
Создать базу данных можно как из командной строки, так и из phpmyadmin
Откроется phpmyadmin. Как в нём создать базу данных.

php bin/console doctrine:database:drop -- force
php bin/console doctrine:database:create
php bin/console doctrine:schema:update -- force
php bin/console doctrine:schema:validate


### Шаг 4 - очистить кэш

php app/console cache:clear --env=prod --no-debug 

### Шаг 5 - проверить недостающие компоненты php система скажет чего не хватает и попросить поставить то что нужно
php app/check.php
