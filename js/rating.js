document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.rating-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const recipeId = this.dataset.recipeId;
            const rating = this.querySelector('select').value;
            const avgRatingElement = this.closest('.recipe-item').querySelector('.avg-rating');
            
            if (!rating) {
                alert('Please select a rating');
                return;
            }

            fetch('../server/rate.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `recipe_id=${recipeId}&rating=${rating}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    avgRatingElement.textContent = parseFloat(data.newAvgRating).toFixed(1) + '/5.0';
                    alert('Rating submitted successfully!');
                } else {
                    alert('You have already rated this recipe. Please rate another recipe.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    });
});