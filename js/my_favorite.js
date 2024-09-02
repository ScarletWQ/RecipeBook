

document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.unfavorite-btn').forEach(button => {
        button.addEventListener('click', handleUnfavorite);
    });
});

function handleUnfavorite(e) {
    const recipeId = this.dataset.recipeId;
    
    fetch('../server/favorite.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `recipe_id=${recipeId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {

            window.location.reload();
        } else {
            alert('Failed to remove recipe from favorites. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}