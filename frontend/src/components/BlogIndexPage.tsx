import React, { useEffect, useState } from 'react';
import { useTranslation } from 'react-i18next';
import { Link } from 'react-router-dom';
import { ArrowRight, CalendarDays } from 'lucide-react';
import api from '../api';
import { useSiteSettings } from '../hooks/useSiteSettings';
import Header from './Header';
import Footer from './Footer';

interface BlogPost {
  id: number;
  title: string | null;
  excerpt: string | null;
  slug: string | null;
  content: string | null;
  image_url: string | null;
  published_at: string | null;
}

export default function BlogIndexPage() {
  const { t, i18n } = useTranslation();
  const settings = useSiteSettings();
  const [posts, setPosts] = useState<BlogPost[]>([]);

  useEffect(() => {
    let isMounted = true;

    api.get('/blog-posts')
      .then((response) => {
        if (!isMounted) {
          return;
        }

        setPosts(response.data?.data ?? []);
      })
      .catch(() => {
        if (isMounted) {
          setPosts([]);
        }
      });

    return () => {
      isMounted = false;
    };
  }, []);

  return (
    <div className="page-shell min-h-screen font-sans selection:bg-cyan-500/30" dir={i18n.language === 'ar' ? 'rtl' : 'ltr'}>
      <Header />

      <div className="relative z-20 mx-auto max-w-6xl px-6 pb-24 pt-32">
        <div className="mb-14 max-w-3xl space-y-4">
          <span className="text-sm font-semibold uppercase tracking-wider text-cyan-400">
            {settings?.blog_section_label || t('header.blog')}
          </span>
          <h1 className="text-4xl font-bold md:text-5xl">
            {settings?.blog_more_title || settings?.blog_section_title || t('blog.title')}
          </h1>
          <p className="muted-text text-lg leading-relaxed">
            {settings?.blog_more_description || settings?.blog_section_description || t('blog.description')}
          </p>
        </div>

        <div className="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3">
          {posts.map((post) => (
            <Link key={post.id} to={`/blog/${post.slug || post.id}`} className="block h-full">
              <article className="card-surface h-full overflow-hidden rounded-2xl border border-[var(--border-subtle)] transition-colors hover:border-cyan-500/30">
                {post.image_url && (
                  <img
                    src={post.image_url}
                    alt={post.title || 'Blog post'}
                    className="h-56 w-full object-cover"
                    referrerPolicy="no-referrer"
                  />
                )}

                <div className="space-y-4 p-6">
                  <div className="flex items-center justify-between gap-4">
                    <span className="text-sm font-semibold uppercase tracking-wider text-cyan-400">
                      {settings?.blog_section_label || t('header.blog')}
                    </span>
                    <span className="muted-text inline-flex items-center gap-2 text-sm">
                      <CalendarDays size={16} className="text-cyan-400" />
                      {post.published_at
                        ? new Date(post.published_at).toLocaleDateString(i18n.language === 'ar' ? 'ar' : 'en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                          })
                        : 'Draft'}
                    </span>
                  </div>

                  <h2 className="text-2xl font-bold">{post.title}</h2>
                  <p className="muted-text line-clamp-4 leading-relaxed">
                    {post.excerpt || 'No excerpt has been added yet.'}
                  </p>

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

      <Footer />
    </div>
  );
}
