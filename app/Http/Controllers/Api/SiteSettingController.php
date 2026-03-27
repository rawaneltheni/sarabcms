<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SiteSettingResource;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    public function show(): SiteSettingResource
    {
        $settings = SiteSetting::query()->firstOrCreate(
            ['id' => 1],
            [
                'site_name' => 'SARAB TECH',
                'address' => '651 N Broad St, Middletown, DE 19709, USA',
                'header_home_label' => 'Home',
                'header_about_label' => 'About us',
                'header_services_label' => 'Pricing',
                'header_portfolio_label' => 'Portfolio',
                'header_blog_label' => 'Blog',
                'contact_email' => 'info@sarab.tech',
                'contact_phone' => '+1(202)9984099',
                'contact_heading' => 'Contact Us',
                'contact_description' => 'We are here to help. Reach out to us for any inquiries or requests.',
                'contact_information_heading' => 'Contact Information',
                'contact_form_heading' => 'Send us a message',
                'contact_form_submit_label' => 'Send Message',
                'contact_address_label' => 'Our address',
                'contact_email_label' => 'Our emails',
                'contact_phone_label' => 'Call us today',
                'contact_back_label' => 'Back to Home',
                'contact_first_name_label' => 'First Name',
                'contact_last_name_label' => 'Last Name',
                'contact_email_input_label' => 'Email Address',
                'contact_subject_label' => 'Subject',
                'contact_message_label' => 'Message',
                'contact_first_name_placeholder' => 'John',
                'contact_last_name_placeholder' => 'Doe',
                'contact_email_placeholder' => 'john@example.com',
                'contact_subject_placeholder' => 'How can we help you?',
                'contact_message_placeholder' => 'Write your message here...',
                'project_prompt' => 'Have a project for us?',
                'lets_talk_label' => "Let's Talk",
                'footer_description' => 'Enhance your online presence with Sarab. Specializing in web and app development, we create seamless, innovative solutions to shape your digital success story together.',
                'footer_links_heading' => 'Social Links',
                'footer_terms_label' => 'Terms and conditions',
                'footer_privacy_label' => 'Privacy Policy',
                'footer_refund_label' => 'Refund & Dispute Policy',
                'footer_cancellation_label' => 'Cancelation Policy',
                'footer_promotions_label' => 'Terms & Conditions of Any Promotions',
                'footer_security_label' => 'Security Policy',
                'hero_scroll_label' => 'Scroll to explore',
                'about_section_label' => 'About Sarab',
                'customers_section_label' => 'Our Customers',
                'services_section_label' => 'Our Services',
                'services_section_title' => 'What We Do',
                'figures_section_label' => 'Sarab in numbers',
                'figures_section_title' => 'Our Impact',
                'figures_section_description' => 'Over the years we have done many things that we are proud of. This motivates us to continue looking for new challenges in order to improve our services.',
                'portfolio_section_label' => 'Our premium projects',
                'portfolio_section_title' => 'Selected Works',
                'portfolio_view_details_label' => 'View Details',
                'blog_section_label' => 'Blog',
                'blog_section_title' => 'Blog',
                'blog_section_description' => 'Shaping your digital success story together.',
                'blog_back_label' => 'Back to Blog',
                'blog_read_more_label' => 'Read more',
                'blog_more_title' => 'More articles',
                'blog_more_description' => 'Keep exploring our latest insights, stories, and product thinking.',
                'blog_cta_label' => 'Read more',
                'contact_cta_title' => 'How can we help?',
                'contact_cta_description' => "Ready to build something extraordinary? Let's talk about your next project.",
                'contact_cta_button_label' => 'Contact Us',
                'facebook_url' => 'https://www.facebook.com/sarabtechllc/',
                'twitter_url' => '#',
                'instagram_url' => '#',
                'linkedin_url' => '#',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3592.885065096522!2d-80.19827602380584!3d25.76632331080786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b684f8806209%3A0x6b490d1f76f4142!2s175%20SW%207th%20St%20%231517%2C%20Miami%2C%20FL%2033130!5e0!3m2!1sen!2sus!4v1709845612345!5m2!1sen!2sus',
            ],
        );

        return new SiteSettingResource($settings);
    }
}
