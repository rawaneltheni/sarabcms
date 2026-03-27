import { useEffect, useState } from 'react';
import api from '../api';
import LegalPage from './LegalPage';

interface CmsLegalPageProps {
  slug: string;
  fallbackTitle: string;
}

interface LegalPageData {
  title?: string | null;
  content?: string | null;
}

export default function CmsLegalPage({ slug, fallbackTitle }: CmsLegalPageProps) {
  const [page, setPage] = useState<LegalPageData | null>(null);

  useEffect(() => {
    let isMounted = true;

    api.get(`/legal-pages/${slug}`)
      .then((response) => {
        if (isMounted) {
          setPage(response.data?.data ?? response.data ?? {});
        }
      })
      .catch(() => {
        if (isMounted) {
          setPage({});
        }
      });

    return () => {
      isMounted = false;
    };
  }, [slug]);

  return (
    <LegalPage title={page?.title || fallbackTitle}>
      <div className="whitespace-pre-wrap break-words">
        {page?.content || ''}
      </div>
    </LegalPage>
  );
}
