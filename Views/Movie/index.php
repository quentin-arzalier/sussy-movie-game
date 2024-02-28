<table>
    <thead>
        <tr>
            <th>ID du film</th>
            <th>Langue du film</th>
            <th>Date de sortie</th>
            <th>Durée du film</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($movies as $movie)
    {
        $id_movie = $movie->getIdMovie();
        $language = $movie->getOriginalLanguage();
        $release_date = $movie->getReleaseDate();
        $runtime = $movie->getRuntime();
        echo "
        <tr>
            <td>$id_movie</td>
            <td>$language</td>
            <td>$release_date</td>
            <td>$runtime</td>
        </tr>
        ";
    }
    ?>
    </tbody>
</table>