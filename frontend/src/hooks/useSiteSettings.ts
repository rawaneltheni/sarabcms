import { useEffect, useState } from 'react';
import api from '../api';

export interface SiteSettings {
  site_name?: string | null;
  header_logo?: string | null;
  header_logo_url?: string | null;
  footer_logo?: string | null;
  footer_logo_url?: string | null;
  address?: string | null;
  header_home_label?: string | null;
  header_about_label?: string | null;
  header_services_label?: string | null;
  header_portfolio_label?: string | null;
  header_blog_label?: string | null;
  contact_email?: string | null;
  contact_phone?: string | null;
  contact_heading?: string | null;
  contact_description?: string | null;
  contact_information_heading?: string | null;
  contact_form_heading?: string | null;
  contact_form_submit_label?: string | null;
  contact_address_label?: string | null;
  contact_email_label?: string | null;
  contact_phone_label?: string | null;
  contact_back_label?: string | null;
  contact_first_name_label?: string | null;
  contact_last_name_label?: string | null;
  contact_email_input_label?: string | null;
  contact_subject_label?: string | null;
  contact_message_label?: string | null;
  contact_first_name_placeholder?: string | null;
  contact_last_name_placeholder?: string | null;
  contact_email_placeholder?: string | null;
  contact_subject_placeholder?: string | null;
  contact_message_placeholder?: string | null;
  project_prompt?: string | null;
  lets_talk_label?: string | null;
  footer_description?: string | null;
  footer_links_heading?: string | null;
  footer_terms_label?: string | null;
  footer_privacy_label?: string | null;
  footer_refund_label?: string | null;
  footer_cancellation_label?: string | null;
  footer_promotions_label?: string | null;
  footer_security_label?: string | null;
  hero_scroll_label?: string | null;
  about_section_label?: string | null;
  customers_section_label?: string | null;
  services_section_label?: string | null;
  services_section_title?: string | null;
  figures_section_label?: string | null;
  figures_section_title?: string | null;
  figures_section_description?: string | null;
  portfolio_section_label?: string | null;
  portfolio_section_title?: string | null;
  portfolio_view_details_label?: string | null;
  blog_section_label?: string | null;
  blog_section_title?: string | null;
  blog_section_description?: string | null;
  blog_back_label?: string | null;
  blog_read_more_label?: string | null;
  blog_more_title?: string | null;
  blog_more_description?: string | null;
  blog_cta_label?: string | null;
  contact_cta_title?: string | null;
  contact_cta_description?: string | null;
  contact_cta_button_label?: string | null;
  facebook_url?: string | null;
  twitter_url?: string | null;
  instagram_url?: string | null;
  linkedin_url?: string | null;
  map_embed_url?: string | null;
}

let cachedSettings: SiteSettings | null = null;

export function useSiteSettings() {
  const [settings, setSettings] = useState<SiteSettings | null>(cachedSettings);

  useEffect(() => {
    if (cachedSettings) {
      return;
    }

    let isMounted = true;

    api.get('/site-settings')
      .then((response) => {
        if (!isMounted) {
          return;
        }

        cachedSettings = response.data?.data ?? response.data ?? {};
        setSettings(cachedSettings);
      })
      .catch(() => {
        if (isMounted) {
          setSettings({});
        }
      });

    return () => {
      isMounted = false;
    };
  }, []);

  return settings;
}
