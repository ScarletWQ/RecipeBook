
function submitForm() {
    document.getElementById('search-form').submit();
}
function confirmDelete(recipeId) {
    if (confirm('Are you sure you want to delete this recipe?')) {
        document.getElementById('delete_recipe_id').value = recipeId;
        document.getElementById('delete_form').submit();
    }
}
function editRecipe(recipeId) {
    window.location.href = 'edit_recipe.php?id=' + recipeId;
}
