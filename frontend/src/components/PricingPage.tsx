import React, {useEffect, useState} from 'react';
import {Link} from 'react-router-dom';
import {ArrowLeft, ArrowRight, Globe, Smartphone} from 'lucide-react';
import {useTranslation} from 'react-i18next';
import api from '../api';
import {useSiteSettings} from '../hooks/useSiteSettings';
import {usePageBlocks} from '../hooks/usePageBlocks';
import Header from './Header';
import Footer from './Footer';

interface Service {
  id: number;
  title: string | null;
  description: string | null;
  image_url: string | null;
  icon: string | null;
  url: string | null;
}

type FallbackService = {
  key: string;
  title: string;
  description: string;
  url: string | null;
  iconComponent: React.ComponentType<{className?: string}>;
};

function resolveIcon(icon: unknown) {
  const value = typeof icon === 'string' ? icon.toLowerCase() : '';

  if (value.includes('app') || value.includes('mobile') || value.includes('phone')) {
    return Smartphone;
  }

  return Globe;
}

export default function PricingPage() {
  const {t, i18n} = useTranslation();
  const settings = useSiteSettings();
  const pageBlocks = usePageBlocks('home');
  const [services, setServices] = useState<Service[]>([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    setLoading(true);

    api.get('/services')
      .then((response) => {
        setServices(response.data?.data ?? []);
      })
      .catch(() => {
        setServices([]);
      })
      .finally(() => setLoading(false));
  }, []);

  const servicesBlock = pageBlocks.find((block) => block.key === 'services');
  const contactCtaBlock = pageBlocks.find((block) => block.key === 'contact_cta');
  const fallbackServices: FallbackService[] = [
    {
      key: 'web',
      title: t('services.web_dev'),
      description: t('services.web_dev_desc'),
      url: '/contact',
      iconComponent: Globe,
    },
    {
      key: 'app',
      title: t('services.app_dev'),
      description: t('services.app_dev_desc'),
      url: '/contact',
      iconComponent: Smartphone,
    },
    {
      key: 'consulting',
      title: t('services.consulting'),
      description: t('services.consulting_desc'),
      url: '/contact',
      iconComponent: ArrowRight,
    },
  ];
  const pricingCards = services.length ? services : fallbackServices;
  const contactCtaUrl = contactCtaBlock?.cta_url || '/contact';

  return (
    <div className="page-shell min-h-screen font-sans selection:bg-cyan-500/30" dir={i18n.language === 'ar' ? 'rtl' : 'ltr'}>
      <Header />

      <div className="relative z-20 mx-auto max-w-6xl px-6 pb-24 pt-32">
        <Link
          to="/"
          className="muted-text mb-8 inline-flex items-center gap-2 font-medium transition-colors hover:text-cyan-400"
        >
          <ArrowLeft size={20} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
          {settings?.contact_back_label || (i18n.language === 'ar' ? 'العودة للرئيسية' : 'Back to Home')}
        </Link>

        <div className="mb-16 space-y-5 text-center">
          <h3 className="text-sm font-semibold uppercase tracking-wider text-cyan-400">
            {servicesBlock?.eyebrow || settings?.services_section_label || t('services.subtitle')}
          </h3>
          <h1 className="text-4xl font-bold md:text-6xl">
            {servicesBlock?.title || settings?.services_section_title || t('services.title')}
          </h1>
          <p className="muted-text mx-auto max-w-3xl text-lg leading-relaxed">
            {servicesBlock?.description || t('about.desc')}
          </p>
        </div>

        <div className="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3">
          {loading && <div className="col-span-full py-8 text-center">Loading pricing...</div>}
          {!loading && pricingCards.map((service) => {
            const key = 'id' in service ? service.id : service.key;
            const IconComponent = 'iconComponent' in service ? service.iconComponent : resolveIcon(service.icon);

            return (
              <div
                key={key}
                className="card-surface flex h-full flex-col rounded-3xl border p-8 backdrop-blur-md transition-colors hover:border-cyan-500/30"
              >
                {'image_url' in service && service.image_url ? (
                  <img
                    src={service.image_url}
                    alt={service.title || 'Service'}
                    className="mb-6 h-14 w-14 object-contain"
                    referrerPolicy="no-referrer"
                  />
                ) : (
                  <IconComponent className="mb-6 h-14 w-14 text-cyan-400" />
                )}

                <h2 className="mb-4 text-2xl font-bold">{service.title}</h2>
                <p className="muted-text mb-8 flex-1 leading-relaxed">{service.description}</p>

                {service.url && (
                  service.url.startsWith('/') ? (
                    <Link
                      to={service.url}
                      className="project-meta inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-wider transition-colors hover:text-cyan-400"
                    >
                      <span>{settings?.portfolio_view_details_label || t('portfolio.view_details')}</span>
                      <ArrowRight size={16} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
                    </Link>
                  ) : (
                    <a
                      href={service.url}
                      target="_blank"
                      rel="noreferrer"
                      className="project-meta inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-wider transition-colors hover:text-cyan-400"
                    >
                      <span>{settings?.portfolio_view_details_label || t('portfolio.view_details')}</span>
                      <ArrowRight size={16} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
                    </a>
                  )
                )}
              </div>
            );
          })}
        </div>

        <section className="mt-24">
          <div className="glass-panel space-y-8 rounded-3xl border p-10 text-center backdrop-blur-md md:p-12">
            <h2 className="text-4xl font-bold md:text-6xl">
              {contactCtaBlock?.title || settings?.contact_cta_title || t('contact.title')}
            </h2>
            <p className="muted-text mx-auto max-w-2xl text-lg">
              {contactCtaBlock?.description || settings?.contact_cta_description || t('contact.desc')}
            </p>
            {contactCtaUrl.startsWith('/') ? (
              <Link to={contactCtaUrl} className="cta-button inline-block rounded-full px-8 py-4 text-lg font-semibold transition-transform hover:scale-105">
                {contactCtaBlock?.cta_label || settings?.contact_cta_button_label || t('contact.button')}
              </Link>
            ) : (
              <a
                href={contactCtaUrl}
                target="_blank"
                rel="noreferrer"
                className="cta-button inline-block rounded-full px-8 py-4 text-lg font-semibold transition-transform hover:scale-105"
              >
                {contactCtaBlock?.cta_label || settings?.contact_cta_button_label || t('contact.button')}
              </a>
            )}
          </div>
        </section>
      </div>

      <Footer />
    </div>
  );
}
