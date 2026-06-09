<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat dengan Gemini AI - Beranda Coffee</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .chat-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .chat-header {
            background: linear-gradient(135deg, #6F4E37, #8B5A2B);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .chat-messages {
            height: 400px;
            overflow-y: auto;
            padding: 20px;
            background: #f9f9f9;
        }
        .message {
            margin-bottom: 15px;
            display: flex;
        }
        .user-message {
            justify-content: flex-end;
        }
        .bot-message {
            justify-content: flex-start;
        }
        .message-content {
            max-width: 70%;
            padding: 12px 18px;
            border-radius: 20px;
        }
        .user-message .message-content {
            background: #6F4E37;
            color: white;
            border-bottom-right-radius: 5px;
        }
        .bot-message .message-content {
            background: white;
            color: #333;
            border: 1px solid #ddd;
            border-bottom-left-radius: 5px;
        }
        .chat-input {
            padding: 20px;
            background: white;
            border-top: 1px solid #eee;
            display: flex;
            gap: 10px;
        }
        .chat-input input {
            flex: 1;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 16px;
        }
        .chat-input button {
            padding: 12px 30px;
            background: linear-gradient(135deg, #6F4E37, #8B5A2B);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
        }
        .chat-input button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(111,78,55,0.3);
        }
        .loading {
            text-align: center;
            padding: 10px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>🤖 Gemini AI Assistant</h2>
            <p>Tanyakan apapun tentang kopi atau rekomendasi menu!</p>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="message bot-message">
                <div class="message-content">
                    Halo! 👋 Saya asisten AI Beranda Coffee. Ada yang bisa saya bantu? Tanyakan tentang menu kopi, rekomendasi, atau sekedar ngobrol santai!
                </div>
            </div>
        </div>
        
        <div class="chat-input">
            <input type="text" id="messageInput" placeholder="Ketik pesan Anda di sini..." onkeypress="if(event.key === 'Enter') sendMessage()">
            <button onclick="sendMessage()">Kirim</button>
        </div>
    </div>

    <script>
        const chatMessages = document.getElementById('chatMessages');
        const messageInput = document.getElementById('messageInput');

        async function sendMessage() {
            const message = messageInput.value.trim();
            if (!message) return;

            addMessage(message, 'user');
            messageInput.value = '';

            const loadingDiv = addLoadingIndicator();

            try {
                const response = await fetch("{{ route('gemini.chat') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                loadingDiv.remove();

                if (data.success) {
                    addMessage(data.reply, 'bot');
                } else {
                    addMessage('Maaf: ' + data.error, 'bot');
                }
            } catch (error) {
                loadingDiv.remove();
                console.error("Detail Error Lengkap:", error);
                alert("Terjadi error! Periksa Console (F12) untuk detailnya.");
                
                addMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi.', 'bot');
            }

            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}-message`;
            messageDiv.innerHTML = `<div class="message-content">${escapeHtml(text)}</div>`;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function addLoadingIndicator() {
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'loading';
            loadingDiv.innerHTML = '<em>🤔 Gemini sedang berpikir...</em>';
            chatMessages.appendChild(loadingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            return loadingDiv;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>