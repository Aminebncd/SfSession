# Application de Gestion de Sessions

Cette application web est conçue pour faciliter la gestion des sessions de formation. Elle permet aux utilisateurs de créer, modifier et visualiser des sessions de formation, ainsi que d'inscrire des stagiaires à ces sessions.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants :

- **PHP 8.3:** Assurez-vous d'avoir PHP version 8.3 ou supérieure installée sur votre système.
- **Composer:** Outil de gestion des dépendances PHP. [Installation de Composer](https://getcomposer.org/download/).
- **scoop.sh (Windows) :** Un gestionnaire de paquets pour Windows. [Installation de scoop.sh](https://scoop.sh/).
- **Symfony CLI:** Outil en ligne de commande pour le développement Symfony. [Installation de Symfony CLI](https://symfony.com/download).

## Installation

1. Cloner le dépôt Git :

    ```bash
    git clone https://github.com/votre-utilisateur/your-repo.git
    ```

2. Installer les dépendances avec Composer :

    ```bash
    composer install
    ```

3. Configurer la base de données dans le fichier `.env`.

4. Créer la base de données et exécuter les migrations :

    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

5. Installer les bundles nécessaires :
   
   - **Doctrine Fixtures Bundle :** Pour la génération de données de test. [Documentation](https://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html).
   ```bash
   composer require --dev orm-fixtures

   - **KnpPaginatorBundle :**Pour la pagination des résultats. [Documentation](https://github.com/KnpLabs/KnpPaginatorBundle).
   ```bash
   composer require knplabs/knp-paginator-bundle

6. Deployer l'application sur un serveur web compatible avec symfony

## Utilisation

1. Accéder à l'application via votre navigateur web.
2. Connectez-vous en utilisant vos identifiants.
3. Explorez les différentes fonctionnalités disponibles :
    - Créez de nouvelles sessions de formation.
    - Modifiez les détails des sessions existantes.
    - Inscrivez et désinscrivez des stagiaires à/from une session.
    - Consultez les détails des sessions, y compris les programmes associés et les stagiaires inscrits.