let currentTimeout;
const searchBar = $("#movie-search-bar");
const container = $("#movie-list-ajax");
const attempts = $("#game-attempts");
const successMessage = document.getElementById("timer");

function CurriedOnMovieClick(movie_id) {
    return e => {
        e.preventDefault();
        container.get(0).innerHTML = "";
        container.addClass("transparent");

        startSpinner();

        $.ajax({
            type: "POST",
            url: "/game/GuessMovie",
            data: {movie_id: movie_id},
            success: function (res) {
                const div = document.createElement("div");
                div.innerHTML = res;
                attempts.get(0).appendChild(div);
                stopSpinner();
                // sélectionner l'élément avec la classe "movie-details"
                const movieDetails = div.querySelector(".movie-details-correct");
                if(movieDetails && movieDetails.classList.contains("movie-details-correct")){
                    $(".custom-input").css("display", "none");
                    $(".custom-input").css("pointer-events", "none");
                    $("#success-message").html("Bravo !! Tu as trouvé le sussy movie d'aujourd'hui");
                    setInterval(updateTime, 1000);
                }
            },
            error: function () {
                customAlert("Une erreur a eu lieu lors de votre essai, veuillez réessayer plus tard", true);
                stopSpinner();
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

$(()=>{
    const message = $("#success-message").text();
    if(message.indexOf("Tu as déjà trouvé le sussy movie d'aujourd'hui. Revien demain pour un nouveau sussy movie !") !== -1){
        setInterval(updateTime, 1000);
    }
});


// Définir la fonction à exécuter toutes les secondes
function updateTime() {
    // Calculer le temps restant jusqu'à minuit
    const now = new Date();
    const midnight = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1);
    midnight.setHours(0, 0, 0, 0); // réinitialiser l'heure à 00:00:00.000
    const timeLeft = midnight - now;

    // Convertir le temps restant en minutes et secondes
    const hours = Math.floor((timeLeft / 3600000));
    const minutes = Math.floor((timeLeft % 3600000) / 60000);
    const seconds = Math.floor((timeLeft % 60000) / 1000);

    // Afficher le temps restant dans l'élément HTML
    successMessage.textContent = `Reviens dans ${hours} heure(s) ${minutes} minute(s) et ${seconds} seconde(s)`;
}

