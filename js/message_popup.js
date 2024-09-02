// message_popup.js
function showMessage(message, type = 'info') {
    // Create the popup element
    const popup = document.createElement('div');
    popup.className = `message-popup ${type}`;
    popup.id = 'message-popup';

    // Create message text
    const messageText = document.createElement('p');
    messageText.textContent = message;

    // Create close button
    const closeButton = document.createElement('span');
    closeButton.className = 'close-btn';
    closeButton.innerHTML = '&times;';
    closeButton.onclick = closePopup;

    // Assemble the popup
    popup.appendChild(closeButton);
    popup.appendChild(messageText);

    // Add to the page
    document.body.appendChild(popup);

    // Auto-close (optional)
    setTimeout(closePopup, 5000); // Automatically close after 5 seconds
}

function closePopup() {
    const popup = document.getElementById('message-popup');
    if (popup) {
        popup.remove();
    }
}


