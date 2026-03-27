import { useEffect, useState } from 'react';
import api from '../api';

export interface PageBlock {
  id: number;
  page: string;
  key: string;
  eyebrow?: string | null;
  title?: string | null;
  subtitle?: string | null;
  description?: string | null;
  cta_label?: string | null;
  cta_url?: string | null;
  secondary_cta_label?: string | null;
  secondary_cta_url?: string | null;
  meta?: Record<string, string | null> | null;
}

let cache: Record<string, PageBlock[]> = {};

export function usePageBlocks(page: string) {
  const [blocks, setBlocks] = useState<PageBlock[]>(cache[page] ?? []);

  useEffect(() => {
    if (cache[page]) {
      return;
    }

    let isMounted = true;

    api.get('/page-blocks', { params: { page } })
      .then((response) => {
        if (!isMounted) {
          return;
        }

        cache[page] = response.data?.data ?? [];
        setBlocks(cache[page]);
      })
      .catch(() => {
        if (isMounted) {
          setBlocks([]);
        }
      });

    return () => {
      isMounted = false;
    };
  }, [page]);

  return blocks;
}
