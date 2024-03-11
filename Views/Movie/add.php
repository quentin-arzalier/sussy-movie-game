
<h2>Ajouter un film</h2>

<div class="custom-input">
    <label for="movie-search-bar">
        <i class="fa-solid fa-magnifying-glass"></i>
    </label>
    <input placeholder="Ajouter un film" type="search" id="movie-search-bar">
</div>

<ul class="movie-list transparent" id="movie-list-ajax">
</ul>



<script>
    let movieIdsInDatabase = [
        <?php
            foreach ($movies as $movie)
                echo $movie->getIdMovie() . ','
        ?>
    ];
    let currentTimeout;
    const searchBar = $("#movie-search-bar");
    const container = $("#movie-list-ajax");

    function CurriedOnMovieClick(movie_id)
    {
        return e => {
            e.preventDefault();
            let toRemove = $(`li[data-id=${movie_id}]`).get(0);
            // On garde l'élément mais on le cache pour le remettre si jamais il y a erreur
            toRemove.classList.add("hidden");

            $.ajax({
                type: "POST",
                url: "/api/addMovieToDatabase",
                data: {movie_id: movie_id},
                success: function() {
                    alert("Film ajouté à la base de données!");
                    movieIdsInDatabase.push(movie_id);
                    // On supprime réellement la ligne
                    container.get(0).removeChild(toRemove);
                    if (container.childNodes.length === 0)
                    {
                        container.addClass("transparent");
                    }
                },
                error: function () {
                    // On réaffiche le film.
                    toRemove.classList.remove("hidden");
                    alert("Le film n'a pas pu être ajouté, veuillez réessayer plus tard");
                }
            });
        }
    }


    searchBar.on("input", () => {
       if (currentTimeout)
           clearTimeout(currentTimeout);

       currentTimeout = setTimeout(() => {
           const search = searchBar.get(0).value;
           if (!search)
           {
               container.get(0).innerHTML = "";
               container.addClass("transparent");
               return;
           }

           $.ajax({
               type: "GET",
               url: "/api/getNewMoviesFromAPI?name=" + searchBar.get(0).value,
               success: function(res) {
                   const movies = JSON.parse(res);
                   container.get(0).innerHTML = "";
                   for (const movie of movies.results) {
                       if (movieIdsInDatabase.includes(movie.id))
                           continue;

                       const li = document.createElement("li");
                       li.innerHTML = `
                            <img src="https://image.tmdb.org/t/p/w92${movie.poster_path}" alt="poster">
                                <div class="movie-list-info">
                                        <div class="movie-list-title">${movie.original_title}</div>
                                        <div class="movie-list-desc">${movie.overview}</div>
                            </div>
                       `;
                       li.dataset["id"] = movie.id;
                       li.onclick = CurriedOnMovieClick(movie.id);
                       container.get(0).appendChild(li);
                   }
                   container.removeClass("transparent");
               },
               error: function () {
                   alert("Une erreur a eu lieu, veuillez réessayer.")
               }
           });
       }, 350);
    });
</script>
