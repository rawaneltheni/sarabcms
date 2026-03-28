import axios from 'axios';

function resolveApiBaseUrl() {
  if (import.meta.env.VITE_API_URL) {
    return import.meta.env.VITE_API_URL;
  }

  if (typeof window !== 'undefined') {
    return window.location.port === '3000'
      ? 'http://localhost:8080/api'
      : '/api';
  }

  return '/api';
}

const api = axios.create({
  baseURL: resolveApiBaseUrl(),
  headers: {
    'Accept': 'application/json',
  },
});

export default api;
