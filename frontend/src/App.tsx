/**
 * @license
 * SPDX-License-Identifier: Apache-2.0
 */

import React, {useEffect, useRef, useState} from 'react';
import {Link, Route, Routes} from 'react-router-dom';
import {ArrowDown, ArrowRight, CalendarDays, CheckCircle2, Globe, HandCoins, MessageSquareText, Presentation, Smartphone} from 'lucide-react';
import {motion, useScroll, useTransform} from 'motion/react';
import {useTranslation} from 'react-i18next';
import api from './api';
import Header from './components/Header';
import Footer from './components/Footer';
import ParticleLogo from './components/ParticleLogo';
import ProjectModal, {Project} from './components/ProjectModal';
import AnimatedCounter from './components/AnimatedCounter';
import TermsAndConditions from './components/TermsAndConditions';
import PrivacyPolicy from './components/PrivacyPolicy';
import RefundPolicy from './components/RefundPolicy';
import CancellationPolicy from './components/CancellationPolicy';
import PromotionsTerms from './components/PromotionsTerms';
import SecurityPolicy from './components/SecurityPolicy';
import ContactPage from './components/ContactPage';
import BlogIndexPage from './components/BlogIndexPage';
import BlogPostPage from './components/BlogPostPage';
import PricingPage from './components/PricingPage';
import {useSiteSettings} from './hooks/useSiteSettings';
import {usePageBlocks} from './hooks/usePageBlocks';

interface AboutContent {
  id: number;
  heading1: string | null;
  heading2: string | null;
  description: string | null;
  features: string[];
  image1_url: string | null;
  image2_url: string | null;
  image3_url: string | null;
}

interface HomeContent {
  id: number;
  h1: string | null;
  h2: string | null;
  body: string | null;
  btn_text: string | null;
  btn_link: string | null;
  image_url: string | null;
}

interface Customer {
  id: number;
  name: string;
  logo_url: string | null;
  website_url?: string | null;
}

interface Service {
  id: number;
  title: string | null;
  description: string | null;
  image_url: string | null;
  url: string | null;
}

interface Stat {
  id: number;
  number: number | string | null;
  label: string | null;
}

interface BlogPost {
  id: number;
  title: string | null;
  excerpt: string | null;
  slug: string | null;
  image_url: string | null;
  published_at: string | null;
}

interface ServiceCardFallback {
  key: string;
  title: string;
  description: string;
  icon: React.ComponentType<{className?: string}>;
}

function normalizeStringArray(value: unknown): string[] {
  if (Array.isArray(value)) {
    return value.filter((item): item is string => typeof item === 'string' && item.trim().length > 0);
  }

  if (typeof value === 'string') {
    return value
      .split(/\r?\n|,/)
      .map((item) => item.trim())
      .filter(Boolean);
  }

  return [];
}

function resolveServiceIcon(icon: unknown) {
  const value = typeof icon === 'string' ? icon.toLowerCase() : '';

  if (value.includes('mobile') || value.includes('phone') || value.includes('app')) {
    return Smartphone;
  }

  if (value.includes('comment') || value.includes('chat')) {
    return MessageSquareText;
  }

  if (value.includes('hand-holding') || value.includes('dollar') || value.includes('fund')) {
    return HandCoins;
  }

  if (value.includes('chalkboard') || value.includes('consult')) {
    return Presentation;
  }

  return Globe;
}

