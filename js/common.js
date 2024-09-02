document.addEventListener('DOMContentLoaded', function() {
    checkAuthStatus();
});

function checkAuthStatus() {
    fetch('../server/check_auth.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            updateAuthUI(data);
        })
        .catch(error => {
            console.error('Error checking auth status:', error);
        });
}

function updateAuthUI(data) {
    const authLink = document.getElementById('auth-link');
    const welcomeMessage = document.getElementById('welcome-message');

    if (authLink && welcomeMessage) {
        if (data.is_logged_in) {
            authLink.href = '../server/logout.php';
            authLink.textContent = 'Logout';
            welcomeMessage.textContent = `Welcome, ${data.username}!`;
        } else {
            authLink.href = '../pages/login.html';
            authLink.textContent = 'Login';
            welcomeMessage.textContent = 'Welcome, Guest!';
        }
    }
}


