import { useEffect, useState } from 'react';
import api from '../api';

export interface LegalPageSummary {
  slug: string;
  title: string | null;
}

let cachedPages: LegalPageSummary[] | null = null;

export function useLegalPages() {
  const [pages, setPages] = useState<LegalPageSummary[]>(cachedPages ?? []);

  useEffect(() => {
    if (cachedPages) {
      return;
    }

    let isMounted = true;

    api.get('/legal-pages')
      .then((response) => {
        if (!isMounted) {
          return;
        }

        cachedPages = response.data?.data ?? [];
        setPages(cachedPages);
      })
      .catch(() => {
        if (isMounted) {
          setPages([]);
        }
      });

    return () => {
      isMounted = false;
    };
  }, []);

  return pages;
}
