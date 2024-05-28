document.addEventListener('DOMContentLoaded', (event) => {
    const stars = document.querySelectorAll('.rating span');
    let currentRating = 0;

    if (currentRating === 0) {
        // Add event listeners only if currentRating is 0
        stars.forEach((star, index) => {
            star.addEventListener('mouseover', () => {
                highlightStars(index);
            });

            star.addEventListener('mouseout', () => {
                highlightStars(currentRating - 1);
            });

            star.addEventListener('click', () => {
                currentRating = index + 1;
                highlightStars(index);
            });
        });
    } else {
        // Disable pointer events for all stars if currentRating is not 0
        stars.forEach((star) => {
            star.style.pointerEvents = 'none';
        });
    }

    function highlightStars(index) {
        stars.forEach((star, i) => {
            if (i <= index) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }
});
