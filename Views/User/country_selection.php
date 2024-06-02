<?php
/**
 * @var User $user
 */

$user_country_name = htmlspecialchars(Locale::getDisplayRegion("-" . $user->getCountryCode(), 'fr'));
$user_country_code_lower = strtolower($user->getCountryCode());
?>

<div class="custom-input">
    <label>
        <i class="fa-solid fa-globe"></i>
    </label>
    <div id="user-country" class="country-container">
        <?php
            echo "
        <img src='/resources/img/flags/$user_country_code_lower.svg' alt='$user_country_name' width='32'/>
        <span>$user_country_name</span>
            ";
        ?>

        <ul class="country-options hidden">
            <?php
            $path = get_file_path(array("resources", "img", "flags"));
            $countries = scandir($path);
            foreach ($countries as $country) {
                if (strlen($country) != 6)
                    continue;
                $upperCode = strtoupper(substr($country, 0, 2));
                $locale = "-" . $upperCode;

                $name = htmlspecialchars(Locale::getDisplayRegion($locale, 'fr'));

                $src = "/resources/img/flags/$country";
                echo "
    <li class='country-container' data-code='$upperCode'>
        <img src='$src' alt='$name' width='32''/>
        <span>$name</span>
    </li>
";
            }

            ?>
        </ul>
    </div>
</div>


<script src="/resources/scripts/country_selection.js"></script>