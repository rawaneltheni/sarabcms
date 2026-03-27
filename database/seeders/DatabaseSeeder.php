<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\BlogPost;
use App\Models\Customer;
use App\Models\Home;
use App\Models\LegalPage;
use App\Models\PageBlock;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::where('email', 'sarab@gmail.com')->delete();
        User::create([
            'name' => 'Sarab',
            'email' => 'sarab@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        DB::table('home_sliders')->delete();
        DB::table('services')->delete();
        DB::table('stats')->delete();
        DB::table('abouts')->delete();
        DB::table('projects')->delete();
        DB::table('blog_posts')->delete();
        DB::table('customers')->delete();
        DB::table('legal_pages')->delete();
        DB::table('page_blocks')->delete();

        Home::create([
            'image' => null,
            'h1' => 'Seeking',
            'h2' => 'digital solutions?',
            'body' => 'Are you looking for Digital Transformation, sarab is a Tech Company Established with one purpose: to help you define your brand. We offer impeccable service combining a nice and user-friendly designs with quality programming.',
            'btn_text' => 'Get in touch',
            'btn_link' => '/contact',
            'order' => 1,
        ]);

        About::create([
            'heading1' => 'About the',
            'heading2' => 'company.',
            'description' => 'Sarab is a software development company founded in 2021. We help IT and non-IT organizations achieve their goals with practical digital solutions and modern technologies.',
            'features' => [
                'Chatbots are your 24/7 marketing ally with engaging and user-friendly conversations.',
                'AI-driven logic and seamless coding help create efficient customer experiences.',
                'Showcase your offerings with adaptable, hassle-free, and versatile digital solutions.',
            ],
        ]);

        Service::insert([
            [
                'order' => 1,
                'icon' => 'fa fa-code',
                'title' => 'Web Development',
                'description' => 'Web development is the creation of websites and web applications, encompassing design, coding, and functionality to provide an engaging online experience for users.',
                'image' => null,
                'url' => '/contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 2,
                'icon' => 'fa fa-mobile-screen',
                'title' => 'App development',
                'description' => 'Sarab provides custom mobile app development services that help increase sales and strengthen customer loyalty through stable, interactive, high-performance experiences.',
                'image' => null,
                'url' => '/contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 3,
                'icon' => 'fa fa-comments',
                'title' => 'Chatbots - rodood platform',
                'description' => 'Chatbots are a very useful tool for business to automate customer service operations',
                'image' => null,
                'url' => 'https://rodood.ly',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 4,
                'icon' => 'fa fa-hand-holding-dollar',
                'title' => 'CrowdFunding',
                'description' => 'Crowdfunding is raising funds online from a large number of people to support projects, ventures, or causes.',
                'image' => null,
                'url' => '/contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 5,
                'icon' => 'fa fa-chalkboard-user',
                'title' => 'Training and Consulting',
                'description' => 'Sarab offers comprehensive training and consulting services, empowering trainees with valuable knowledge and effective strategies for success in their fields.',
                'image' => null,
                'url' => '/contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Stat::insert([
            [
                'order' => 1,
                'icon' => 'fa fa-users',
                'number' => '250',
                'label' => 'Happy Customers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 2,
                'icon' => 'fa fa-graduation-cap',
                'number' => '50',
                'label' => 'trainees',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 3,
                'icon' => 'fa fa-chart-line',
                'number' => '2000000',
                'label' => 'Service Users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 4,
                'icon' => 'fa fa-folder-open',
                'number' => '25',
                'label' => 'Great Projects',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Project::insert([
            [
                'image_path' => null,
                'title' => 'WABS',
                'slug' => 'wabs',
                'category' => 'App',
                'description' => 'WABS is a WhatsApp banking solution that helps bank customers receive updates and access essential services through a familiar messaging experience.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => null,
                'category' => 'App',
                'title' => 'Smart Bank',
                'slug' => 'smart-bank',
                'description' => 'Smart Bank is a digital banking platform built to give financial institutions a secure, user-friendly experience for everyday customer operations.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        BlogPost::insert([
            [
                'title' => 'The Role of APIs in Web Application Development',
                'slug' => 'the-role-of-apis-in-web-application-development',
                'excerpt' => 'Web APIs play a major role in modern web application development by helping systems connect, scale, and exchange data more effectively.',
                'date' => '2021-03-14',
                'image' => null,
                'content' => <<<HTML
<p>Building web applications involves creating software that works on the internet and can be accessed through web browsers. These applications can be as simple as websites or as complex as systems that help businesses or groups. A big reason for the progress in web app development is the increased use of web APIs.</p>
<p>APIs help different systems communicate with each other in a structured way. In web application development, they support faster integrations, clearer system boundaries, and more scalable product design.</p>
<p>This post was imported from the public Sarab Tech blog and can now be edited in Filament.</p>
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mobile Apps vs Web Apps - What Suit Your Business Needs?',
                'slug' => 'mobile-apps-vs-web-apps-what-suit-your-business-needs',
                'excerpt' => 'Choosing between a mobile app and a web app depends on your audience, goals, budget, and the experience your business needs to deliver.',
                'date' => '2021-03-14',
                'image' => null,
                'content' => <<<HTML
<p>In the digital age, businesses have a critical decision to make when it comes to their online presence: should they invest in a mobile app, a web app, or both? With consumers relying heavily on their smartphones and tablets for various activities, the debate between mobile apps and web apps has become increasingly important.</p>
<p>Each option has its own set of advantages and considerations, making it essential for businesses to understand their specific requirements before making a choice.</p>
<p>This post was imported from the public Sarab Tech blog listing and can now be expanded or refined in Filament.</p>
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '6 Ways to Run an Effective Client Meeting',
                'slug' => '6-ways-to-run-an-effective-client-meeting',
                'excerpt' => 'Effective client meetings build trust, create clarity, and help shape stronger working relationships from the very beginning.',
                'date' => '2021-03-14',
                'image' => null,
                'content' => <<<HTML
<p>Whether you are a business owner, salesperson, manager, engineer, or designer, client meetings allow you to build credibility and trust with prospects, current customers and leads. Learning how to plan, mediate and prepare for an effective client meeting is a great way to set yourself apart from others, create a strong impression, and initiate an excellent working relationship.</p>
<p>To help you out, we have compiled a list of six ways to run effective client meetings.</p>
<h2>Research the Client</h2>
<p>Before the meeting, take some time to research all attendees, especially the main decision-maker. This helps you be ready and well-prepared, so nothing important gets missed.</p>
<h2>Define the Purpose of the Meeting</h2>
<p>Client meetings may be introductory, consultation-based, proposal-focused, or check-in meetings. Defining the purpose of the meeting beforehand helps align expectations and shape the right agenda.</p>
<h2>Create the Perfect Conditions</h2>
<p>No matter how well prepared you are, you cannot run a successful client meeting if you fail to set the right environment. Comfort, timing, atmosphere, and preparation all matter.</p>
<h2>Create an Agenda and Be Prepared to Answer Questions</h2>
<p>Having a clear and focused meeting agenda helps both sides know what to expect and keeps the conversation on track from beginning to end.</p>
<h2>Always Have a Wrap-Up Plan</h2>
<p>As important as it is to have a meeting agenda beforehand, it is equally important to have a closing plan so the meeting ends on a solid note.</p>
<h2>Don't Forget to Follow Up</h2>
<p>Staying in touch with your client after a meeting or throughout the project ensures that both you and the client remain aligned. Open communication builds trust and reduces confusion.</p>
<p>Managing and mapping an effective client meeting is a demanding process that requires in-depth knowledge of the project and the client you are working with.</p>
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        LegalPage::insert([
            [
                'slug' => 'terms',
                'title' => 'Terms and Conditions',
                'content' => <<<HTML
<p>Terms of service are the legal agreements between a service provider and a person who wants to use that service. The person must agree to abide by the terms of service in order to use the offered service.</p>
<p>A terms of service agreement typically contains sections covering user rights and responsibilities, proper use, privacy, payments, dispute handling, and limitations of liability.</p>
<ul>
<li>User rights and responsibilities</li>
<li>Acceptable use and misuse definitions</li>
<li>Privacy and personal data practices</li>
<li>Fees, subscriptions, and billing terms</li>
<li>Termination and dispute resolution</li>
<li>Liability limitations and disclaimers</li>
</ul>
<p>This page was seeded from the previous Sarab frontend content and can be fully edited in Filament.</p>
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'privacy',
                'title' => 'Privacy Policy',
                'content' => <<<HTML
<p>Last Updated: February 2026</p>
<p>This Privacy Policy explains how Sarab.tech collects, uses, discloses, and protects personal data across its products, platforms, applications, APIs, websites, and services.</p>
<h2>Scope of This Policy</h2>
<p>This policy applies to Sarab.tech offerings including apps, dashboards, APIs, websites, onboarding systems, and related service platforms.</p>
<h2>Data We Collect</h2>
<ul>
<li>Personal information you provide, such as names, phone numbers, and email addresses</li>
<li>Automatically collected device, usage, and log information</li>
<li>Transactional and service interaction data where applicable</li>
</ul>
<h2>How We Use Data</h2>
<ul>
<li>To provide and maintain services</li>
<li>To support security, fraud prevention, and compliance</li>
<li>To improve product quality and customer support</li>
</ul>
<h2>Security Measures</h2>
<p>Sarab.tech applies encryption, access controls, monitoring, and regular security reviews to protect data.</p>
<h2>Contact Information</h2>
<p>Email: info@sarab.tech<br>Website: https://sarab.tech</p>
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'refund',
                'title' => 'Refund & Dispute Policy',
                'content' => <<<HTML
<h2>Subscription Services</h2>
<ul>
<li>Clients are responsible for renewing subscriptions before the end of each billing period.</li>
<li>Refunds for the current billing period are generally not provided once services are paid in advance.</li>
<li>Exceptions may be considered for critical issues affecting service usability.</li>
</ul>
<h2>Project Payments</h2>
<ul>
<li>Deposits for websites and app development projects may be required.</li>
<li>Deposit payments are non-refundable once work has commenced.</li>
</ul>
<h2>Dispute Resolution</h2>
<ul>
<li>Clients should first contact customer support to attempt resolution.</li>
<li>We aim to reach a fair resolution within 30 days of receiving the dispute.</li>
<li>Unjustified chargebacks may result in service suspension.</li>
</ul>
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'cancellation',
                'title' => 'Cancellation Policy',
                'content' => <<<HTML
<h2>Subscription Services</h2>
<ul>
<li>You can cancel your subscription at any time.</li>
<li>Cancellations should be made before the end of the current billing period to avoid renewal.</li>
</ul>
<h2>Project Deposits</h2>
<ul>
<li>Clients may be required to pay a deposit to initiate website or app development work.</li>
<li>Deposits are non-refundable once work has commenced.</li>
</ul>
<h2>Cancellation Process</h2>
<ul>
<li>Clients must initiate cancellations by contacting customer support.</li>
<li>A confirmation of cancellation should be provided by email.</li>
</ul>
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'promotions',
                'title' => 'Terms & Conditions of Any Promotions',
                'content' => <<<HTML
<h2>Eligibility and Duration</h2>
<ul>
<li>Promotions are open to current and new customers of Sarab Tech.</li>
<li>Each promotion may have its own validity period and conditions.</li>
</ul>
<h2>Promotion Guidelines</h2>
<ul>
<li>Specific discount details and offer rules are defined per promotion.</li>
<li>Some promotions may require a code or a qualifying purchase.</li>
</ul>
<h2>General Terms</h2>
<ul>
<li>Sarab reserves the right to modify or cancel promotions without prior notice.</li>
<li>Sarab is not liable for issues arising from misuse of promotional offers.</li>
</ul>
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'security',
                'title' => 'Security Capabilities and Policy for Payment Card Details Transmission',
                'content' => <<<HTML
<h2>Security Measures</h2>
<ul>
<li>Payment card details transmission is secured using SSL encryption.</li>
<li>Tokenization is used to reduce exposure of sensitive card data.</li>
<li>Firewall protection, encryption, and access controls are enforced.</li>
</ul>
<h2>Operational Policy</h2>
<ul>
<li>Only authorized personnel may handle payment card details.</li>
<li>Monitoring and auditing are conducted to detect suspicious activity.</li>
<li>Processes are aligned with PCI DSS principles and incident response planning.</li>
</ul>
<h2>Consumer Data Privacy</h2>
<ul>
<li>Consumer data is collected only for business and service purposes.</li>
<li>Stored data is protected through secure storage and controlled access.</li>
<li>Data is not disclosed to third parties without consent except when required by law or service delivery.</li>
</ul>
HTML,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        PageBlock::insert([
            [
                'page' => 'home',
                'key' => 'hero',
                'eyebrow' => 'Sarab Tech',
                'title' => 'Seeking',
                'subtitle' => 'digital solutions?',
                'description' => 'Are you looking for digital transformation? Sarab helps brands define their identity through thoughtful products, useful technology, and polished execution.',
                'cta_label' => 'Get in touch',
                'cta_url' => '/contact',
                'secondary_cta_label' => null,
                'secondary_cta_url' => null,
                'meta' => json_encode([]),
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page' => 'home',
                'key' => 'about',
                'eyebrow' => 'About Sarab',
                'title' => 'About the',
                'subtitle' => 'company.',
                'description' => 'Sarab is a software development company founded in 2021. We help organizations turn ambitious ideas into practical digital products and customer-facing experiences.',
                'cta_label' => null,
                'cta_url' => null,
                'secondary_cta_label' => null,
                'secondary_cta_url' => null,
                'meta' => json_encode([
                    'feature_1' => 'Chatbots are your 24/7 marketing ally with engaging conversations.',
                    'feature_2' => 'AI-driven logic and seamless coding improve customer experiences.',
                    'feature_3' => 'Versatile digital solutions help you present your brand clearly.',
                ]),
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page' => 'home',
                'key' => 'services',
                'eyebrow' => 'How can we help?',
                'title' => 'Digital products built for modern brands.',
                'subtitle' => null,
                'description' => 'Sarab combines product thinking, development, and automation to help businesses launch services that feel clear, useful, and scalable.',
                'cta_label' => null,
                'cta_url' => null,
                'secondary_cta_label' => null,
                'secondary_cta_url' => null,
                'meta' => json_encode([]),
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page' => 'home',
                'key' => 'stats',
                'eyebrow' => 'Sarab in numbers',
                'title' => 'Our Impact',
                'subtitle' => null,
                'description' => 'Over the years we have done many things that we are proud of. This keeps us looking for new challenges and better ways to improve our services.',
                'cta_label' => null,
                'cta_url' => null,
                'secondary_cta_label' => null,
                'secondary_cta_url' => null,
                'meta' => json_encode([]),
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page' => 'home',
                'key' => 'portfolio',
                'eyebrow' => 'Selected works',
                'title' => 'Our premium projects.',
                'subtitle' => null,
                'description' => 'A small selection of digital products and platforms from the Sarab portfolio.',
                'cta_label' => null,
                'cta_url' => null,
                'secondary_cta_label' => null,
                'secondary_cta_url' => null,
                'meta' => json_encode([]),
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page' => 'home',
                'key' => 'blog',
                'eyebrow' => 'Blog posts',
                'title' => 'Our latest news.',
                'subtitle' => null,
                'description' => 'The latest ideas, articles, and updates from Sarab Tech.',
                'cta_label' => 'Load more',
                'cta_url' => '/blog',
                'secondary_cta_label' => null,
                'secondary_cta_url' => null,
                'meta' => json_encode([]),
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page' => 'home',
                'key' => 'contact_cta',
                'eyebrow' => 'Ready to do this',
                'title' => "Let's get to work",
                'subtitle' => null,
                'description' => 'Whether you need a web app, mobile app, chatbot, or custom build, we can help shape the next step.',
                'cta_label' => 'Get the offer',
                'cta_url' => '/contact',
                'secondary_cta_label' => null,
                'secondary_cta_url' => null,
                'meta' => json_encode([]),
                'order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        SiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Sarab Tech',
                'address' => '175 SW 7th Street, Suite 1517 - 1197, Miami, Florida 33130',
                'header_home_label' => 'Home',
                'header_about_label' => 'About us',
                'header_services_label' => 'Pricing',
                'header_portfolio_label' => 'Portfolio',
                'header_blog_label' => 'Blog',
                'contact_email' => 'info@sarab.tech',
                'contact_phone' => '+1(202)9984099',
                'contact_heading' => 'Contact us',
                'contact_description' => 'Whether you need a new web or mobile app, chatbot, or custom solution for your specific need created for your business, give us a call!',
                'contact_information_heading' => 'Where we are',
                'contact_form_heading' => 'Send us a message',
                'contact_form_submit_label' => 'Submit',
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
                'contact_subject_placeholder' => 'Tell us about your project',
                'contact_message_placeholder' => 'Write your message here...',
                'project_prompt' => 'Have a project for us?',
                'lets_talk_label' => "Let's Talk",
                'footer_description' => 'Whether you need a new web or mobile app, chatbot, or custom solution for your specific need created for your business, give us a call!',
                'footer_links_heading' => 'Social Links',
                'footer_terms_label' => 'Terms and conditions',
                'footer_privacy_label' => 'Privacy Policy',
                'footer_refund_label' => 'Refund & Dispute Policy',
                'footer_cancellation_label' => 'Cancelation Policy',
                'footer_promotions_label' => 'Terms & Conditions of Any Promotions',
                'footer_security_label' => 'Security Policy',
                'facebook_url' => 'https://fb.me/sarabtechllc',
                'twitter_url' => 'https://twitter.com',
                'instagram_url' => 'https://www.instagram.com/sarabtechllc/',
                'linkedin_url' => 'https://www.linkedin.com',
                'map_embed_url' => 'https://www.google.com/maps?q=175%20SW%207th%20Street%2C%20Suite%201517%20-%201197%2C%20Miami%2C%20Florida%2033130&output=embed',
                'hero_scroll_label' => 'Scroll to explore',
                'about_section_label' => 'About Sarab',
                'customers_section_label' => 'Customers',
                'services_section_label' => 'How can we help?',
                'services_section_title' => 'Digital products built for modern brands.',
                'figures_section_label' => 'Sarab in numbers',
                'figures_section_title' => 'Our Impact',
                'figures_section_description' => 'Over the years we have done many things that we are proud of. This motivates us to continue looking for new challenges in order to improve our services.',
                'portfolio_section_label' => 'Selected works',
                'portfolio_section_title' => 'Our premium projects.',
                'portfolio_view_details_label' => 'View project',
                'blog_section_label' => 'Blog posts',
                'blog_section_title' => 'Our latest news.',
                'blog_section_description' => 'The latest ideas, articles, and updates from Sarab Tech.',
                'blog_back_label' => 'Back to Blog',
                'blog_read_more_label' => 'Load more',
                'blog_more_title' => 'Our latest news',
                'blog_more_description' => 'Keep exploring the latest articles and insights from Sarab Tech.',
                'blog_cta_label' => 'Get the offer',
                'contact_cta_title' => "Let's get to work",
                'contact_cta_description' => 'READY TO DO THIS',
                'contact_cta_button_label' => 'Get the offer',
            ],
        );

    }
}
