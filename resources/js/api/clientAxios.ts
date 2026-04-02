import axios from 'axios';

const clienteAxios = axios.create({

    baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8080/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },

    withCredentials: false
});


clienteAxios.interceptors.response.use(
    (response) => response,
    (error) => {

        if (!error.response) {
            console.error("Error de Red: Revisa si el contenedor de Laravel en el puerto 8080 está corriendo.");
        }
        return Promise.reject(error);
    }
);

export default clienteAxios;
