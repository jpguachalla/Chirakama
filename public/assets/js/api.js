/**
 * Chirakama API Wrapper
 * Handles all Fetch API requests to Laravel backend (Sanctum)
 */

const API_BASE_URL = '/api'; // Cambiar por tu URL base si es necesario, ej: 'http://localhost:8000/api'

const ApiService = {
    /**
     * Helper to get CSRF Cookie for Sanctum
     */
    async getCsrfCookie() {
        return fetch('/sanctum/csrf-cookie', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });
    },

    /**
     * Default headers for all requests
     */
    getHeaders() {
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        };
        
        // Add Bearer token if using tokens instead of session cookies
        const token = localStorage.getItem('chirakama_token');
        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }
        
        return headers;
    },

    /**
     * Base fetch method
     */
    async request(endpoint, options = {}) {
        const url = `${API_BASE_URL}${endpoint}`;
        
        const config = {
            ...options,
            headers: {
                ...this.getHeaders(),
                ...options.headers,
            }
        };

        try {
            const response = await fetch(url, config);
            
            // Handle 401 Unauthorized (Session expired or invalid token)
            if (response.status === 401) {
                localStorage.removeItem('chirakama_token');
                window.location.href = '/login';
                return null;
            }

            const data = await response.json();
            
            if (!response.ok) {
                throw data;
            }
            
            return data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    // HTTP Methods
    get(endpoint) {
        return this.request(endpoint, { method: 'GET' });
    },

    post(endpoint, data) {
        return this.request(endpoint, {
            method: 'POST',
            body: JSON.stringify(data)
        });
    },

    put(endpoint, data) {
        return this.request(endpoint, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    },

    delete(endpoint) {
        return this.request(endpoint, { method: 'DELETE' });
    },

    // Specific Endpoints (Examples)
    
    async login(email, password) {
        // Para Sanctum SPA Auth
        // await this.getCsrfCookie(); 
        
        return this.post('/login', { email, password });
    },

    async logout() {
        return this.post('/logout', {});
    },

    getVehicles() {
        return this.get('/vehicles');
    },

    getStats() {
        return this.get('/dashboard/stats');
    }
};

window.ApiService = ApiService;
