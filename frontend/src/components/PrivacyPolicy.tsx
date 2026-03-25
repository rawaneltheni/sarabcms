import React from 'react';
import LegalPage from './LegalPage';

export default function PrivacyPolicy() {
  return (
    <LegalPage title="Privacy Policy">
      <p>Last Updated: February 2026</p>

      <p>This Privacy Policy explains how Sarab.tech ("we", "us", or "our") collects, uses, discloses, and protects personal data across all of its products, platforms, applications, APIs, websites, and services (collectively, the "Services").</p>

      <p>By accessing or using any Sarab.tech Service, you acknowledge that you have read, understood, and agree to the practices described in this Privacy Policy.</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">1. Scope of This Policy</h3>
      <p>This Policy applies to all Sarab.tech offerings, including but not limited to:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>SmartBank (mobile, web, and backend platforms)</li>
        <li>SmartBot (WhatsApp and messaging-based banking and service bots)</li>
        <li>SmartPay (QR, SMS, and merchant payment services)</li>
        <li>SmartATM (cardless and OTP-based ATM services)</li>
        <li>SmartAdmin, SmartAnalytics, SmartDesk, SmartStore, SmartOnboarding</li>
        <li>APIs, SDKs, dashboards, and administrative tools</li>
        <li>Corporate websites, landing pages, and marketing platforms</li>
      </ul>
      <p>Where a specific service requires additional or different privacy terms (e.g., bank-mandated disclosures), those terms will supplement this Policy.</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">2. Data We Collect</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">2.1 Personal Data You Provide</h4>
      <p>Depending on the Service, we may collect:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>Full name (Arabic and/or English)</li>
        <li>National ID or passport number (where required by law)</li>
        <li>Date and place of birth</li>
        <li>Phone number(s)</li>
        <li>Email address</li>
        <li>Residential and mailing address</li>
        <li>Bank account identifiers (e.g., account number, IBAN)</li>
        <li>Business information (company name, registration number, tax ID)</li>
        <li>Authentication data (PINs, OTPs, device binding tokens)</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">2.2 Automatically Collected Data</h4>
      <p>When you use our Services, we may automatically collect:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>Device information (model, OS, app version)</li>
        <li>IP address and approximate location</li>
        <li>Log data (timestamps, access logs, error logs)</li>
        <li>Usage data (features used, transaction counts, interaction flow)</li>
        <li>Cookies and similar tracking technologies (for web services)</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">2.3 Financial and Transactional Data</h4>
      <p>Subject to banking and regulatory requirements, we may process:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>Transaction metadata (amount, currency, timestamp, channel)</li>
        <li>Payment references and merchant identifiers</li>
        <li>Wallet or virtual account activity</li>
        <li>Messaging interaction metadata (not message content unless required)</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">2.4 Data from Third Parties</h4>
      <p>We may receive data from:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>Partner banks and financial institutions</li>
        <li>Payment processors and card networks</li>
        <li>Messaging platforms (e.g., WhatsApp Cloud API)</li>
        <li>Identity verification and compliance providers</li>
        <li>Regulators and lawful authorities</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">3. How We Use Data</h3>
      <p>We use personal data strictly for legitimate business and regulatory purposes, including:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>Providing, operating, and maintaining our Services</li>
        <li>Identity verification (KYC), AML, PEP, and fraud prevention</li>
        <li>Processing transactions and service requests</li>
        <li>Enabling secure authentication and authorization</li>
        <li>Regulatory reporting and audit requirements</li>
        <li>Customer support and service communications</li>
        <li>System monitoring, analytics, and performance optimization</li>
        <li>Product improvement and feature development</li>
      </ul>
      <p>We do not sell personal data.</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">4. Legal Bases for Processing</h3>
      <p>We process personal data under one or more of the following legal bases:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>Performance of a contract</li>
        <li>Compliance with legal or regulatory obligations</li>
        <li>Legitimate interests (security, fraud prevention, service improvement)</li>
        <li>User consent (where explicitly required)</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">5. Data Sharing and Disclosure</h3>
      <p>We may share data only with:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>Partner banks and licensed financial institutions</li>
        <li>Infrastructure and cloud service providers</li>
        <li>Messaging and communication platforms</li>
        <li>Compliance, audit, and risk management partners</li>
        <li>Regulators, courts, or law enforcement when legally required</li>
      </ul>
      <p>All third parties are contractually bound to confidentiality, data protection, and security obligations.</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">6. Data Localization and Cross-Border Transfers</h3>
      <p>Data may be processed or stored in jurisdictions outside the user’s country, subject to:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>Bank and regulator approvals</li>
        <li>Adequate data protection safeguards</li>
        <li>Encryption and access control standards</li>
      </ul>
      <p>Where required, data is hosted locally or within approved geographic boundaries.</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">7. Data Retention</h3>
      <p>We retain personal data only for as long as necessary to:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>Fulfill contractual and service obligations</li>
        <li>Meet legal, regulatory, and audit requirements</li>
        <li>Resolve disputes and enforce agreements</li>
      </ul>
      <p>Retention periods are defined by applicable banking laws and regulatory directives.</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">8. Security Measures</h3>
      <p>Sarab.tech implements industry-grade security controls, including:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>End-to-end encryption (data in transit and at rest)</li>
        <li>Role-based access control (RBAC)</li>
        <li>Network firewalls and WAF protection</li>
        <li>Audit logs and continuous monitoring</li>
        <li>Secure key management and credential rotation</li>
        <li>Regular security testing and reviews</li>
      </ul>
      <p>Despite our efforts, no system can be guaranteed 100% secure.</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">9. User Rights</h3>
      <p>Subject to applicable law, users may have the right to:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>Access their personal data</li>
        <li>Request correction or updates</li>
        <li>Request deletion (where legally permissible)</li>
        <li>Object to or restrict processing</li>
        <li>Withdraw consent (where applicable)</li>
      </ul>
      <p>Requests are subject to identity verification and regulatory constraints.</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">10. Children’s Data</h3>
      <p>Our Services are not intended for individuals under the age of 18 unless explicitly authorized by a licensed bank and permitted by law.</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">11. Cookies and Tracking (Web Services)</h3>
      <p>We use cookies and similar technologies to:</p>
      <ul className="list-disc pl-6 space-y-2">
        <li>Enable core website functionality</li>
        <li>Improve performance and user experience</li>
        <li>Analyze traffic and usage patterns</li>
      </ul>
      <p>Users may manage cookie preferences through their browser settings.</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">12. Changes to This Policy</h3>
      <p>We may update this Privacy Policy from time to time. Changes will be effective upon publication, with the updated date reflected at the top of this document.</p>
      <p>Continued use of the Services constitutes acceptance of the updated Policy.</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">13. Contact Information</h3>
      <p>For privacy-related inquiries, requests, or complaints, contact:</p>
      <p>Sarab.tech – Privacy & Compliance Office<br/>
      Email: info@sarab.tech<br/>
      Website: https://sarab.tech</p>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">14. Governing Law</h3>
      <p>This Privacy Policy is governed by applicable laws and regulations in the jurisdictions in which Sarab.tech operates, including relevant banking, data protection, and regulatory frameworks.</p>
    </LegalPage>
  );
}
