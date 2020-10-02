
***<h1 align="center">Interface-MongoDB</h1>***

_Lire en d'autres langues :_

## Prérequis
- Installez PHP 7-* <br/>
- Installez Apache2

### Driver MongoDB
    $ git clone https://github.com/mongodb/mongo-php-driver.git
    $ cd mongo-php-driver
    $ git submodule update --init
    $ phpize
    $ ./configure
    $ make all
    $ sudo make install

## Dépôt Git
 - Clônez le projet dans /var/wwww/html <br/>
 - Placez-vous dans le dossier du projet (Interface-MongoDB)
 
 ## Installez les dépendances Mongo avec Composer : 
    $ composer require mongodb/mongodb

 ## Installez JsonEditor avec npm :
 - Placez vous dans le répertoire /var/wwww/html/Interface-MongoDB
 - Clonez les fichiers à partir du git :
 
       $  git clone https://github.com/josdejong/jsoneditor.git
 - Installez jsoneditor :
    
       $  npm install jsoneditor
 - Placez-vous dans le dossier jsoneditor, copiez le fichier package.json puis collez le dans le dossier Interface-MongoDB
 - Placez-vous dans le dossier Interface-MongoDB
 - Poursuivez l'installation :
            
       $  npm install
       
 - Déplacez le dossier node_modules et les fichiers package.json et package-lock.json dans le dossier jsoneditor
 - Placez vous dans le dossier jsoneditor
 - Finalisez l'installation :
 
       $  npm run build
 
### Depuis le navigateur vous pouvez accéder au projet à l'adresse localhost/Interface-MongoDB

