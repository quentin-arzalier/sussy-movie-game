<label for="movie-search-bar">Rechercher un film:</label>
<input type="search" id="movie-search-bar">


<script>
    let currentTimeout;
    const searchBar = $("#movie-search-bar");
    searchBar.on("input", () => {
       if (currentTimeout)
           clearTimeout(currentTimeout);

       currentTimeout = setTimeout(() => {
           $.ajax("/api/searchMovieByName?name=" + searchBar.get(0).value)
               .done(function(res) {
                   let movies = JSON.parse(res);
                   console.table(movies.results);
                   console.log(movies.results.length + " movies found!");
               });
       }, 350);
    });
</script>
