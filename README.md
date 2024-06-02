# The Sussy Movie Game
Un jeu de devinettes qui vous fera deviner un film du jour chaque jour.

## Comment jouer
Le jeu est en ligne sur https://sussy-movie-game.alwaysdata.net/

## Comment lancer en local
Il faut définir trois fichiers de configuration dans `/Config/`  
- `/Config/apiconfig.php` déclare une seule constante `API_KEY` qui doit contenir une clé d'API TMDB.
- `/Config/dbconfig.php` déclare trois constantes `DB_CONNECTION_STRING`, `DB_USERNAME` et `DB_PASSWORD` qui contiennent la connexion vers une base de données générée avec le script contenu dans `/Config/TableDefs/movie.sql`
- `/Config/hashconfig.php` déclare une seule constante `HASH_SALT` qui doit contenir un sel pour la création d'utilisateur.
