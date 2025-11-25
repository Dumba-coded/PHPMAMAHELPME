document.addEventListener('DOMContentLoaded', function() {
    const reviewStars = document.querySelectorAll('.reviewstars');
    const storageKey = 'userReviews' /* stores ratings in local storage & only allows a user to review once */

    /* to fill stars based on average total. container argument is the amount of stars given, rating is the average value */
    function totalStars(container, rating){
        const stars = document.querySelectorAll('.star')
        const roundedRating = Math.round(rating); /* rounds to the nearest whole, since stars can only be filled entirely */
        stars.forEach((star, index) => {
            /* works like a for loop in python; goes through each star in this case */
            /* if statement below ensures that the right amount of stars is filled. if this if statement isn't used, the stars will always fill as 5.0, even after the rounding, no matter what */
            if (index < roundedRating) {
                star.classList.add('filled'); /* filled class in css turns star yellow — this function adds the class if the star is filled */
                star.innerHTML = '&#9733'; 
            } else {
                star.classList.remove('filled'); /* removes filled class if star is not checked */
                star.innerHTML = '&#9734';
            }
        }); 

    }

    const finishedRatings = JSON.parse(localStorage.getItem(storageKey)) || {}; /* checks local storage for any saved ratings with storageKey. 
    it becomes empty object {} if there are no saved variables in the local storage */

    for(let container of reviewStars){
        const rating = container.dataset.userReview;
        let averageRating = parseFloat(container.dataset.averageRating) || 0; /* default is 0 if there is no average rating */
        
        /* fills stars when page loads */
        updateStars(container, averageRating);

        if (finishedRatings[rating]){
            container.classList.add('rated');
        } /* only allows user to rate once, as the rating css style disables clicks */
        
    }
});