function HomePage() {
  const {t, i18n} = useTranslation();
  const settings = useSiteSettings();
  const pageBlocks = usePageBlocks('home');
  const [selectedProject, setSelectedProject] = useState<Project | null>(null);
  const [projects, setProjects] = useState<Project[]>([]);
  const [home, setHome] = useState<HomeContent | null>(null);
  const [about, setAbout] = useState<AboutContent | null>(null);
  const [customers, setCustomers] = useState<Customer[]>([]);
  const [services, setServices] = useState<Service[]>([]);
  const [stats, setStats] = useState<Stat[]>([]);
  const [blogPosts, setBlogPosts] = useState<BlogPost[]>([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const aboutRef = useRef<HTMLElement>(null);
  const {scrollYProgress: aboutScroll} = useScroll({
    target: aboutRef,
    offset: ['start end', 'end start'],
  });
  const aboutY = useTransform(aboutScroll, [0, 1], [100, -100]);

  const servicesRef = useRef<HTMLElement>(null);
  const {scrollYProgress: servicesScroll} = useScroll({
    target: servicesRef,
    offset: ['start end', 'end start'],
  });
  const servicesY = useTransform(servicesScroll, [0, 1], [100, -100]);

  useEffect(() => {
    setLoading(true);

    Promise.allSettled([
      api.get('/projects'),
      api.get('/homes'),
      api.get('/abouts'),
      api.get('/customers'),
      api.get('/services'),
      api.get('/stats'),
      api.get('/blog-posts'),
    ])
      .then((results) => {
        const [
          projectsRes,
          homesRes,
          aboutRes,
          customersRes,
          servicesRes,
          statsRes,
          blogPostsRes,
        ] = results;

        const projectItems =
          projectsRes.status === 'fulfilled'
            ? (projectsRes.value.data?.data ?? [])
            : [];
        const homeItems =
          homesRes.status === 'fulfilled'
            ? (homesRes.value.data?.data ?? [])
            : [];
        const aboutItems =
          aboutRes.status === 'fulfilled'
            ? (aboutRes.value.data?.data ?? [])
            : [];

        setProjects(
          projectItems.map((project: any) => ({
            id: project.id,
            title: project.title,
            category: project.category ?? null,
            image: project.image_url ?? null,
            description: project.description ?? null,
            show_on_homepage: Boolean(project.show_on_homepage),
            homepage_order: Number(project.homepage_order ?? 0),
          })),
        );
        setHome(homeItems[0] ?? null);
        setAbout(aboutItems[0] ?? null);
        setCustomers(customersRes.status === 'fulfilled' ? (customersRes.value.data?.data ?? []) : []);
        setServices(servicesRes.status === 'fulfilled' ? (servicesRes.value.data?.data ?? []) : []);
        setStats(statsRes.status === 'fulfilled' ? (statsRes.value.data?.data ?? []) : []);
        setBlogPosts(blogPostsRes.status === 'fulfilled' ? (blogPostsRes.value.data?.data ?? []) : []);
        setError(projectsRes.status === 'rejected' ? 'Failed to load selected works' : null);
      })
      .finally(() => setLoading(false));
  }, []);

  const blockMap = Object.fromEntries(pageBlocks.map((block) => [block.key, block]));
  const heroBlock = blockMap.hero;
  const aboutBlock = blockMap.about;
  const servicesBlock = blockMap.services;
  const statsBlock = blockMap.stats;
  const portfolioBlock = blockMap.portfolio;
  const blogBlock = blockMap.blog;
  const contactCtaBlock = blockMap.contact_cta;
  const blogCtaUrl = blogBlock?.cta_url || '/blog';
  const contactCtaUrl = contactCtaBlock?.cta_url || '/contact';
  const aboutBlockFeatures = [
    aboutBlock?.meta?.feature_1,
    aboutBlock?.meta?.feature_2,
    aboutBlock?.meta?.feature_3,
  ].filter(Boolean) as string[];
  const featuredProjects =
    projects.some((project) => project.show_on_homepage)
      ? projects
          .filter((project) => project.show_on_homepage)
          .sort((a, b) => (a.homepage_order ?? 0) - (b.homepage_order ?? 0))
      : projects;
  const fallbackProjects: Project[] = [
    {
      id: -1,
      title: t('projects.1.title'),
      category: t('projects.1.category'),
      image: 'https://picsum.photos/seed/sarab1/800/600',
      description: t('projects.1.desc'),
    },
    {
      id: -2,
      title: t('projects.2.title'),
      category: t('projects.2.category'),
      image: 'https://picsum.photos/seed/sarab2/800/600',
      description: t('projects.2.desc'),
    },
    {
      id: -3,
      title: t('projects.3.title'),
      category: t('projects.3.category'),
      image: 'https://picsum.photos/seed/sarab3/800/600',
      description: t('projects.3.desc'),
    },
    {
      id: -4,
      title: t('projects.4.title'),
      category: t('projects.4.category'),
      image: 'https://picsum.photos/seed/sarab4/800/600',
      description: t('projects.4.desc'),
    },
  ];
  const portfolioProjects = featuredProjects.length ? featuredProjects : fallbackProjects;
  const fallbackBlogPosts: BlogPost[] = [
    {
      id: -1,
      slug: '1',
      title: t('blog.posts.1.title'),
      excerpt: t('blog.posts.1.excerpt'),
      image_url: 'https://picsum.photos/seed/sarab-blog-1/900/600',
      published_at: t('blog.posts.1.date'),
    },
    {
      id: -2,
      slug: '2',
      title: t('blog.posts.2.title'),
      excerpt: t('blog.posts.2.excerpt'),
      image_url: 'https://picsum.photos/seed/sarab-blog-2/900/600',
      published_at: t('blog.posts.2.date'),
    },
    {
      id: -3,
      slug: '3',
      title: t('blog.posts.3.title'),
      excerpt: t('blog.posts.3.excerpt'),
      image_url: 'https://picsum.photos/seed/sarab-blog-3/900/600',
      published_at: t('blog.posts.3.date'),
    },
  ];
  const homepageBlogPosts = blogPosts.length ? blogPosts.slice(0, 3) : fallbackBlogPosts;

  const normalizedAboutFeatures = normalizeStringArray(about?.features);
  const aboutFeatures =
    normalizedAboutFeatures.length
      ? normalizedAboutFeatures
      : aboutBlockFeatures.length
        ? aboutBlockFeatures
        : [t('about.point_1'), t('about.point_2'), t('about.point_3')];

  const aboutGallery = [about?.image1_url, about?.image2_url, about?.image3_url].filter(Boolean) as string[];
  const customerMarqueeItems = customers.length
    ? customers
    : [
        {id: -1, name: 'Client Alpha', logo_url: null, website_url: null},
        {id: -2, name: 'Beta Corp', logo_url: null, website_url: null},
        {id: -3, name: 'Gamma Tech', logo_url: null, website_url: null},
        {id: -4, name: 'Delta Systems', logo_url: null, website_url: null},
        {id: -5, name: 'Epsilon Inc', logo_url: null, website_url: null},
      ];
  const serviceCards: Service[] | ServiceCardFallback[] = services.length
    ? services
    : [
        {
          key: 'web',
          title: t('services.web_dev'),
          description: t('services.web_dev_desc'),
          icon: Globe,
        },
        {
          key: 'app',
          title: t('services.app_dev'),
          description: t('services.app_dev_desc'),
          icon: Smartphone,
        },
        {
          key: 'consulting',
          title: t('services.consulting'),
          description: t('services.consulting_desc'),
          icon: ArrowRight,
        },
      ];
  const statsItems = stats.length
    ? stats
    : [
        {id: -1, number: 250, label: t('figures.customers')},
        {id: -2, number: 50, label: t('figures.trainees')},
        {id: -3, number: 2000000, label: t('figures.users')},
        {id: -4, number: 25, label: t('figures.projects')},
      ];

  return (
    <div className="page-shell min-h-screen font-sans selection:bg-cyan-500/30" dir={i18n.language === 'ar' ? 'rtl' : 'ltr'}>
      <Header />

      <div className="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div className="theme-glow-primary absolute top-1/2 left-1/2 h-[600px] w-[600px] -translate-x-1/2 -translate-y-1/2 animate-pulse rounded-full blur-[120px]"></div>
        <div
          className="theme-glow-secondary absolute top-1/2 left-1/2 h-[400px] w-[400px] -translate-x-1/2 -translate-y-1/2 animate-pulse rounded-full blur-[100px]"
          style={{animationDelay: '1s'}}
        ></div>
      </div>

      <ParticleLogo />

      <section id="home" className="relative z-20 flex h-screen flex-col items-center justify-end px-6 pb-28 pointer-events-none md:pb-32">
        <motion.div
          initial={{opacity: 0, y: 24}}
          animate={{opacity: 1, y: 0}}
          transition={{duration: 0.9, delay: 0.4}}
          className="pointer-events-auto relative z-10 mx-auto flex max-w-6xl flex-col items-center gap-5 text-center"
        >
          {home?.image_url && (
            <div className="overflow-hidden rounded-3xl border border-[var(--border-subtle)] bg-[var(--surface-elevated)]/60 p-2 shadow-[0_0_40px_-10px_rgba(6,182,212,0.25)]">
              <img
                src={home.image_url}
                alt={home.h1 || 'Sarab hero'}
                className="max-h-40 w-auto rounded-2xl object-cover md:max-h-52"
                referrerPolicy="no-referrer"
              />
            </div>
          )}

          <div className="space-y-3">
            <h1 className="text-3xl font-bold tracking-[0.16em] md:text-5xl">
              {heroBlock?.title || home?.h1 || t('hero.title')}
              {(heroBlock?.subtitle || home?.h2 || '').trim() && (
                <>
                  <br />
                  <span className="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                    {heroBlock?.subtitle || home?.h2}
                  </span>
                </>
              )}
            </h1>
            <p className="soft-text mx-auto max-w-xl text-sm font-light tracking-[0.18em] uppercase md:text-base">
              {heroBlock?.description || home?.body || t('hero.subtitle')}
            </p>
          </div>

          {(heroBlock?.cta_label || home?.btn_text) && (heroBlock?.cta_url || home?.btn_link) && (
            (heroBlock?.cta_url || home?.btn_link)?.startsWith('/') ? (
              <Link
                to={heroBlock?.cta_url || home?.btn_link || '/contact'}
                className="cta-button inline-flex items-center gap-2 rounded-full px-8 py-4 text-lg font-semibold transition-transform hover:scale-105"
              >
                {heroBlock?.cta_label || home?.btn_text}
                <ArrowRight size={18} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
              </Link>
            ) : (
              <a
                href={heroBlock?.cta_url || home?.btn_link}
                target="_blank"
                rel="noreferrer"
                className="cta-button inline-flex items-center gap-2 rounded-full px-8 py-4 text-lg font-semibold transition-transform hover:scale-105"
              >
                {heroBlock?.cta_label || home?.btn_text}
                <ArrowRight size={18} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
              </a>
            )
          )}
        </motion.div>

        <motion.div
          initial={{opacity: 0}}
          animate={{opacity: 1}}
          transition={{duration: 1, delay: 1.5}}
          className="hero-scroll absolute bottom-10 flex cursor-pointer flex-col items-center animate-bounce pointer-events-auto md:bottom-12"
          onClick={() => document.getElementById('about-us')?.scrollIntoView({behavior: 'smooth'})}
        >
          <span className="mb-2 text-sm uppercase tracking-widest">{settings?.hero_scroll_label || t('hero.scroll')}</span>
          <ArrowDown size={20} />
        </motion.div>
      </section>

      <section id="about-us" ref={aboutRef} className="relative z-20 flex min-h-screen items-center py-24">
        <motion.div
          style={{y: aboutY}}
          className="glass-panel mx-auto grid max-w-6xl grid-cols-1 items-center gap-16 rounded-3xl border p-8 backdrop-blur-sm md:p-12 lg:grid-cols-2"
        >
          <div className="space-y-6">
            <h3 className="text-sm font-semibold uppercase tracking-wider text-cyan-400">{aboutBlock?.eyebrow || settings?.about_section_label || t('about.subtitle')}</h3>
            <h2 className="text-4xl font-bold leading-tight md:text-5xl">
              {aboutBlock?.title || about?.heading1 || t('about.title_1')}
              <br />
              <span className="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                {aboutBlock?.subtitle || about?.heading2 || t('about.title_2')}
              </span>
            </h2>
            <p className="muted-text text-lg leading-relaxed">{aboutBlock?.description || about?.description || t('about.desc')}</p>
          </div>

          <motion.div
            className="space-y-8"
            initial="hidden"
            whileInView="visible"
            viewport={{once: true, margin: '-50px'}}
            variants={{
              visible: {transition: {staggerChildren: 0.3}},
              hidden: {},
            }}
          >
            {aboutFeatures.map((point, index) => (
              <motion.div
                key={`${point}-${index}`}
                variants={{
                  hidden: {opacity: 0, y: 20},
                  visible: {opacity: 1, y: 0, transition: {duration: 0.5, ease: 'easeOut'}},
                }}
                className="flex gap-4"
              >
                <CheckCircle2 className="mt-1 shrink-0 text-cyan-400" />
                <p className="soft-text">{point}</p>
              </motion.div>
            ))}

            {aboutGallery.length > 0 && (
              <div className="grid grid-cols-3 gap-3 pt-2">
                {aboutGallery.map((image, index) => (
                  <div key={`${image}-${index}`} className="overflow-hidden rounded-2xl border border-[var(--border-subtle)]">
                    <img
                      src={image}
                      alt={`About gallery ${index + 1}`}
                      className="h-24 w-full object-cover"
                      referrerPolicy="no-referrer"
                    />
                  </div>
                ))}
              </div>
            )}
          </motion.div>
        </motion.div>
      </section>

      <section className="subtle-section relative z-20 overflow-hidden border-y py-24 backdrop-blur-sm">
        <div className="mx-auto mb-12 max-w-6xl px-6 text-center">
          <h3 className="faint-text text-sm font-semibold uppercase tracking-wider">{settings?.customers_section_label || t('customers.title')}</h3>
        </div>
        <div className="flex w-[200%] animate-marquee">
          {[...Array(2)].map((_, index) => (
            <div key={index} className="flex w-1/2 items-center justify-around">
              {customerMarqueeItems.map((customer) => (
                customer.website_url ? (
                  <a
                    key={customer.id}
                    href={customer.website_url}
                    target="_blank"
                    rel="noreferrer"
                    className="logo-strip-text flex items-center gap-2 text-2xl font-bold uppercase tracking-widest"
                  >
                    {customer.logo_url && <img src={customer.logo_url} alt={customer.name} className="mr-2 inline-block h-8 w-auto" />}
                    {customer.name}
                  </a>
                ) : (
                  <div key={customer.id} className="logo-strip-text flex items-center gap-2 text-2xl font-bold uppercase tracking-widest">
                    {customer.logo_url && <img src={customer.logo_url} alt={customer.name} className="mr-2 inline-block h-8 w-auto" />}
                    {customer.name}
                  </div>
                )
              ))}
            </div>
          ))}
        </div>
      </section>

      <section id="services" ref={servicesRef} className="relative z-20 flex min-h-screen flex-col justify-center py-24">
        <motion.div style={{y: servicesY}} className="mx-auto w-full max-w-6xl px-6">
          <div className="mb-16 space-y-4 text-center">
            <h3 className="text-sm font-semibold uppercase tracking-wider text-cyan-400">{servicesBlock?.eyebrow || settings?.services_section_label || t('services.subtitle')}</h3>
            <h2 className="text-4xl font-bold md:text-5xl">{servicesBlock?.title || settings?.services_section_title || t('services.title')}</h2>
            <p className="muted-text mx-auto max-w-3xl text-lg">
              {servicesBlock?.description || t('about.desc')}
            </p>
          </div>
          <div className="grid grid-cols-1 gap-8 md:grid-cols-3">
            {serviceCards.map((service) => (
              <div key={'id' in service ? service.id : service.key} className="card-surface rounded-2xl border p-8 backdrop-blur-md transition-colors hover:border-cyan-500/30">
                {'image_url' in service && service.image_url ? (
                  <img src={service.image_url} alt={service.title || 'Service'} className="mb-6 h-12 w-12 object-contain" />
                ) : 'icon' in service && typeof service.icon === 'function' ? (
                  <service.icon className="mb-6 h-12 w-12 text-cyan-400" />
                ) : 'icon' in service ? (
                  (() => {
                    const IconComponent = resolveServiceIcon(service.icon as string | null);
                    return <IconComponent className="mb-6 h-12 w-12 text-cyan-400" />;
                  })()
                ) : null}
                <h3 className="mb-4 text-2xl font-bold">{service.title}</h3>
                <p className="muted-text">{service.description}</p>
                {'url' in service && service.url && (
                  <a
                    href={service.url}
                    target="_blank"
                    rel="noreferrer"
                    className="mt-6 inline-flex items-center gap-2 text-cyan-400 transition-colors hover:text-cyan-300"
                  >
                    {settings?.portfolio_view_details_label || t('portfolio.view_details')}
                    <ArrowRight size={16} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
                  </a>
                )}
              </div>
            ))}
          </div>
        </motion.div>
      </section>

      <section className="subtle-section relative z-20 border-y py-32 backdrop-blur-sm">
        <div className="mx-auto max-w-6xl px-6">
          <div className="grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
            <div>
              <h3 className="mb-4 text-sm font-semibold uppercase tracking-wider text-cyan-400">{statsBlock?.eyebrow || settings?.figures_section_label || t('figures.subtitle')}</h3>
              <h2 className="mb-6 text-4xl font-bold md:text-5xl">{statsBlock?.title || settings?.figures_section_title || t('figures.title')}</h2>
              <p className="muted-text text-lg leading-relaxed">{statsBlock?.description || settings?.figures_section_description || t('figures.desc')}</p>
            </div>
            <div className="grid grid-cols-2 gap-8">
              {statsItems.map((stat) => (
                <div key={stat.id} className="space-y-2">
                  <div className="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-4xl font-bold text-transparent md:text-5xl">
                    <AnimatedCounter value={Number(stat.number ?? 0)} />
                  </div>
                  <div className="muted-text text-sm font-medium uppercase tracking-wider">{stat.label}</div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      <section id="portfolio" className="relative z-20 flex min-h-screen flex-col justify-center py-24">
        <div className="mx-auto w-full max-w-6xl px-6">
          <div className="mb-16 space-y-4 text-center">
            <h3 className="text-sm font-semibold uppercase tracking-wider text-cyan-400">{portfolioBlock?.eyebrow || settings?.portfolio_section_label || t('portfolio.subtitle')}</h3>
            <h2 className="text-4xl font-bold md:text-5xl">{portfolioBlock?.title || settings?.portfolio_section_title || t('portfolio.title')}</h2>
            {(portfolioBlock?.description || '').trim() && (
              <p className="muted-text mx-auto max-w-3xl text-lg">{portfolioBlock?.description}</p>
            )}
          </div>
          <div className="grid grid-cols-1 gap-8 md:grid-cols-2">
            {loading && <div className="col-span-2 py-8 text-center">Loading projects...</div>}
            {portfolioProjects.map((project) => (
                <div
                  key={project.id}
                  onClick={() => setSelectedProject(project)}
                className="project-card group relative aspect-video cursor-pointer overflow-hidden rounded-2xl border border-[var(--border-subtle)] bg-[var(--surface-elevated)] transition-all duration-500 hover:border-cyan-500/50 hover:shadow-[0_0_30px_-5px_rgba(6,182,212,0.3)]"
              >
                <div className="project-overlay absolute inset-0 z-10 opacity-80 transition-opacity group-hover:opacity-90"></div>
                <img
                  src={project.image || 'https://picsum.photos/seed/sarab1/800/600'}
                  alt={project.title}
                  className="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                  referrerPolicy="no-referrer"
                />
                <div className="absolute inset-0 z-20 flex translate-y-4 flex-col justify-end p-8 transition-transform duration-500 group-hover:translate-y-0">
                  <span className="mb-2 text-sm font-medium uppercase tracking-wider text-cyan-400 opacity-0 transition-opacity duration-500 delay-100 group-hover:opacity-100">
                    {project.category || ''}
                  </span>
                  <h3 className="mb-2 text-2xl font-bold text-white md:text-3xl">{project.title}</h3>
                  <div className="project-meta flex items-center gap-2 transition-colors duration-300">
                    <span className="text-sm font-semibold uppercase tracking-wider">{settings?.portfolio_view_details_label || t('portfolio.view_details')}</span>
                    <ArrowRight
                      size={16}
                      className={`transform opacity-0 transition-all duration-500 ${i18n.language === 'ar' ? 'translate-x-4 rotate-180 group-hover:translate-x-0' : '-translate-x-4 group-hover:translate-x-0'} group-hover:opacity-100`}
                    />
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section id="blog" className="subtle-section relative z-20 border-y py-24 backdrop-blur-sm">
        <div className="mx-auto max-w-6xl px-6">
          <div className="mb-16 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div className="max-w-2xl space-y-4">
              <h3 className="text-sm font-semibold uppercase tracking-wider text-cyan-400">{blogBlock?.eyebrow || settings?.blog_section_label || t('header.blog')}</h3>
              <h2 className="text-4xl font-bold md:text-5xl">{blogBlock?.title || settings?.blog_section_title || t('blog.title')}</h2>
              <p className="muted-text text-lg leading-relaxed">{blogBlock?.description || settings?.blog_section_description || t('blog.description')}</p>
            </div>
            {blogCtaUrl.startsWith('/') ? (
              <Link
                to={blogCtaUrl}
                className="project-meta inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-wider transition-colors hover:text-cyan-400"
              >
                <span>{blogBlock?.cta_label || settings?.blog_cta_label || settings?.blog_read_more_label || t('blog.cta')}</span>
                <ArrowRight size={16} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
              </Link>
            ) : (
              <a
                href={blogCtaUrl}
                target="_blank"
                rel="noreferrer"
                className="project-meta inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-wider transition-colors hover:text-cyan-400"
              >
                <span>{blogBlock?.cta_label || settings?.blog_cta_label || settings?.blog_read_more_label || t('blog.cta')}</span>
                <ArrowRight size={16} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
              </a>
            )}
          </div>
          <div className="grid grid-cols-1 gap-8 md:grid-cols-3">
            {homepageBlogPosts.map((post, index) => (
              <Link key={post.id} to={`/blog/${post.slug || post.id}`} className="block">
                <article className="card-surface h-full overflow-hidden rounded-2xl border border-[var(--border-subtle)] transition-colors hover:border-cyan-500/30">
                  {post.image_url && (
                    <img
                      src={post.image_url}
                      alt={post.title || 'Blog post'}
                      className="h-52 w-full object-cover"
                      referrerPolicy="no-referrer"
                    />
                  )}
                  <div className="space-y-4 p-6">
                    <div className="mb-2 flex items-center justify-between gap-4">
                      <span className="text-sm font-semibold uppercase tracking-wider text-cyan-400">
                        {blogPosts.length ? (settings?.blog_section_label || t('header.blog')) : t(`blog.posts.${index + 1}.category`)}
                      </span>
                      <span className="muted-text inline-flex items-center gap-2 text-sm">
                        <CalendarDays size={16} className="text-cyan-400" />
                        {blogPosts.length && post.published_at
                          ? new Date(post.published_at).toLocaleDateString(i18n.language === 'ar' ? 'ar' : 'en-US', {
                              year: 'numeric',
                              month: 'short',
                              day: 'numeric',
                            })
                          : post.published_at || 'Draft'}
                      </span>
                    </div>
                    <h3 className="text-2xl font-bold">{post.title}</h3>
                    <p className="muted-text mb-8 line-clamp-4 leading-relaxed">{post.excerpt || 'No excerpt has been added yet.'}</p>
                    <div className="project-meta inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-wider transition-colors hover:text-cyan-400">
                      <span>{settings?.blog_read_more_label || settings?.blog_cta_label || t('blog.read_more')}</span>
                      <ArrowRight size={16} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
                    </div>
                  </div>
                </article>
              </Link>
            ))}
          </div>
        </div>
      </section>

      <section id="contact" className="relative z-20 flex h-screen flex-col items-center justify-center pb-32">
        <div className="glass-panel space-y-8 rounded-3xl border p-12 text-center backdrop-blur-md">
          <h2 className="text-5xl font-bold tracking-tighter md:text-7xl">{contactCtaBlock?.title || settings?.contact_cta_title || t('contact.title')}</h2>
          <p className="muted-text mx-auto max-w-2xl text-xl">{contactCtaBlock?.description || settings?.contact_cta_description || t('contact.desc')}</p>
          {contactCtaUrl.startsWith('/') ? (
            <Link to={contactCtaUrl} className="cta-button inline-block cursor-pointer rounded-full px-8 py-4 text-lg font-semibold transition-transform hover:scale-105">
              {contactCtaBlock?.cta_label || settings?.contact_cta_button_label || t('contact.button')}
            </Link>
          ) : (
            <a
              href={contactCtaUrl}
              target="_blank"
              rel="noreferrer"
              className="cta-button inline-block cursor-pointer rounded-full px-8 py-4 text-lg font-semibold transition-transform hover:scale-105"
            >
              {contactCtaBlock?.cta_label || settings?.contact_cta_button_label || t('contact.button')}
            </a>
          )}
        </div>
      </section>

      <Footer />
      <ProjectModal project={selectedProject} onClose={() => setSelectedProject(null)} />
    </div>
  );
}

export default function App() {
  return (
    <Routes>
      <Route path="/" element={<HomePage />} />
      <Route path="/terms" element={<TermsAndConditions />} />
      <Route path="/privacy" element={<PrivacyPolicy />} />
      <Route path="/refund" element={<RefundPolicy />} />
      <Route path="/cancellation" element={<CancellationPolicy />} />
      <Route path="/promotions" element={<PromotionsTerms />} />
      <Route path="/security" element={<SecurityPolicy />} />
      <Route path="/contact" element={<ContactPage />} />
      <Route path="/pricing" element={<PricingPage />} />
      <Route path="/blog" element={<BlogIndexPage />} />
      <Route path="/blog/:postId" element={<BlogPostPage />} />
    </Routes>
  );
}
