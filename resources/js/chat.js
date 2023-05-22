import moment from 'moment';


document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('chat-form');
    const messageInput = document.getElementById('message');
    const chatContainer = document.getElementById('chat-container');
    const receiverId = document.querySelector('input[name="receiver_id"]').value;

    function fetchChats() {
        axios.get('/direct/inbox', { params: { receiver_id: receiverId } })
            .then(response => {
                chatContainer.innerHTML = response.data.chats.map(chat => {
                    const isSender = chat.sender.id === parseInt(receiverId);
                    const position = isSender ? 'left' : 'right';
                    const time = moment(chat.created_at).fromNow();
                    const profilePictureUrl = chat.sender.profile_picture_url;
                    const senderName = chat.sender.name;
                    const message = chat.message;
                    return `
                    <div style="display: flex; flex-direction: column; align-items: ${position}; margin-bottom: 10px;">
                      <div style="display: flex; align-items: center;justify-content: ${isSender ? 'start':'end'};">
                        <img src="${profilePictureUrl}" width="30" height="30" style="border-radius: 50%;">
                        <strong>${senderName}</strong>
                      </div>
                      <div style="background-color: ${isSender ? '#feda75' : '#d62976'};text-align: ${isSender ? 'left': 'right'}; color: ${isSender ? 'black' : 'white'}; padding: 10px; border-radius: 5px;">
                        <b>${message}</b>
                        <small style="color: ${isSender ? 'black' : 'white'};float: ${isSender ? 'right': 'left'}">(${time})</small>
                      </div>
                    </div>
                  `;
                }).join('');
                chatContainer.scrollTop = chatContainer.scrollHeight;
                markNotificationsAsRead();
            })
            .catch(error => {
                console.error('Error fetching chats:', error);
            });
    }
    function markNotificationsAsRead() {
        axios.post('/direct/mark-as-read')
            .then(response => {
                const badgeElement = document.getElementById('unread-notifications-count');
                badgeElement.textContent = '';
            })
            .catch(error => {
                console.error('Error marking notifications as read:', error);
            });
    }

    function sendMessage(event) {
        event.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        const senderName = document.querySelector('input[name="sender_name"]').value;
        const senderProfilePictureUrl = document.querySelector('input[name="sender_profile_picture_url"]').value;

        axios.post('/direct/inbox', {
            message: message,
            receiver_id: receiverId
        })
            .then(response => {
                const time = moment().fromNow();
                chatContainer.innerHTML += `
                  <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
                    <div style="display: flex; align-items: center;justify-content: end;">
                      <img src="${senderProfilePictureUrl}" width="30" height="30" style="border-radius: 50%;">
                      <strong>${senderName}</strong>
                    </div>
                    <div style="background: #d62976;color: #ffffff; padding: 10px; border-radius: 5px;text-align: right;
                    ">
                      <b style="float: right;">${message}</b>
                      <small style="float: left;">(${moment().fromNow()})</small>
                    </div>
                  </div>

                `;
                messageInput.value = '';
                chatContainer.scrollTop = chatContainer.scrollHeight;
                fetchChats();
            })
            .catch(error => {
                console.error('Error sending message:', error);
            });
    }

    form.addEventListener('submit', sendMessage);
    fetchChats();
});
