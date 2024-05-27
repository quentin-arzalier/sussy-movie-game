const country_input = $("#user-country");
const country_options_container = $(".country-options");
const country_options = $(".country-options li");
const spinner = $("#sussy-spinner");

country_input.on("click", () => {
    country_options_container.get(0).classList.remove("hidden");
});

country_options.on("click", (e) => {
    e.preventDefault();
    const li = $(e.target).closest("li");
    const code = li.data("code");
    country_options_container.get(0).classList.add("hidden");

    country_input.find("img").get(0).src = li.find("img").get(0).src;
    country_input.find("img").get(0).alt = li.find("img").get(0).alt;
    country_input.find("span").get(0).innerText = li.find("span").get(0).innerText;

    spinner.fadeIn();
    $.ajax({
        type: "POST",
        url: "/user/setCountryCode",
        data: {country_code: code},
        success: function() {
            spinner.fadeOut()
            country_options_container.get(0).classList.add("hidden");
            customAlert("Pays changé avec succès!", false);
        },
        error: function () {
            spinner.fadeOut();
            customAlert("Le pays n'a pas pu être sélectionné, veuillez réessayer plus tard", true);
        }
    });
});