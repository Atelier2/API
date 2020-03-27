## GeoQuizz API
Repository contenant les 3 API que nous avons développées pour le projet GeoQuizz (une pour chaque client).

## Installation
Les API ne nécessitent aucune installation car elles sont déployées sur un serveur distant. Nous avons rencontré des problèmes lors du déploiement sur Docketu, nous avons donc décidé de déployer sur un autre serveur supportant docker pour pouvoir construire notre architecture micro-services.  

Les API sont disponibles aux adresses suivantes :  
**API Mobile :** http://51.91.8.97:18380  
**API Player :** http://51.91.8.97:18180  
**API Backoffice :** http://51.91.8.97:18280 

Les documentations des API sont accessibles en GET à leur racine respective.  

#### Installation locale
Si vous voulez cependant installer les API pour les lancer en local vous pouvez le faire avec cette commande depuis la racine du repository.
```
docker-compose up -d
```
Ensuite, installez les dépendances de chaque API avec la commande suivante depuis leur conteneur respectif.
```
composer install
```
Veillez aussi à ajouter les ```VHOST_HOSTNAME``` de chaque API dans votre fichier hosts.  

Pour la création de la base de données, les instructions sont dans le README du repository [BDD](https://github.com/Atelier2/BDD).

## Informations
Les API sont appelées depuis les différentes applications en HTTP et non en HTTPS car les requêtes vers des URL en HTTPS possédant un certificat auto-signé sont bloquées. Nous sommes conscients que c'est une faille à la sécurité mais nous n'avons pas le temps de nous préoccuper des problèmes de certificats.