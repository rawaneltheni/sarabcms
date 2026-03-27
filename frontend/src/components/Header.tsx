import React, { useState } from 'react';
import { Menu, X, Facebook, Twitter, Instagram, Linkedin, MapPin, Moon, Sun } from 'lucide-react';
import { useTranslation } from 'react-i18next';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import logoImg from '../assets/white-no-text.png';
import { useSiteSettings } from '../hooks/useSiteSettings';
import { useTheme } from './ThemeProvider';

export default function Header() {
  const [isOpen, setIsOpen] = useState(false);
  const { t, i18n } = useTranslation();
  const location = useLocation();
  const navigate = useNavigate();
  const { theme, toggleTheme } = useTheme();
  const settings = useSiteSettings();

  const toggleLanguage = () => {
    const newLang = i18n.language === 'en' ? 'ar' : 'en';
    i18n.changeLanguage(newLang);
    document.documentElement.dir = newLang === 'ar' ? 'rtl' : 'ltr';
  };

  const navItems = [
    { hash: 'home', label: settings?.header_home_label || t('header.home') },
    { hash: 'about-us', label: settings?.header_about_label || t('header.about') },
    { hash: 'services', label: settings?.header_services_label || t('header.pricing') },
    { hash: 'portfolio', label: settings?.header_portfolio_label || t('header.portfolio') },
    { hash: 'blog', label: settings?.header_blog_label || t('header.blog') }
  ];

  const handleNavClick = (e: React.MouseEvent<HTMLAnchorElement>, hash: string) => {
    e.preventDefault();
    setIsOpen(false);
    
    if (location.pathname !== '/') {
      navigate(`/#${hash}`);
      setTimeout(() => {
        document.getElementById(hash)?.scrollIntoView({ behavior: 'smooth' });
      }, 100);
    } else {
      document.getElementById(hash)?.scrollIntoView({ behavior: 'smooth' });
    }
  };

  return (
    <>
      <header className="fixed top-0 left-0 right-0 z-50 flex justify-between items-center p-6 md:px-12">
        <div className="z-50">
          <Link to="/">
            <img
              src={logoImg}
              alt="Logo"
              className={`h-10 w-auto object-contain transition-[filter] duration-300 ${theme === 'light' ? 'brightness-0' : ''}`}
              referrerPolicy="no-referrer"
            />
          </Link>
        </div>
        <div className="flex items-center gap-6 z-50">
          <button
            onClick={toggleTheme}
            className="theme-toggle"
            aria-label={theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'}
            title={theme === 'dark' ? 'Light mode' : 'Dark mode'}
          >
            {theme === 'dark' ? <Sun size={18} /> : <Moon size={18} />}
          </button>
          <button 
            onClick={toggleLanguage}
            className="text-sm font-semibold tracking-widest hover:text-cyan-400 transition-colors"
          >
            {i18n.language === 'en' ? 'AR' : 'EN'}
          </button>
          <button onClick={() => setIsOpen(true)} className="hover:text-cyan-400 transition-colors">
            <Menu size={28} />
          </button>
        </div>
      </header>

      <div 
        className={`menu-overlay fixed inset-0 z-50 transition-all duration-500 flex flex-col ${
          isOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'
        }`}
      >
        <div className="flex justify-end p-6 md:px-12">
          <button onClick={() => setIsOpen(false)} className="hover:text-cyan-400 transition-colors mt-1">
            <X size={32} />
          </button>
        </div>
        
        <div className="flex-1 flex flex-col items-center justify-center p-6 text-center overflow-y-auto pb-24">
          <nav className="flex flex-col gap-6 mb-12">
            {navItems.map((item) => (
              <a 
                key={item.hash} 
                href={`#${item.hash}`} 
                className="text-4xl md:text-5xl font-bold hover:text-cyan-400 transition-colors" 
                onClick={(e) => handleNavClick(e, item.hash)}
              >
                {item.label}
              </a>
            ))}
          </nav>

          <div className="space-y-8 max-w-md w-full border-t border-[var(--border-subtle)] pt-12">
            <div>
              <h4 className="muted-text uppercase tracking-widest text-sm mb-4">{settings?.project_prompt || t('header.project_prompt')}</h4>
              <Link 
                to="/contact" 
                onClick={() => setIsOpen(false)} 
                className="text-2xl font-semibold hover:text-cyan-400 transition-colors"
              >
                {settings?.lets_talk_label || t('header.lets_talk')}
              </Link>
            </div>

            <div className="flex justify-center gap-6">
              <a href={settings?.facebook_url || 'https://www.facebook.com/sarabtechllc/'} className="social-link">
                <Facebook size={20} />
              </a>
              <a href={settings?.twitter_url || '#'} className="social-link">
                <Twitter size={20} />
              </a>
              <a href={settings?.instagram_url || '#'} className="social-link">
                <Instagram size={20} />
              </a>
              <a href={settings?.linkedin_url || '#'} className="social-link">
                <Linkedin size={20} />
              </a>
            </div>

            <div className="flex items-center justify-center gap-3 muted-text">
              <MapPin size={20} className="text-cyan-400 shrink-0" />
              <span className="text-sm" dir="ltr">{settings?.address || t('header.address')}</span>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
