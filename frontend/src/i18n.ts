import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';

const resources = {
  en: {
    translation: {
      "header": {
        "title": "SARAB TECH",
        "home": "Home",
        "about": "About us",
        "portfolio": "Portfolio",
        "pricing": "Pricing",
        "blog": "Blog",
        "project_prompt": "Have a project for us?",
        "lets_talk": "Let's Talk",
        "address": "651 N Broad St, Middletown, DE 19709, USA"
      },
      "hero": {
        "title": "SARAB TECH",
        "subtitle": "Shaping your digital success story together.",
        "scroll": "Scroll to explore"
      },
      "about": {
        "subtitle": "About Sarab",
        "title_1": "Empowering Your",
        "title_2": "Success Journey.",
        "desc": "Enhance your online presence with Sarab. Specializing in web and app development, we create seamless, innovative solutions to shape your digital success story together.",
        "point_1": "Our expert team creates visually captivating and highly functional websites that make a lasting impact.",
        "point_2": "We develop cutting-edge mobile apps that deliver seamless experiences and cater to your specific needs.",
        "point_3": "Our top priority is exceptional customer service, ensuring your satisfaction every step of the way."
      },
      "customers": {
        "title": "Our Customers"
      },
      "services": {
        "subtitle": "Our Services",
        "title": "What We Do",
        "web_dev": "Web Development",
        "web_dev_desc": "Visually captivating and highly functional websites.",
        "app_dev": "App Development",
        "app_dev_desc": "Cutting-edge mobile apps that deliver seamless experiences.",
        "consulting": "Technical Consulting",
        "consulting_desc": "Strategic guidance for planning, scaling, and improving digital products."
      },
      "figures": {
        "subtitle": "Sarab in numbers",
        "title": "Our Impact",
        "desc": "Over the years we have done many things that we are proud of. This motivates us to continue looking for new challenges in order to improve our services.",
        "customers": "Happy Customers",
        "trainees": "Trainees",
        "users": "Service Users",
        "projects": "Great Projects"
      },
      "portfolio": {
        "subtitle": "Our premium projects",
        "title": "Selected Works",
        "view_details": "View Details"
      },
      "contact": {
        "title": "How can we help?",
        "desc": "Ready to build something extraordinary? Let's talk about your next project.",
        "button": "Contact Us"
      },
      "blog": {
        "subtitle": "Insights & Updates",
        "title": "From the Blog",
        "description": "Ideas, product notes, and practical insights from our work across web, mobile, and digital growth.",
        "cta": "Read more",
        "read_more": "Read more",
        "posts": {
          "1": {
            "category": "Web Development",
            "date": "Mar 12, 2026",
            "title": "What Makes a Business Website Actually Convert",
            "excerpt": "A beautiful interface is only part of the story. Here is how structure, speed, and clarity turn visits into inquiries."
          },
          "2": {
            "category": "Mobile Apps",
            "date": "Mar 5, 2026",
            "title": "Planning a Mobile App Without Wasting Budget",
            "excerpt": "The right launch plan starts with priorities. We break down how to scope an app around business value instead of feature overload."
          },
          "3": {
            "category": "Consulting",
            "date": "Feb 21, 2026",
            "title": "How Technical Strategy Saves Teams Time",
            "excerpt": "Strong technical direction helps teams avoid rework, reduce risk, and move faster with more confidence."
          }
        }
      },
      "projects": {
        "1": {
          "title": "E-Commerce Platform",
          "category": "Web Development",
          "desc": "A full-featured e-commerce platform with real-time inventory management, seamless payment gateway integration, and a responsive, mobile-first design."
        },
        "2": {
          "title": "Product Strategy Sprint",
          "category": "Consulting",
          "desc": "A focused discovery engagement that turns business goals into a clear roadmap, priorities, and execution plan."
        },
        "3": {
          "title": "Healthcare App",
          "category": "Mobile App",
          "desc": "A secure and intuitive mobile application for patients to book appointments, access medical records, and consult with doctors via telemedicine."
        },
        "4": {
          "title": "Fintech Dashboard",
          "category": "Web Application",
          "desc": "A comprehensive financial dashboard providing real-time analytics, transaction monitoring, and customizable reporting for enterprise clients."
        }
      },
      "modal": {
        "view_live": "View Live Project"
      },
      "footer": {
        "important_links": "Important Links",
        "terms": "Terms and conditions",
        "privacy": "Privacy Policy",
        "refund": "Refund & Dispute Policy",
        "cancelation": "Cancelation Policy",
        "promotions": "Terms & Conditions of Any Promotions",
        "security": "Security Policy"
      }
    }
  },
  ar: {
    translation: {
      "header": {
        "title": "سراب تك",
        "home": "الرئيسية",
        "about": "من نحن",
        "portfolio": "أعمالنا",
        "pricing": "الأسعار",
        "blog": "المدونة",
        "project_prompt": "هل لديك مشروع لنا؟",
        "lets_talk": "لنتحدث",
        "address": "651 N Broad St, Middletown, DE 19709, USA"
      },
      "hero": {
        "title": "سراب تك",
        "subtitle": "نشكل قصة نجاحك الرقمية معاً.",
        "scroll": "مرر للاستكشاف"
      },
      "about": {
        "subtitle": "عن سراب",
        "title_1": "تمكين رحلة",
        "title_2": "نجاحك.",
        "desc": "عزز تواجدك الرقمي مع سراب. نحن متخصصون في تطوير الويب والتطبيقات، ونبتكر حلولاً سلسة ومبتكرة لتشكيل قصة نجاحك الرقمية معاً.",
        "point_1": "يقوم فريق الخبراء لدينا بإنشاء مواقع ويب جذابة بصريًا وعالية الأداء تترك أثرًا دائمًا.",
        "point_2": "نطور تطبيقات هواتف محمولة متطورة تقدم تجارب سلسة وتلبي احتياجاتك الخاصة.",
        "point_3": "أولويتنا القصوى هي خدمة العملاء الاستثنائية، لضمان رضاك في كل خطوة."
      },
      "customers": {
        "title": "عملاؤنا"
      },
      "services": {
        "subtitle": "خدماتنا",
        "title": "ماذا نفعل",
        "web_dev": "تطوير الويب",
        "web_dev_desc": "مواقع ويب جذابة بصريًا وعالية الأداء.",
        "app_dev": "تطوير التطبيقات",
        "app_dev_desc": "تطبيقات هواتف محمولة متطورة تقدم تجارب سلسة.",
        "consulting": "الاستشارات التقنية",
        "consulting_desc": "إرشاد استراتيجي لتخطيط المنتجات الرقمية وتطويرها وتحسينها."
      },
      "figures": {
        "subtitle": "سراب في أرقام",
        "title": "تأثيرنا",
        "desc": "على مر السنين قمنا بالعديد من الأشياء التي نفخر بها. هذا يحفزنا على مواصلة البحث عن تحديات جديدة من أجل تحسين خدماتنا.",
        "customers": "عميل سعيد",
        "trainees": "متدرب",
        "users": "مستخدم للخدمات",
        "projects": "مشروع رائع"
      },
      "portfolio": {
        "subtitle": "مشاريعنا المميزة",
        "title": "أعمال مختارة",
        "view_details": "عرض التفاصيل"
      },
      "contact": {
        "title": "كيف يمكننا المساعدة؟",
        "desc": "هل أنت مستعد لبناء شيء استثنائي؟ لنتحدث عن مشروعك القادم.",
        "button": "اتصل بنا"
      },
      "blog": {
        "subtitle": "رؤى وتحديثات",
        "title": "من المدونة",
        "description": "أفكار وملاحظات عملية ورؤى من أعمالنا في الويب وتطبيقات الجوال والنمو الرقمي.",
        "cta": "اقرأ المزيد",
        "read_more": "اقرأ المزيد",
        "posts": {
          "1": {
            "category": "تطوير الويب",
            "date": "12 مارس 2026",
            "title": "ما الذي يجعل موقع الأعمال يحقق نتائج فعلية",
            "excerpt": "التصميم الجميل ليس كل شيء. إليك كيف تؤدي السرعة والوضوح وبنية المحتوى إلى تحويل الزيارات إلى استفسارات."
          },
          "2": {
            "category": "تطبيقات الجوال",
            "date": "5 مارس 2026",
            "title": "كيف تخطط لتطبيق جوال بدون هدر الميزانية",
            "excerpt": "تبدأ خطة الإطلاق الصحيحة من تحديد الأولويات. نشرح كيف يتم تحديد نطاق التطبيق حول قيمة العمل بدل تضخم الخصائص."
          },
          "3": {
            "category": "الاستشارات",
            "date": "21 فبراير 2026",
            "title": "كيف توفر الاستراتيجية التقنية الوقت على الفرق",
            "excerpt": "يساعد التوجيه التقني القوي الفرق على تقليل إعادة العمل وخفض المخاطر والتحرك بسرعة أكبر بثقة أعلى."
          }
        }
      },
      "projects": {
        "1": {
          "title": "منصة تجارة إلكترونية",
          "category": "تطوير الويب",
          "desc": "منصة تجارة إلكترونية متكاملة الميزات مع إدارة المخزون في الوقت الفعلي، وتكامل سلس لبوابة الدفع، وتصميم متجاوب يركز على الهاتف المحمول."
        },
        "2": {
          "title": "جلسة استراتيجية للمنتج",
          "category": "الاستشارات",
          "desc": "جلسة اكتشاف مركزة تحول أهداف العمل إلى خارطة طريق واضحة وأولويات عملية وخطة تنفيذ مناسبة."
        },
        "3": {
          "title": "تطبيق رعاية صحية",
          "category": "تطبيق هاتف",
          "desc": "تطبيق هاتف محمول آمن وبديهي للمرضى لحجز المواعيد، والوصول إلى السجلات الطبية، واستشارة الأطباء عبر التطبيب عن بعد."
        },
        "4": {
          "title": "لوحة تحكم التكنولوجيا المالية",
          "category": "تطبيق ويب",
          "desc": "لوحة تحكم مالية شاملة توفر تحليلات في الوقت الفعلي، ومراقبة المعاملات، وتقارير قابلة للتخصيص لعملاء المؤسسات."
        }
      },
      "modal": {
        "view_live": "عرض المشروع المباشر"
      },
      "footer": {
        "important_links": "روابط هامة",
        "terms": "الشروط والأحكام",
        "privacy": "سياسة الخصوصية",
        "refund": "سياسة الاسترجاع والمنازعات",
        "cancelation": "سياسة الإلغاء",
        "promotions": "شروط وأحكام أي عروض ترويجية",
        "security": "السياسة الأمنية"
      }
    }
  }
};

i18n
  .use(initReactI18next)
  .init({
    resources,
    lng: "en",
    fallbackLng: "en",
    interpolation: {
      escapeValue: false
    }
  });

export default i18n;
