function changeClass(spanElement) {
    // Toggle the classes on the clicked span element
    if (spanElement.classList.contains("glyphicon-heart-empty")) {
        spanElement.classList.remove("glyphicon-heart-empty");
        spanElement.classList.add("glyphicon-heart");
        // Store the state in localStorage
        localStorage.setItem('heartState', 'on');
    } else {
        spanElement.classList.remove("glyphicon-heart");
        spanElement.classList.add("glyphicon-heart-empty");
        // Store the state in localStorage
        localStorage.setItem('heartState', 'off');
    }
    // Get the parent listing element
    var listingElement = spanElement.closest('.listing');
    
    // Check if the listing element exists
    if (listingElement) {
        // Remove the listing element from the DOM
        listingElement.remove();
    }
}



