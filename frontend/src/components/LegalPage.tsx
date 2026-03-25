import React from 'react';
import { useTranslation } from 'react-i18next';
import { Link } from 'react-router-dom';
import { ArrowLeft } from 'lucide-react';
import Header from './Header';
import Footer from './Footer';

interface LegalPageProps {
  title: string;
  children: React.ReactNode;
}

export default function LegalPage({ title, children }: LegalPageProps) {
  const { i18n } = useTranslation();

  return (
    <div className="page-shell min-h-screen font-sans selection:bg-cyan-500/30" dir={i18n.language === 'ar' ? 'rtl' : 'ltr'}>
      <Header />
      
      <div className="pt-32 pb-24 px-6 max-w-4xl mx-auto relative z-20">
        <Link 
          to="/" 
          className="muted-text inline-flex items-center gap-2 hover:text-cyan-400 transition-colors mb-8 font-medium"
        >
          <ArrowLeft size={20} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
          {i18n.language === 'ar' ? 'العودة للرئيسية' : 'Back to Home'}
        </Link>

        <h1 className="text-4xl md:text-5xl font-bold mb-8 text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">
          {title}
        </h1>
        
        <div className="legal-content prose max-w-none space-y-6 leading-relaxed">
          {children}
        </div>
      </div>

      <Footer />
    </div>
  );
}
