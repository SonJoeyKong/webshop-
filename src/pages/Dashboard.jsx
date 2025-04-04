import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Dashboard = () => {
    const [orders, setOrders] = useState([]);
    const [loading, setLoading] = useState(true);

    const fetchOrders = async () => {
        try {
            const response = await axios.get('/api/getData.php');
            if (response.data.success) {
                setOrders(response.data.orders);
            }
        } catch (error) {
            console.error('Error fetching orders:', error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchOrders();
        const interval = setInterval(fetchOrders, 30000);
        return () => clearInterval(interval);
    }, []);

    return (
        <div className="dashboard">
            <h2>Mijn Bestellingen</h2>
            {loading ? (
                <div className="loading">Laden...</div>
            ) : (
                <div className="orders-grid">
                    {orders.map(order => (
                        <div key={order.id} className="order-card">
                            <h3>Bestelling #{order.id}</h3>
                            <p>Datum: {new Date(order.datum).toLocaleDateString()}</p>
                            <p>Status: {order.status}</p>
                            <p>Totaal: €{order.totaal}</p>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
};

export default Dashboard; 