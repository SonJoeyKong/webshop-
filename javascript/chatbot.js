// Simple Chatbot for Webshop
document.addEventListener("DOMContentLoaded", () => {
    // Chatbot UI elementen maken
    const chatContainer = document.createElement("div");
    chatContainer.id = "chatbot";
    chatContainer.innerHTML = `
        <div class="chat-header">
            <div class="chat-title">
                <img src="/images/logo.png" alt="ApotheCare Logo" class="chat-logo">
                <span>ApotheCare Assistant</span>
            </div>
            <button class="chat-minimize">−</button>
        </div>
        <div class="chat-messages"></div>
        <div class="chat-input-container">
            <input type="text" class="chat-input" placeholder="Type uw vraag...">
            <button class="chat-send">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    `;
    document.body.appendChild(chatContainer);

    // Elements selecteren
    const chatMessages = chatContainer.querySelector(".chat-messages");
    const chatInput = chatContainer.querySelector(".chat-input");
    const chatSendButton = chatContainer.querySelector(".chat-send");
    const chatMinimizeButton = chatContainer.querySelector(".chat-minimize");
    let isMinimized = false;

    // Functie voor het toevoegen van berichten
    const addMessage = (message, isBot = false) => {
        const messageElement = document.createElement("div");
        messageElement.className = `chat-message ${isBot ? 'bot' : 'user'}`;
        
        if (isBot && message.type === 'product') {
            messageElement.innerHTML = `
                <div class="product-info">
                    ${message.message.split('\n').join('<br>')}
                </div>
            `;
        } else {
            messageElement.textContent = message.message || message;
        }
        
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    };

    // Welkomstbericht
    setTimeout(() => {
        addMessage({
            message: "Welkom bij ApotheCare! Hoe kan ik u helpen?",
            type: 'greeting'
        }, true);
    }, 500);

    // Event listeners
    chatSendButton.addEventListener("click", async () => {
        const message = chatInput.value.trim();
        if (message) {
            addMessage(message);
            chatInput.value = "";

            try {
                const response = await fetch('/php/api/chatbot.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ message })
                });
                const data = await response.json();
                setTimeout(() => addMessage(data, true), 500);
            } catch (error) {
                console.error('Error:', error);
                setTimeout(() => addMessage({
                    message: "Sorry, er is iets misgegaan. Probeer het later opnieuw.",
                    type: 'error'
                }, true), 500);
            }
        }
    });

    chatInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            chatSendButton.click();
        }
    });

    chatMinimizeButton.addEventListener("click", () => {
        const chatContent = chatContainer.querySelector(".chat-messages");
        const chatInputContainer = chatContainer.querySelector(".chat-input-container");
        
        isMinimized = !isMinimized;
        chatContent.style.display = isMinimized ? "none" : "block";
        chatInputContainer.style.display = isMinimized ? "none" : "flex";
        chatMinimizeButton.textContent = isMinimized ? "+" : "−";
        
        if (!isMinimized) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });
});
