<!-- Floating Chat Widget -->
<style>
    .chat-widget {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
    }

    .chat-button {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #6F4E37, #8B5A2B);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        color: white;
        position: relative;
    }

    .chat-button:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }

    .chat-button i {
        width: 28px;
        height: 28px;
    }

    .chat-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff4444;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .chat-panel {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 350px;
        height: 500px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        display: none;
        flex-direction: column;
        overflow: hidden;
        z-index: 9998;
        animation: slideIn 0.3s ease;
    }

    .chat-panel.open {
        display: flex;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chat-header {
        background: linear-gradient(135deg, #6F4E37, #8B5A2B);
        color: white;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header h3 {
        margin: 0;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chat-header .close-chat {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 20px;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.3s;
    }

    .chat-header .close-chat:hover {
        background: rgba(255,255,255,0.2);
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 15px;
        background: #f5f5f5;
    }

    .message {
        margin-bottom: 15px;
        display: flex;
    }

    .message.user {
        justify-content: flex-end;
    }

    .message.bot {
        justify-content: flex-start;
    }

    .message-content {
        max-width: 80%;
        padding: 10px 14px;
        border-radius: 18px;
        font-size: 14px;
        line-height: 1.4;
    }

    .message.user .message-content {
        background: #6F4E37;
        color: white;
        border-bottom-right-radius: 5px;
    }

    .message.bot .message-content {
        background: white;
        color: #333;
        border: 1px solid #e0e0e0;
        border-bottom-left-radius: 5px;
    }

    .chat-input {
        padding: 15px;
        background: white;
        border-top: 1px solid #eee;
        display: flex;
        gap: 10px;
    }

    .chat-input input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 25px;
        font-size: 14px;
        outline: none;
    }

    .chat-input input:focus {
        border-color: #6F4E37;
    }

    .chat-input button {
        padding: 10px 20px;
        background: linear-gradient(135deg, #6F4E37, #8B5A2B);
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 14px;
        transition: transform 0.2s;
    }

    .chat-input button:hover {
        transform: scale(1.02);
    }

    .typing-indicator {
        text-align: center;
        padding: 10px;
        color: #999;
        font-style: italic;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .chat-panel {
            width: calc(100vw - 40px);
            right: 20px;
            bottom: 80px;
        }
    }
</style>

<div class="chat-widget">
    <div class="chat-button" id="chatButton">
        <i data-feather="message-circle"></i>
        <span class="chat-badge" id="chatBadge" style="display: none;">1</span>
    </div>
</div>

<div class="chat-panel" id="chatPanel">
    <div class="chat-header">
        <h3>
            <i data-feather="bot" style="width: 18px; height: 18px;"></i>
            DeepSeek AI Assistant
        </h3>
        <button class="close-chat" id="closeChat">
            <i data-feather="x" style="width: 18px; height: 18px;"></i>
        </button>
    </div>
    <div class="chat-messages" id="chatMessages">
        <div class="message bot">
            <div class="message-content">
                Halo! 👋 Saya asisten AI Beranda Coffee. Ada yang bisa saya bantu? Tanyakan tentang menu kopi, rekomendasi, atau informasi lainnya!
            </div>
        </div>
    </div>
    <div class="chat-input">
        <input type="text" id="chatInput" placeholder="Ketik pesan Anda..." />
        <button id="sendChat">Kirim</button>
    </div>
</div>

<script>
    // Tunggu Feather Icons selesai load
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    const chatButton = document.getElementById('chatButton');
    const chatPanel = document.getElementById('chatPanel');
    const closeChat = document.getElementById('closeChat');
    const chatInput = document.getElementById('chatInput');
    const sendButton = document.getElementById('sendChat');
    const chatMessages = document.getElementById('chatMessages');

    // Toggle chat panel
    chatButton.addEventListener('click', () => {
        chatPanel.classList.toggle('open');
        if (chatPanel.classList.contains('open')) {
            const badge = document.getElementById('chatBadge');
            badge.style.display = 'none';
            chatInput.focus();
        }
    });

    closeChat.addEventListener('click', () => {
        chatPanel.classList.remove('open');
    });

    // Kirim pesan
    async function sendMessage() {
        const message = chatInput.value.trim();
        if (!message) return;

        addMessage(message, 'user');
        chatInput.value = '';

        const loadingId = showTypingIndicator();

        try {
            const response = await fetch('/deepseek/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            removeTypingIndicator(loadingId);

            if (data.success) {
                addMessage(data.reply, 'bot');
            } else {
                addMessage('Maaf, terjadi kesalahan: ' + data.error, 'bot');
            }
        } catch (error) {
            removeTypingIndicator(loadingId);
            addMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi.', 'bot');
        }

        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}`;
        messageDiv.innerHTML = `<div class="message-content">${escapeHtml(text)}</div>`;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function showTypingIndicator() {
        const id = 'typing-' + Date.now();
        const typingDiv = document.createElement('div');
        typingDiv.id = id;
        typingDiv.className = 'message bot';
        typingDiv.innerHTML = '<div class="typing-indicator">🤔 DeepSeek sedang berpikir...</div>';
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return id;
    }

    function removeTypingIndicator(id) {
        const element = document.getElementById(id);
        if (element) element.remove();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    sendButton.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
</script>