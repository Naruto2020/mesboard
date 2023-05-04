document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#form');
    const messageList = document.querySelector('#messages');
  
    form.addEventListener('submit', event => {
        event.preventDefault();
        const userName = document.querySelector('#userName').value;
        const roomName = document.querySelector('#roomName').value;
        const content = document.querySelector('#content').value;
  
        // Validation
        if (userName.length === 0 || roomName.length === 0 || content.length < 2 || content.length > 2048) {
            alert('Invalid input');
            return;
        }
  
        // Post message
        fetch('/postMessage.php', {method: 'POST', body: JSON.stringify({userName, roomName, content})})
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Failed to post message');
                    return;
                }
  
                // Get messages
                fetch('/getMessages.php?room=' + encodeURIComponent(roomName))
                    .then(response => response.json())
                    .then(data => {
                        messageList.innerHTML = '';
                        data.messages.forEach(message => {
                            const li = document.createElement('li');
                            li.textContent = message.user + ': ' + message.content;
                            messageList.appendChild(li);
                        });
                    });
            });
    });
  });