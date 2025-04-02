// Simple Chatbot for Webshop
document.addEventListener("DOMContentLoaded", () => {
    const chatContainer = document.createElement("div");
    chatContainer.id = "chatbot";
    chatContainer.style.position = "fixed";
    chatContainer.style.bottom = "20px";
    chatContainer.style.right = "20px";
    chatContainer.style.width = "300px";
    chatContainer.style.height = "400px";
    chatContainer.style.border = "1px solid #ccc";
    chatContainer.style.borderRadius = "10px";
    chatContainer.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.2)";
    chatContainer.style.backgroundColor = "#fff";
    chatContainer.style.overflow = "hidden";
    chatContainer.style.display = "flex";
    chatContainer.style.flexDirection = "column";
    document.body.appendChild(chatContainer); // maakt een div met styles aan

    const chatHeader = document.createElement("div");
    chatHeader.style.backgroundColor = "#007bff";
    chatHeader.style.color = "#fff";
    chatHeader.style.padding = "10px";
    chatHeader.style.textAlign = "center";
    chatHeader.style.fontWeight = "bold";
    chatHeader.textContent = "Webshop Chatbot";
    chatContainer.appendChild(chatHeader); // maakt een header aan

    const chatMessages = document.createElement("div");
    chatMessages.style.flex = "1";
    chatMessages.style.padding = "10px";
    chatMessages.style.overflowY = "auto";
    chatMessages.style.fontSize = "14px";
    chatContainer.appendChild(chatMessages); // maakt een div aan voor de berichten

    const chatInputContainer = document.createElement("div");
    chatInputContainer.style.display = "flex";
    chatInputContainer.style.borderTop = "1px solid #ccc";
    chatContainer.appendChild(chatInputContainer); // maakt een div aan voor de input

    const chatInput = document.createElement("input");
    chatInput.type = "text";
    chatInput.placeholder = "Type your message...";
    chatInput.style.flex = "1";
    chatInput.style.padding = "10px";
    chatInput.style.border = "none";
    chatInput.style.outline = "none";
    chatInputContainer.appendChild(chatInput); // maakt een input aan voor de tekst

    const chatSendButton = document.createElement("button");
    chatSendButton.textContent = "Send";
    chatSendButton.style.padding = "10px";
    chatSendButton.style.border = "none";
    chatSendButton.style.backgroundColor = "#007bff";
    chatSendButton.style.color = "#fff";
    chatSendButton.style.cursor = "pointer";
    chatInputContainer.appendChild(chatSendButton); // maakt een button aan voor het versturen van de tekst

    const responses = { // object met antwoorden
        "hello": "Hi! How can I assist you with our webshop today?",
        "hallo": "Hi! How can I assist you with our webshop today?",
        "goedemorgen": "Hi! How can I assist you with our webshop today?",
        "goedemiddag": "Hi! How can I assist you with our webshop today?",
        "goedeavond": "Hi! How can I assist you with our webshop today?",
        "help": "Sure! What do you need help with? Products, orders, or something else?",
        "products": "We have a variety of products! Check out our catalog on the webshop.",
        "bye": "Goodbye! Have a great day!",
        "totziens": "Goodbye! Have a great day!",
        "dankje": "You're welcome! If you have any more questions, feel free to ask.",
        "bedankt": "You're welcome! If you have any more questions, feel free to ask.",
        
    };

    const addMessage = (message, isBot = false) => { // functie om een bericht toe te voegen
        const messageElement = document.createElement("div");
        messageElement.style.margin = "5px 0";
        messageElement.style.padding = "10px";
        messageElement.style.borderRadius = "10px";
        messageElement.style.backgroundColor = isBot ? "#f1f1f1" : "#007bff";
        messageElement.style.color = isBot ? "#000" : "#fff";
        messageElement.style.alignSelf = isBot ? "flex-start" : "flex-end";
        messageElement.textContent = message;
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    };

    chatSendButton.addEventListener("click", () => { // functie om een bericht te versturen
        const userMessage = chatInput.value.trim();
        if (userMessage) {
            addMessage(userMessage);
            chatInput.value = "";

            const botResponse = responses[userMessage.toLowerCase()] || "Sorry, I didn't understand that. Can you rephrase?";
            setTimeout(() => addMessage(botResponse, true), 500);
        }
    });

    chatInput.addEventListener("keypress", (e) => { // functie om een bericht te versturen met enter
        if (e.key === "Enter") {
            chatSendButton.click();
        }
    });
});
