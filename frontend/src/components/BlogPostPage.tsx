import React, { useEffect, useState } from 'react';
import { useTranslation } from 'react-i18next';
import { Link, Navigate, useParams } from 'react-router-dom';
import { ArrowLeft, ArrowRight, CalendarDays, Clock3 } from 'lucide-react';
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

export default function BlogPostPage() {
  const { t, i18n } = useTranslation();
  const { postId } = useParams<{ postId: string }>();
  const settings = useSiteSettings();
  const [post, setPost] = useState<BlogPost | null>(null);
  const [otherPosts, setOtherPosts] = useState<BlogPost[]>([]);
  const [notFound, setNotFound] = useState(false);

  useEffect(() => {
    if (!postId) {
      return;
    }

    let isMounted = true;

    api.get(`/blog-posts/${postId}`)
      .then((response) => {
        if (!isMounted) {
          return;
        }

        const payload = response.data?.data;
        const current: BlogPost | null = payload?.post ?? null;

        if (!current) {
          setNotFound(true);
          return;
        }

        setPost(current);
        setOtherPosts(payload?.related ?? []);
      })
      .catch(() => {
        if (isMounted) {
          setNotFound(true);
        }
      });

    return () => {
      isMounted = false;
    };
  }, [postId]);

  if (!postId || notFound) {
    return <Navigate to="/" replace />;
  }

  return (
    <div className="page-shell min-h-screen font-sans selection:bg-cyan-500/30" dir={i18n.language === 'ar' ? 'rtl' : 'ltr'}>
      <Header />

      <div className="pt-32 pb-24 px-6 max-w-4xl mx-auto relative z-20">
        <Link
          to="/blog"
          className="muted-text inline-flex items-center gap-2 hover:text-cyan-400 transition-colors mb-8 font-medium"
        >
          <ArrowLeft size={20} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
          {settings?.blog_back_label || (i18n.language === 'ar' ? 'العودة إلى المدونة' : 'Back to Blog')}
        </Link>

        <div className="glass-panel rounded-3xl border p-8 md:p-12 backdrop-blur-sm">
          <div className="flex flex-wrap items-center gap-4 mb-6">
            <span className="text-cyan-400 text-sm font-semibold uppercase tracking-wider">
              {settings?.blog_section_label || t('header.blog')}
            </span>
            <span className="muted-text inline-flex items-center gap-2 text-sm">
              <CalendarDays size={16} className="text-cyan-400" />
              {post?.published_at
                ? new Date(post.published_at).toLocaleDateString(i18n.language === 'ar' ? 'ar' : 'en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                  })
                : 'Draft'}
            </span>
            <span className="muted-text inline-flex items-center gap-2 text-sm">
              <Clock3 size={16} className="text-cyan-400" />
              {post?.content ? `${Math.max(1, Math.ceil(post.content.split(/\s+/).length / 200))} min read` : '1 min read'}
            </span>
          </div>

          <h1 className="text-4xl md:text-5xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">
            {post?.title}
          </h1>

          <p className="text-lg muted-text leading-relaxed mb-10">
            {post?.excerpt}
          </p>

          <div className="space-y-10 leading-relaxed muted-text legal-content prose max-w-none">
            <div dangerouslySetInnerHTML={{ __html: post?.content || '' }} />
          </div>
        </div>

        <div className="mt-16">
          <div className="flex flex-col gap-6 md:flex-row md:items-end md:justify-between mb-8">
            <div>
              <h2 className="text-3xl font-bold mb-2">{settings?.blog_more_title || 'More articles'}</h2>
              <p className="muted-text">{settings?.blog_more_description || 'Keep exploring our latest insights, stories, and product thinking.'}</p>
            </div>
            <Link
              to="/blog"
              className="project-meta inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-wider hover:text-cyan-400 transition-colors"
            >
              <span>{settings?.blog_cta_label || settings?.blog_read_more_label || t('blog.cta')}</span>
              <ArrowRight size={16} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
            </Link>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {otherPosts.map((item) => (
              <Link key={item.id} to={`/blog/${item.slug || item.id}`} className="block h-full">
                <article className="card-surface h-full border rounded-2xl p-6 backdrop-blur-md">
                  <div className="flex items-center justify-between gap-4 mb-4">
                    <span className="text-cyan-400 text-sm font-semibold uppercase tracking-wider">
                      {settings?.blog_section_label || t('header.blog')}
                    </span>
                    <span className="muted-text text-sm">
                      {item.published_at
                        ? new Date(item.published_at).toLocaleDateString(i18n.language === 'ar' ? 'ar' : 'en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                          })
                        : 'Draft'}
                    </span>
                  </div>
                  <h3 className="text-2xl font-bold mb-3">{item.title}</h3>
                  <p className="muted-text mb-6">{item.excerpt}</p>
                  <div className="project-meta inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-wider hover:text-cyan-400 transition-colors">
                    <span>{settings?.blog_read_more_label || settings?.blog_cta_label || t('blog.read_more')}</span>
                    <ArrowRight size={16} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
                  </div>
                </article>
              </Link>
            ))}
          </div>
        </div>
      </div>

      <Footer />
    </div>
  );
}
