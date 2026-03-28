<?php

namespace App\Models;

use App\Models\Concerns\BumpsApiCacheVersion;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use BumpsApiCacheVersion;

    protected $fillable = [
        'site_name',
        'header_logo',
        'footer_logo',
        'address',
        'header_home_label',
        'header_about_label',
        'header_services_label',
        'header_portfolio_label',
        'header_blog_label',
        'contact_email',
        'contact_phone',
        'contact_heading',
        'contact_description',
        'contact_information_heading',
        'contact_form_heading',
        'contact_form_submit_label',
        'contact_address_label',
        'contact_email_label',
        'contact_phone_label',
        'contact_back_label',
        'contact_first_name_label',
        'contact_last_name_label',
        'contact_email_input_label',
        'contact_subject_label',
        'contact_message_label',
        'contact_first_name_placeholder',
        'contact_last_name_placeholder',
        'contact_email_placeholder',
        'contact_subject_placeholder',
        'contact_message_placeholder',
        'project_prompt',
        'lets_talk_label',
        'footer_description',
        'footer_links_heading',
        'footer_terms_label',
        'footer_privacy_label',
        'footer_refund_label',
        'footer_cancellation_label',
        'footer_promotions_label',
        'footer_security_label',
        'hero_scroll_label',
        'about_section_label',
        'customers_section_label',
        'services_section_label',
        'services_section_title',
        'figures_section_label',
        'figures_section_title',
        'figures_section_description',
        'portfolio_section_label',
        'portfolio_section_title',
        'portfolio_view_details_label',
        'blog_section_label',
        'blog_section_title',
        'blog_section_description',
        'blog_back_label',
        'blog_read_more_label',
        'blog_more_title',
        'blog_more_description',
        'blog_cta_label',
        'contact_cta_title',
        'contact_cta_description',
        'contact_cta_button_label',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'map_embed_url',
    ];

    public function getHeaderLogoUrlAttribute(): ?string
    {
        $path = trim((string) ($this->header_logo ?? ''));

        if ($path === '') {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    public function getFooterLogoUrlAttribute(): ?string
    {
        $path = trim((string) ($this->footer_logo ?? ''));

        if ($path === '') {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
