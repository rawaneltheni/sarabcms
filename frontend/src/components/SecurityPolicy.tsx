import React from 'react';
import LegalPage from './LegalPage';

export default function SecurityPolicy() {
  return (
    <LegalPage title="Security Capabilities and Policy for Payment Card Details Transmission">
      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Security Measures:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Secure Sockets Layer (SSL):</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>All payment card details transmission is secured using SSL encryption to ensure the confidentiality of data during transfer.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Tokenization:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Payment card information is tokenized, replacing sensitive data with unique tokens, reducing the risk of unauthorized access.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Firewall Protection:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Robust firewall systems are in place to monitor and control incoming and outgoing traffic, enhancing the overall security posture.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Data Encryption:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Advanced encryption algorithms are employed to safeguard payment card data, preventing unauthorized parties from deciphering the information.</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Policy for Payment Card Details Transmission:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Authorized Access:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Only authorized personnel with specific access rights are allowed to handle and transmit payment card details.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Monitoring and Auditing:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Regular monitoring and auditing of payment transactions are conducted to detect and address any suspicious activities promptly.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Compliance with PCI DSS:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Strict adherence to Payment Card Industry Data Security Standard (PCI DSS) guidelines to ensure the secure handling of payment card information.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Incident Response Plan:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>A comprehensive incident response plan is in place to address and mitigate any security incidents related to payment card details.</li>
      </ul>

      <h2 className="text-3xl font-bold text-white mt-12 mb-6">Consumer Data Privacy Policy</h2>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Data Collection and Usage:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Purpose of Data Collection:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Consumer data is collected for the sole purpose of facilitating transactions and providing personalized services.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Data Minimization:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Only essential consumer information required for business purposes is collected, adhering to the principle of data minimization.</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Data Protection Measures:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Secure Storage:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Consumer data is securely stored using industry-standard encryption methods to prevent unauthorized access.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Access Control:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Access to consumer data is restricted to authorized personnel, and stringent access controls are enforced.</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Privacy Assurance:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Non-Disclosure:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Consumer data is not disclosed to third parties without explicit consent, except where required by law or for service provision.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Opt-Out Options:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Consumers have the option to opt out of certain data collection practices, providing them with control over their privacy preferences.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Transparency:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Clear and transparent communication regarding data collection, usage, and privacy practices is provided to consumers.</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Compliance:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Legal Compliance:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>The consumer data privacy policy is aligned with relevant data protection laws and regulations to ensure legal compliance.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Continuous Review:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>The privacy policy undergoes regular reviews to adapt to evolving privacy standards and maintain consumer trust.</li>
      </ul>
    </LegalPage>
  );
}
