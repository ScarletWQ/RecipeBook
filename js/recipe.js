document.addEventListener('DOMContentLoaded', function() {
    // Favorite/Unfavorite functionality
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function() {
            const recipeId = this.dataset.recipeId;
            const isFavorited = this.dataset.isFavorited === 'true';
            
            fetch('../server/favorite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `recipe_id=${recipeId}&action=${isFavorited ? 'unfavorite' : 'favorite'}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.textContent = isFavorited ? 'Favorite' : 'Unfavorite';
                    this.dataset.isFavorited = isFavorited ? 'false' : 'true';
                }
            });
        });
    });
});