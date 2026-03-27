import React from 'react';
import { useTranslation } from 'react-i18next';
import { Link } from 'react-router-dom';
import logoImg from '../assets/white-no-text.png';
import { useSiteSettings } from '../hooks/useSiteSettings';
import { useTheme } from './ThemeProvider';

export default function Footer() {
  const { t } = useTranslation();
  const { theme } = useTheme();
  const settings = useSiteSettings();
  const links = [
    { label: 'Facebook', url: settings?.facebook_url },
    { label: 'X / Twitter', url: settings?.twitter_url },
    { label: 'Instagram', url: settings?.instagram_url },
    { label: 'LinkedIn', url: settings?.linkedin_url },
  ].filter((link) => link.url && link.url !== '#');

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
            {settings?.footer_description || t('about.desc')}
          </p>
        </div>
        <div>
          <h4 className="text-lg font-semibold mb-6 uppercase tracking-wider">{settings?.footer_links_heading || t('footer.important_links')}</h4>
          <ul className="space-y-4 muted-text">
            {links.map((link) => (
              <li key={link.label}>
                <a
                  href={link.url ?? '#'}
                  target="_blank"
                  rel="noreferrer"
                  className="hover:text-cyan-400 transition-colors"
                >
                  {link.label}
                </a>
              </li>
            ))}
          </ul>
        </div>
      </div>
      <div className="max-w-6xl mx-auto px-6 mt-16 pt-8 border-t border-[var(--border-subtle)] text-center faint-text text-sm">
        &copy; {new Date().getFullYear()} {settings?.site_name || t('header.title')}. All rights reserved.
      </div>
    </footer>
  );
}
