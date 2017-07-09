E-Global code test
========================

Code test written in PHP using Symfony3 framework and ReactJS
Live example at - http://front-end.e-global-test.mihelsons.com/

Login
    
    admin@demo.com - password
    user@demo.com - password

Setup guide
--------------

1. Download Git repository

```
    git clone https://github.com/KMTests/E-GlobalTest.git
    cd E-GlobalTest
```

2. Build and start docker containers

```
    docker-compose up --build -d
```

3. Install dependencies and set up database

```
    docker-compose exec fpm sh ./bootstrap.sh
    docker-compose exec nginx sh ./boostrap.sh
```

4. Run tests to make sure everything works correctly

```
    docker-compose exec fpm vendor/bin/phpunit
```

Usage
--------------
Start using by opening http://localhost:8087
    