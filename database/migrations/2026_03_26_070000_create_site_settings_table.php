<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('address')->nullable();
            $table->string('header_home_label')->nullable();
            $table->string('header_about_label')->nullable();
            $table->string('header_services_label')->nullable();
            $table->string('header_portfolio_label')->nullable();
            $table->string('header_blog_label')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_heading')->nullable();
            $table->text('contact_description')->nullable();
            $table->string('contact_information_heading')->nullable();
            $table->string('contact_form_heading')->nullable();
            $table->string('contact_form_submit_label')->nullable();
            $table->string('contact_address_label')->nullable();
            $table->string('contact_email_label')->nullable();
            $table->string('contact_phone_label')->nullable();
            $table->string('contact_back_label')->nullable();
            $table->string('contact_first_name_label')->nullable();
            $table->string('contact_last_name_label')->nullable();
            $table->string('contact_email_input_label')->nullable();
            $table->string('contact_subject_label')->nullable();
            $table->string('contact_message_label')->nullable();
            $table->string('contact_first_name_placeholder')->nullable();
            $table->string('contact_last_name_placeholder')->nullable();
            $table->string('contact_email_placeholder')->nullable();
            $table->string('contact_subject_placeholder')->nullable();
            $table->string('contact_message_placeholder')->nullable();
            $table->string('project_prompt')->nullable();
            $table->string('lets_talk_label')->nullable();
            $table->string('footer_description')->nullable();
            $table->string('footer_links_heading')->nullable();
            $table->string('footer_terms_label')->nullable();
            $table->string('footer_privacy_label')->nullable();
            $table->string('footer_refund_label')->nullable();
            $table->string('footer_cancellation_label')->nullable();
            $table->string('footer_promotions_label')->nullable();
            $table->string('footer_security_label')->nullable();
            $table->string('hero_scroll_label')->nullable();
            $table->string('about_section_label')->nullable();
            $table->string('customers_section_label')->nullable();
            $table->string('services_section_label')->nullable();
            $table->string('services_section_title')->nullable();
            $table->string('figures_section_label')->nullable();
            $table->string('figures_section_title')->nullable();
            $table->text('figures_section_description')->nullable();
            $table->string('portfolio_section_label')->nullable();
            $table->string('portfolio_section_title')->nullable();
            $table->string('portfolio_view_details_label')->nullable();
            $table->string('blog_section_label')->nullable();
            $table->string('blog_section_title')->nullable();
            $table->text('blog_section_description')->nullable();
            $table->string('blog_back_label')->nullable();
            $table->string('blog_read_more_label')->nullable();
            $table->string('blog_more_title')->nullable();
            $table->text('blog_more_description')->nullable();
            $table->string('blog_cta_label')->nullable();
            $table->string('contact_cta_title')->nullable();
            $table->text('contact_cta_description')->nullable();
            $table->string('contact_cta_button_label')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('map_embed_url', 2048)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
