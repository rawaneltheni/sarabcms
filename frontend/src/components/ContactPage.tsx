import React from 'react';
import { useTranslation } from 'react-i18next';
import { Link } from 'react-router-dom';
import { ArrowLeft, Phone, Mail, MapPin, Send } from 'lucide-react';
import Header from './Header';
import Footer from './Footer';

export default function ContactPage() {
  const { t, i18n } = useTranslation();

  return (
    <div className="page-shell min-h-screen font-sans selection:bg-cyan-500/30" dir={i18n.language === 'ar' ? 'rtl' : 'ltr'}>
      <Header />
      
      <div className="pt-32 pb-24 px-6 max-w-6xl mx-auto relative z-20">
        <Link 
          to="/" 
          className="muted-text inline-flex items-center gap-2 hover:text-cyan-400 transition-colors mb-8 font-medium"
        >
          <ArrowLeft size={20} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
          {i18n.language === 'ar' ? 'العودة للرئيسية' : 'Back to Home'}
        </Link>

        <div className="text-center mb-16">
          <h1 className="text-4xl md:text-6xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">
            {i18n.language === 'ar' ? 'اتصل بنا' : 'Contact Us'}
          </h1>
          <p className="muted-text text-xl max-w-2xl mx-auto">
            {i18n.language === 'ar' 
              ? 'نحن هنا لمساعدتك. تواصل معنا لأي استفسار أو طلب.' 
              : 'We are here to help. Reach out to us for any inquiries or requests.'}
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">
          {/* Contact Information */}
          <div className="space-y-12">
            <div>
              <h3 className="text-2xl font-semibold mb-8 border-b border-[var(--border-subtle)] pb-4">
                {i18n.language === 'ar' ? 'معلومات التواصل' : 'Contact Information'}
              </h3>
              
              <div className="space-y-8">
                <div className="flex items-start gap-6">
                  <div className="w-12 h-12 rounded-full bg-cyan-500/10 flex items-center justify-center shrink-0">
                    <Phone className="text-cyan-400" size={24} />
                  </div>
                  <div>
                    <h4 className="soft-text text-lg font-medium mb-1">
                      {i18n.language === 'ar' ? 'اتصل بنا اليوم' : 'Call us today'}
                    </h4>
                    <a href="tel:+12029984099" className="text-xl font-semibold hover:text-cyan-400 transition-colors" dir="ltr">
                      +1(202)9984099
                    </a>
                  </div>
                </div>

                <div className="flex items-start gap-6">
                  <div className="w-12 h-12 rounded-full bg-cyan-500/10 flex items-center justify-center shrink-0">
                    <Mail className="text-cyan-400" size={24} />
                  </div>
                  <div>
                    <h4 className="soft-text text-lg font-medium mb-1">
                      {i18n.language === 'ar' ? 'البريد الإلكتروني' : 'Our emails'}
                    </h4>
                    <a href="mailto:info@sarab.tech" className="text-xl font-semibold hover:text-cyan-400 transition-colors">
                      info@sarab.tech
                    </a>
                  </div>
                </div>

                <div className="flex items-start gap-6">
                  <div className="w-12 h-12 rounded-full bg-cyan-500/10 flex items-center justify-center shrink-0">
                    <MapPin className="text-cyan-400" size={24} />
                  </div>
                  <div>
                    <h4 className="soft-text text-lg font-medium mb-1">
                      {i18n.language === 'ar' ? 'عنواننا' : 'Our address'}
                    </h4>
                    <p className="muted-text text-lg leading-relaxed" dir="ltr">
                      175 SW 7th Street, Suite 1517 - 1197,<br />
                      Miami, Florida 33130
                    </p>
                  </div>
                </div>
              </div>
            </div>

            {/* Google Map */}
            <div className="map-surface rounded-2xl overflow-hidden border h-[300px] relative">
              <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3592.885065096522!2d-80.19827602380584!3d25.76632331080786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b684f8806209%3A0x6b490d1f76f4142!2s175%20SW%207th%20St%20%231517%2C%20Miami%2C%20FL%2033130!5e0!3m2!1sen!2sus!4v1709845612345!5m2!1sen!2sus" 
                width="100%" 
                height="100%" 
                style={{ border: 0 }} 
                allowFullScreen={false} 
                loading="lazy" 
                referrerPolicy="no-referrer-when-downgrade"
                title="Sarab.tech Office Location"
                className="absolute inset-0"
              ></iframe>
            </div>
          </div>

          {/* Contact Form */}
          <div className="form-surface rounded-3xl p-8 md:p-12 backdrop-blur-sm border">
            <h3 className="text-2xl font-semibold mb-8">
              {i18n.language === 'ar' ? 'أرسل لنا رسالة' : 'Send us a message'}
            </h3>
            
            <form className="space-y-6" onSubmit={(e) => e.preventDefault()}>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div className="space-y-2">
                  <label htmlFor="firstName" className="muted-text text-sm font-medium">
                    {i18n.language === 'ar' ? 'الاسم الأول' : 'First Name'}
                  </label>
                  <input 
                    type="text" 
                    id="firstName" 
                    className="input-surface w-full border rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all"
                    placeholder={i18n.language === 'ar' ? 'أدخل اسمك الأول' : 'John'}
                  />
                </div>
                <div className="space-y-2">
                  <label htmlFor="lastName" className="muted-text text-sm font-medium">
                    {i18n.language === 'ar' ? 'اسم العائلة' : 'Last Name'}
                  </label>
                  <input 
                    type="text" 
                    id="lastName" 
                    className="input-surface w-full border rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all"
                    placeholder={i18n.language === 'ar' ? 'أدخل اسم العائلة' : 'Doe'}
                  />
                </div>
              </div>

              <div className="space-y-2">
                <label htmlFor="email" className="muted-text text-sm font-medium">
                  {i18n.language === 'ar' ? 'البريد الإلكتروني' : 'Email Address'}
                </label>
                <input 
                  type="email" 
                  id="email" 
                  className="input-surface w-full border rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all"
                  placeholder="john@example.com"
                  dir="ltr"
                />
              </div>

              <div className="space-y-2">
                <label htmlFor="subject" className="muted-text text-sm font-medium">
                  {i18n.language === 'ar' ? 'الموضوع' : 'Subject'}
                </label>
                <input 
                  type="text" 
                  id="subject" 
                  className="input-surface w-full border rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all"
                  placeholder={i18n.language === 'ar' ? 'كيف يمكننا مساعدتك؟' : 'How can we help you?'}
                />
              </div>

              <div className="space-y-2">
                <label htmlFor="message" className="muted-text text-sm font-medium">
                  {i18n.language === 'ar' ? 'الرسالة' : 'Message'}
                </label>
                <textarea 
                  id="message" 
                  rows={5}
                  className="input-surface w-full border rounded-xl px-4 py-3 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all resize-none"
                  placeholder={i18n.language === 'ar' ? 'اكتب رسالتك هنا...' : 'Write your message here...'}
                ></textarea>
              </div>

              <button 
                type="submit"
                className="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold py-4 rounded-xl hover:opacity-90 transition-opacity flex items-center justify-center gap-2 mt-4"
              >
                <Send size={20} className={i18n.language === 'ar' ? 'rotate-180' : ''} />
                {i18n.language === 'ar' ? 'إرسال الرسالة' : 'Send Message'}
              </button>
            </form>
          </div>
        </div>
      </div>

      <Footer />
    </div>
  );
}
