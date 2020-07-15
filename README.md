# WeSport

## WeSport c'est quoi ? 
 WeSport est une application web facilitant la mise en relation de sportifs occasionnels, permettant de trouver des équipiers et des adversaires, notamment pour des sports collectifs et pourquoi pas pour des sports individuels, par exemple faire un footing avec quelqu’un. On peut également organiser ou participer à des événements (tournoi..). 


## Procédure d'installation


**composer**: ``composer install``

**yarn**: ``yarn install``

**.env.local**: 

- *Base de données* : à la racine du dossier créer un fichier .env.local et y coller la ligne: ``DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7``   
Remplacer le nom d'utilisateur et le mot de passe ainsi que le nom de la base de données

- *Mail de l'application*: toujours dans le fichier .env.local collé la ligne :
``MAILER_URL=gmail://app_name@mail:mail_password@localhost``  
Remplacer par le mail de l'application et le mot de passe.

- *Mail de l'application dans le code*: copié-collé cette ligne
``APP_EMAIL=app_name@mail.com``.  
Elle permettra d'indiquer le mail à utiliser dans le code (celui doit être le même que celui indiqué dans la ligne précédente MAILER_URL)


**Bdd en cli**  
Pour mettre en place la base de données, il faut éxécuter les commandes suivantes en ligne de commande :  

- création de la base données: ``bin/console d:d:c``  
- création des migrations : ``bin/console m:m``
- envoie des migrations : ``bin/console d:m:m``

**Utilisation des fixtures**
Mise en place des fixtures en cli: ``bin/console d:f:l``  
mot de passe des users fixtures: "azerty"



**Mise en route de l'application**  
``yarn encore dev``
``symfony server:start --no-tls``
