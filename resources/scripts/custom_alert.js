function customAlert(message, isError)
{
    const newElt = document.createElement("div");
    newElt.classList.add("custom-alert");
    newElt.classList.add(isError ? "error-alert" : "success-alert");
    newElt.innerText = message;


    const body = document.querySelector("body");
    body.appendChild(newElt);

    setTimeout(() => {
        body.removeChild(newElt);
    }, 4000);
}

const spinner = $("#sussy-spinner");
const startSpinner = () => spinner.fadeIn();
const stopSpinner = () => spinner.fadeOut();