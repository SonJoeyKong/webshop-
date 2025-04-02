import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Chatbot = () => {
    const [messages, setMessages] = useState([]);
    const [input, setInput] = useState('');
    const [isOpen, setIsOpen] = useState(false);

    const sendMessage = async (message) => {
        try {
            // Voeg gebruikersbericht toe
            setMessages(prev => [...prev, { text: message, type: 'user' }]);

            // API call naar je chatbot backend
            const response = await axios.post('/api/chatbot', {
                message: message
            });

            // Voeg bot antwoord toe
            setMessages(prev => [...prev, { text: response.data.reply, type: 'bot' }]);
        } catch (error) {
            console.error('Chatbot error:', error);
        }
    };

    return (
        <div className={`chatbot ${isOpen ? 'open' : ''}`}>
            <div className="chatbot-header" onClick={() => setIsOpen(!isOpen)}>
                <h3>ApotheCare Assistant</h3>
            </div>
            {isOpen && (
                <>
                    <div className="chatbot-messages">
                        {messages.map((msg, index) => (
                            <div key={index} className={`message ${msg.type}`}>
                                {msg.text}
                            </div>
                        ))}
                    </div>
                    <div className="chatbot-input">
                        <input
                            type="text"
                            value={input}
                            onChange={(e) => setInput(e.target.value)}
                            onKeyPress={(e) => {
                                if (e.key === 'Enter') {
                                    sendMessage(input);
                                    setInput('');
                                }
                            }}
                            placeholder="Typ uw vraag..."
                        />
                    </div>
                </>
            )}
        </div>
    );
};

export default Chatbot; 