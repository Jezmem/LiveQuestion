# PhotoGodard

PhotoGodard

## Installation sans Docker

Initialisation du projet

```bash
  composer install
```

Démarage du server web 
```bash
  symfony server:start
```


Initialisation de la base de données

```bash
  symfony console doctrine:database:create
  
  php bin/console doctrine:migrations:migrate
  
  symfony console doctrine:fixtures:load
```
