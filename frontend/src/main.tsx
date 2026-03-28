import {StrictMode} from 'react';
import {createRoot} from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import App from './App.tsx';
import './index.css';
import './i18n';
import { ThemeProvider } from './components/ThemeProvider.tsx';

const routerBaseName =
  typeof window !== 'undefined' && window.location.pathname.startsWith(import.meta.env.BASE_URL)
    ? import.meta.env.BASE_URL
    : '/';

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <ThemeProvider>
      <BrowserRouter basename={routerBaseName}>
        <App />
      </BrowserRouter>
    </ThemeProvider>
  </StrictMode>,
);
