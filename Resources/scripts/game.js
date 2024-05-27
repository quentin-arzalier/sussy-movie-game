let currentTimeout;
const searchBar = $("#movie-search-bar");
const container = $("#movie-list-ajax");
const attempts = $("#game-attempts");

function CurriedOnMovieClick(movie_id) {
    return e => {
        e.preventDefault();
        let toRemove = $(`li[data-id=${movie_id}]`).get(0);
        container.get(0).innerHTML = "";
        container.addClass("transparent");

        $.ajax({
            type: "POST",
            url: "/game/GuessMovie",
            data: {movie_id: movie_id},
            success: function (res) {
                const div = document.createElement("div");
                div.innerHTML = res;
                attempts.get(0).appendChild(div);
                res.contains("success-movie");
            },
            error: function () {
                customAlert("Une erreur a eu lieu lors de votre essai, veuillez réessayer plus tard", true);
            }
        });
    }
}

searchBar.on("input", () => {
    if (currentTimeout)
        clearTimeout(currentTimeout);

    currentTimeout = setTimeout(() => {
        const search = searchBar.get(0).value;
        if (!search) {
            container.get(0).innerHTML = "";
            container.addClass("transparent");
            return;
        }

        $.ajax({
            type: "GET",
            url: "/movie/searchMoviesInDatabase?search=" + searchBar.get(0).value,
            success: function (res) {
                const movies = JSON.parse(res);
                container.get(0).innerHTML = "";
                for (const movie of movies) {
                    const li = document.createElement("li");
                    li.innerHTML = `
                        <img src="https://image.tmdb.org/t/p/w45${movie.poster_path}" alt="poster">
                            <div class="movie-list-info">
                            <div class="movie-list-title">${movie.title}</div>
                        </div>
`;
                    li.dataset["id"] = movie.id;
                    li.onclick = CurriedOnMovieClick(movie.id);
                    container.get(0).appendChild(li);
                }
                if (movies.length > 0)
                    container.removeClass("transparent");
            },
            error: function () {
                customAlert("Une erreur a eu lieu, veuillez réessayer.", true)
            }
        });
    }, 350);
});