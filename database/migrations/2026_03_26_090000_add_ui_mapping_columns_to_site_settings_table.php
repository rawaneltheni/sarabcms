<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('header_home_label')->nullable()->after('address');
            $table->string('header_about_label')->nullable()->after('header_home_label');
            $table->string('header_services_label')->nullable()->after('header_about_label');
            $table->string('header_portfolio_label')->nullable()->after('header_services_label');
            $table->string('header_blog_label')->nullable()->after('header_portfolio_label');
            $table->string('contact_information_heading')->nullable()->after('contact_description');
            $table->string('contact_first_name_label')->nullable()->after('contact_back_label');
            $table->string('contact_last_name_label')->nullable()->after('contact_first_name_label');
            $table->string('contact_email_input_label')->nullable()->after('contact_last_name_label');
            $table->string('contact_subject_label')->nullable()->after('contact_email_input_label');
            $table->string('contact_message_label')->nullable()->after('contact_subject_label');
            $table->string('contact_first_name_placeholder')->nullable()->after('contact_message_label');
            $table->string('contact_last_name_placeholder')->nullable()->after('contact_first_name_placeholder');
            $table->string('contact_email_placeholder')->nullable()->after('contact_last_name_placeholder');
            $table->string('contact_subject_placeholder')->nullable()->after('contact_email_placeholder');
            $table->string('contact_message_placeholder')->nullable()->after('contact_subject_placeholder');
            $table->string('footer_terms_label')->nullable()->after('footer_links_heading');
            $table->string('footer_privacy_label')->nullable()->after('footer_terms_label');
            $table->string('footer_refund_label')->nullable()->after('footer_privacy_label');
            $table->string('footer_cancellation_label')->nullable()->after('footer_refund_label');
            $table->string('footer_promotions_label')->nullable()->after('footer_cancellation_label');
            $table->string('footer_security_label')->nullable()->after('footer_promotions_label');
            $table->string('hero_scroll_label')->nullable()->after('footer_security_label');
            $table->string('about_section_label')->nullable()->after('hero_scroll_label');
            $table->string('customers_section_label')->nullable()->after('about_section_label');
            $table->string('services_section_label')->nullable()->after('customers_section_label');
            $table->string('services_section_title')->nullable()->after('services_section_label');
            $table->string('figures_section_label')->nullable()->after('services_section_title');
            $table->string('figures_section_title')->nullable()->after('figures_section_label');
            $table->text('figures_section_description')->nullable()->after('figures_section_title');
            $table->string('portfolio_section_label')->nullable()->after('figures_section_description');
            $table->string('portfolio_section_title')->nullable()->after('portfolio_section_label');
            $table->string('portfolio_view_details_label')->nullable()->after('portfolio_section_title');
            $table->string('blog_section_label')->nullable()->after('portfolio_view_details_label');
            $table->string('blog_section_title')->nullable()->after('blog_section_label');
            $table->text('blog_section_description')->nullable()->after('blog_section_title');
            $table->string('blog_back_label')->nullable()->after('blog_section_description');
            $table->string('blog_read_more_label')->nullable()->after('blog_back_label');
            $table->string('blog_more_title')->nullable()->after('blog_read_more_label');
            $table->text('blog_more_description')->nullable()->after('blog_more_title');
            $table->string('blog_cta_label')->nullable()->after('blog_more_description');
            $table->string('contact_cta_title')->nullable()->after('blog_cta_label');
            $table->text('contact_cta_description')->nullable()->after('contact_cta_title');
            $table->string('contact_cta_button_label')->nullable()->after('contact_cta_description');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'header_home_label',
                'header_about_label',
                'header_services_label',
                'header_portfolio_label',
                'header_blog_label',
                'contact_information_heading',
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
            ]);
        });
    }
};
