function changeClass(element) {
    if (element.classList.contains("glyphicon-heart-empty")) {
        element.classList.remove("glyphicon-heart-empty");
        element.classList.add("glyphicon-heart");
        alert("on")
    } else {
        element.classList.remove("glyphicon-heart");
        element.classList.add("glyphicon-heart-empty");
        alert("off")

    }
}
