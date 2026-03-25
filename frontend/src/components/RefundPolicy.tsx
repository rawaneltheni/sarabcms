import React from 'react';
import LegalPage from './LegalPage';

export default function RefundPolicy() {
  return (
    <LegalPage title="Refund & Dispute Policy">
      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Subscription Services:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Payment and Renewal:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Clients are responsible for renewing their subscription by making timely payments before the end of each billing period.</li>
        <li>Services will continue based on successful payment; failure to renew may result in service suspension.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Refund for Subscription Services:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>As services are paid in advance and are not automatically renewed, refunds for the current billing period are generally not provided.</li>
        <li>Exceptions may be considered for critical issues affecting service usability. Refund requests must be made within 14 days of the payment date.</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Project Payments (e.g., Deposits for Websites and Apps):</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Deposit Payments:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Clients may be required to make deposits for website and app development projects.</li>
        <li>Deposit payments are non-refundable once work has commenced.</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Dispute Resolution Policy:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Dispute Initiation:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>In case of a dispute, clients must contact our customer support team to attempt resolution before pursuing external avenues.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Dispute Handling:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Our support team will thoroughly investigate all disputes.</li>
        <li>Clients must provide any requested information or documentation to facilitate the investigation.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Resolution Process:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>We will make every effort to reach a fair resolution within 30 days of receiving the dispute.</li>
        <li>If a resolution cannot be achieved, clients may explore alternative dispute resolution methods, such as mediation or arbitration.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Chargebacks:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Chargebacks should only be initiated after attempting to resolve the issue through our support team. Unjustified chargebacks may result in service suspension.</li>
      </ul>
    </LegalPage>
  );
}
