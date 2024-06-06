let currentTimeout;
let movieIdsInDatabase;
const searchBar = $("#movie-search-bar");
const container = $("#movie-list-ajax");
const addPopularButton = $("#add-popular-button");

function CurriedOnMovieClick(movie_id)
{
    return e => {
        e.preventDefault();
        let toRemove = $(`li[data-id=${movie_id}]`).get(0);
        // On garde l'élément mais on le cache pour le remettre si jamais il y a erreur
        toRemove.classList.add("hidden");

        startSpinner();

        $.post("/admin/api/addMovieToDatabase", {movie_id: movie_id})
            .done(function() {
                customAlert("Film ajouté à la base de données!", false);
                movieIdsInDatabase.push(movie_id);
                // On supprime réellement la ligne
                container.get(0).removeChild(toRemove);
                if (container.get(0).childNodes.length === 0)
                {
                    container.addClass("transparent");
                }
            })
            .fail(function() {
                // On réaffiche le film.
                toRemove.classList.remove("hidden");
                customAlert("Le film n'a pas pu être ajouté, veuillez réessayer plus tard", true);
            })
            .always(function() {
                stopSpinner();
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

        $.get("/admin/api/getNewMoviesFromAPI?name=" + searchBar.get(0).value)
            .done(function(res) {
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
            })
            .fail(function() {
                customAlert("Une erreur a eu lieu, veuillez réessayer.", true)
            });
    }, 350);
});

addPopularButton.on("click", () => {
    startSpinner();

    $.post("/admin/api/addPopularMovies", { })
        .done(function(res) {
            if (parseInt(res) > 0)
            {
                customAlert(`${res} nouveaux films ajoutés à la base de données!`, false);
            }
            else {
                customAlert("Aucun nouveau film n'a été ajouté. Plus de films populaires disponibles.", true);
            }
        })
        .fail(function() {
            customAlert("Les films populaires n'ont pas pu être ajoutés.", true);
        })
        .always(function() {
            stopSpinner();
        });
})