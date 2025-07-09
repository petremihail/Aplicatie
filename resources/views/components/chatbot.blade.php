<x-slot name='head'>
    <style>
        
        </style>
</x-slot>

<div class="flex flex-col h-full bg-gray-100 rounded-lg shadow-md overflow-hidden">
    <div class="flex-1 p-4 overflow-y-auto" id="chat-messages">
        <!-- Chat messages will be appended here -->
    </div>
    <div id="loading-indicator" class="loading-dots">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
    <div class="bg-white border-t border-gray-200 p-4 input_container">
        <div class="flex items-center">
            <input type="text" id="chat-input" placeholder="Type your message..."
                class="flex-1 border rounded-l-md py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button onclick="sendChat()"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r-md focus:outline-none focus:shadow-outline">
                Send
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hide loading indicator initially
        document.getElementById('loading-indicator').style.display = 'none';
    });

    function sendChat() {
        const message = document.getElementById('chat-input').value;
        if (!message) return;

        const chatMessages = document.getElementById('chat-messages');
        // Append user message
        appendMessage('user', message);

        // Clear input
        document.getElementById('chat-input').value = '';

        // Show loading indicator
        document.getElementById('loading-indicator').style.display = 'flex';

        fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    message
                })
            })
            .then(res => res.json())
            .then(data => {
                // Hide loading indicator
                document.getElementById('loading-indicator').style.display = 'none';

                if (data.response) {
                    appendMessage('bot', data.response);
                } else if (data.error) {
                    appendMessage('bot', 'Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                // Hide loading indicator
                document.getElementById('loading-indicator').style.display = 'none';
                appendMessage('bot', 'Error: Could not connect to the server.');
            });
    }

    function appendMessage(sender, message) {
        const chatMessages = document.getElementById('chat-messages');
        const messageElement = document.createElement('div');
        messageElement.classList.add('mb-2', sender === 'user' ? 'user' : 'bot'); // Apply different class for user and bot

        const messageContent = document.createElement('div');
        messageContent.classList.add('inline-block', 'rounded-full', 'py-2', 'px-3', 'max-w-xs', 
        sender === 'user' ? 'input_message' : 'response_message'); // Different background for user and bot messages
        messageContent.innerText = message;

        messageElement.appendChild(messageContent);
        chatMessages.appendChild(messageElement);

        // Scroll to bottom of chat
        chatMessages.scrollTop = chatMessages.scrollHeight;
}
</script>
