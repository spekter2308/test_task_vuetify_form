## Set Up

1. setup nginx config file (attached in project)
2. /project - composer install, php artisan db:seed --class=CountriesSeeder + .env file with settings
3. create .env file in client with line 'APP_URL=http://test.loc' for working api queries
4. /project/client - npm install


## Run project
/client - npm run dev

Для виконання тестового завдання було взято чистий Laravel + Nuxt3/Vue3
1) Реалізовано форму на фронтенді з підключенням Vuetify
2) Прапори країн по юнікодах відображаються не у всіх браузерах, коректне відображення в MozillaFirefox
3) Реалізовано код для реєстрації юзера та відправки нотифікації по емейлу та sms на бекенді, але без кодів для sms це не тестувалось
