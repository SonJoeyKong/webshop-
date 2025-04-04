import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Home = () => {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const fetchData = async () => {
        try {
            const response = await axios.get('/api/getData.php');
            if (response.data.success) {
                setProducts(response.data.products);
            } else {
                setError('Er ging iets mis bij het ophalen van de data');
            }
        } catch (err) {
            setError('Er kon geen verbinding worden gemaakt met de server');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchData();
        // Auto-refresh elke 30 seconden
        const interval = setInterval(fetchData, 30000);
        return () => clearInterval(interval);
    }, []);

    if (loading) return <div className="loading">Laden...</div>;
    if (error) return <div className="error">{error}</div>;

    return (
        <div className="main-content">
            <section className="products-grid">
                {products.map(product => (
                    <div key={product.id} className="product-card">
                        <img src={product.image_url} alt={product.naam} />
                        <h3>{product.naam}</h3>
                        <p>{product.beschrijving}</p>
                        <p className="price">€{product.prijs}</p>
                        <button className="btn btn-primary">Toevoegen aan winkelwagen</button>
                    </div>
                ))}
            </section>
        </div>
    );
};

export default Home; 