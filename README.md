# LiveQuestion

Initialisation du projet

```bash
  composer install
```


Initialisation de la base de données

```bash
  symfony console doctrine:database:create
  
  symfony console doctrine:migrations:migrate
  
  symfony console doctrine:fixtures:load
```

Démarage du server web 
```bash
  symfony server:start
```
