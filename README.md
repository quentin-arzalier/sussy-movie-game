# The Sussy Movie Game
Un jeu de devinettes qui vous fera deviner un film du jour chaque jour.

## Introduction
Sussy Movie Game est un projet de jeu en ligne utilisant une architecture MVC pour séparer les préoccupations liées aux données, à l'affichage et à la logique de contrôle. Cette approche facilite la maintenance, la scalabilité et le développement collaboratif.

## Architecture MVC
L'architecture MVC divise l'application en trois composants principaux : Modèle, Vue et Contrôleur.

### Modèle (Model)
Le modèle représente les données de l'application et la logique métier. Il ne contient aucune information sur l'interface utilisateur. Dans Sussy Movie Game, le modèle gère les données relatives aux films, utilisateurs, scores, etc.

#### Responsabilités :
- Gestion des données (création, lecture, mise à jour, suppression)
- Communication avec la base de données
- Logique métier

### Vue (View)
La vue est responsable de l'affichage des données fournies par le modèle à l'utilisateur. Elle représente l'interface utilisateur et ne contient aucune logique métier.

#### Responsabilités :
- Affichage des données du modèle
- Gestion des interactions utilisateur
- Mise à jour de l'interface utilisateur en fonction des données du modèle

### Contrôleur (Controller)
Le contrôleur sert d'intermédiaire entre le modèle et la vue. Il reçoit les entrées de l'utilisateur via la vue, traite ces entrées (par exemple, en appelant des méthodes du modèle) et retourne les résultats à la vue.

#### Responsabilités :
- Gestion des interactions utilisateur
- Validation des entrées utilisateur
- Mise à jour du modèle et de la vue

## Routeur
Le routeur est responsable de la gestion des URL et de la navigation dans l'application. Il mappe les requêtes HTTP aux contrôleurs correspondants.

### Fonctionnement :
- Analyse l'URL demandée par l'utilisateur
- Détermine le contrôleur et l'action à exécuter
- Passe les paramètres nécessaires au contrôleur
- Gère les erreurs de routage (ex: pages 404)

## Comment jouer
Le jeu est en ligne sur https://sussy-movie-game.alwaysdata.net/

## Comment lancer en local
Il faut définir trois fichiers de configuration dans `/Config/`  
- `/Config/apiconfig.php` déclare une seule constante `API_KEY` qui doit contenir une clé d'API TMDB.
- `/Config/dbconfig.php` déclare trois constantes `DB_CONNECTION_STRING`, `DB_USERNAME` et `DB_PASSWORD` qui contiennent la connexion vers une base de données générée avec le script contenu dans `/Config/TableDefs/movie.sql`
- `/Config/hashconfig.php` déclare une seule constante `HASH_SALT` qui doit contenir un sel pour la création d'utilisateur.
