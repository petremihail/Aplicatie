<x-layout>
    <x-header />
    <x-hero>
        <div class="container">
            <div class="chatbot-container">
                <div class="chatbot-header bg-orange p-3 text-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0">AI Assistant</h5>
                    <button class="btn-close btn-close-white" onclick="toggleChatbot()"></button>
                </div>

                <div id="chat-messages" class="p-3">
                    <div class="bot">
                        <div class="message">
                            Hello! I'm your AI assistant. How can I help you with your courses today?
                        </div>
                    </div>
                </div>

                <div class="input_container p-3 mt-auto">
                    <div class="d-flex">
                        <input type="text" id="chat-input" class="form-control" placeholder="Type your message...">
                        <button id="send-btn" class="btn bg-orange text-white ms-2" onclick="sendMessage()">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                </div>
            </div>

            <script>
                // Initialize the chat
                document.addEventListener('DOMContentLoaded', function() {
                    // Enable pressing Enter to send message
                    document.getElementById('chat-input').addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            sendMessage();
                        }
                    });
                });

                // Send message function
                function sendMessage() {
                    const input = document.getElementById('chat-input');
                    const message = input.value.trim();

                    if (message === '') return;

                    // Clear input
                    input.value = '';

                    // Add user message to chat
                    const chatMessages = document.getElementById('chat-messages');
                    chatMessages.innerHTML += `
            <div class="user text-end mb-2">
                <div class="message">
                    ${escapeHtml(message)}
                </div>
            </div>
        `;

                    // Add loading indicator
                    const loadingId = 'loading-' + Date.now();
                    chatMessages.innerHTML += `
            <div id="${loadingId}" class="bot mb-2">
                <div class="loading-dots">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>
        `;

                    // Scroll to bottom
                    chatMessages.scrollTop = chatMessages.scrollHeight;

                    // Send to server
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
                        .then(response => response.json())
                        .then(data => {
                            // Remove loading indicator
                            document.getElementById(loadingId).remove();

                            // Add bot response - look for data.response for compatibility
                            let responseText = 'Sorry, I encountered an error.';
                            if (data.response) {
                                responseText = data.response;
                            } else if (data.choices && data.choices[0] && data.choices[0].message) {
                                responseText = data.choices[0].message.content;
                            }

                            chatMessages.innerHTML += `
                <div class="bot mb-2">
                    <div class="message">
                        ${escapeHtml(responseText)}
                    </div>
                </div>
            `;

                            // Scroll to bottom again
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        })
                        .catch(error => {
                            // Remove loading indicator
                            document.getElementById(loadingId).remove();

                            // Add error message
                            chatMessages.innerHTML += `
                <div class="bot mb-2">
                    <div class="message text-danger">
                        Sorry, I encountered an error. Please try again later.
                    </div>
                </div>
            `;

                            console.error('Error:', error);

                            // Scroll to bottom again
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        });
                }

                // Helper function to escape HTML
                function escapeHtml(unsafe) {
                    return unsafe
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;");
                }
            </script>

        </div>
    </x-hero>
</x-layout>
