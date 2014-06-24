Getting Started With Wiki
==================================

## Installation

1. Installation de composer
2. Cloner le projet
3. Installation des vendors
4. Verification de la configuration
5. Création de la BDD

### Step 1: Installation de composer

Rien de plus simple il suffit de suivre ce lien : https://getcomposer.org/

### Step 2: Cloner le projet

``` bash
$ git clone https://github.com/vignejerome/wiki.git
```

### Step 3: Create your User class

``` bash
$ php composer install
```

### Step 4: Vérification de la configuration

Vérifier bien que tout est ok dans la configuration.

``` bash
$ php app/check.php
```

### Step 5: Création de la base de données

Copier et renomer le fichier parameter.yml.dist en parameter.yml et y rajouter votre configuration.
Une fois enregistré éxécuter les commandes suivantes :

``` bash
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
```
