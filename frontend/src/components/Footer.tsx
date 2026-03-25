import React from 'react';
import { useTranslation } from 'react-i18next';
import { Link } from 'react-router-dom';
import logoImg from '../assets/white-no-text.png';
import { useTheme } from './ThemeProvider';

export default function Footer() {
  const { t } = useTranslation();
  const { theme } = useTheme();

  return (
    <footer className="footer-surface relative z-20 border-t py-16">
      <div className="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
          <div className="mb-6">
            <Link to="/">
              <img
                src={logoImg}
                alt="Logo"
                className={`h-10 w-auto object-contain transition-[filter] duration-300 ${theme === 'light' ? 'brightness-0' : ''}`}
                referrerPolicy="no-referrer"
              />
            </Link>
          </div>
          <p className="muted-text max-w-sm">
            {t('about.desc')}
          </p>
        </div>
        <div>
          <h4 className="text-lg font-semibold mb-6 uppercase tracking-wider">{t('footer.important_links')}</h4>
          <ul className="space-y-4 muted-text">
            <li><Link to="/terms" className="hover:text-cyan-400 transition-colors">{t('footer.terms')}</Link></li>
            <li><Link to="/privacy" className="hover:text-cyan-400 transition-colors">{t('footer.privacy')}</Link></li>
            <li><Link to="/refund" className="hover:text-cyan-400 transition-colors">{t('footer.refund')}</Link></li>
            <li><Link to="/cancellation" className="hover:text-cyan-400 transition-colors">{t('footer.cancelation')}</Link></li>
            <li><Link to="/promotions" className="hover:text-cyan-400 transition-colors">{t('footer.promotions')}</Link></li>
            <li><Link to="/security" className="hover:text-cyan-400 transition-colors">{t('footer.security')}</Link></li>
          </ul>
        </div>
      </div>
      <div className="max-w-6xl mx-auto px-6 mt-16 pt-8 border-t border-[var(--border-subtle)] text-center faint-text text-sm">
        &copy; {new Date().getFullYear()} {t('header.title')}. All rights reserved.
      </div>
    </footer>
  );
}
