const infoButton = $("#how-to-play-button");
const infoDiv = $("#how-to-play-section");
const closeButton = $("#how-to-play-section .close-button");

infoButton.on("click", () => {
    infoDiv.show();
});

closeButton.on("click", () => {
    infoDiv.hide();
});


