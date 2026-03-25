import React from 'react';
import LegalPage from './LegalPage';

export default function CancellationPolicy() {
  return (
    <LegalPage title="Cancellation Policy">
      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Subscription Services:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Cancellation:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>You can cancel your subscription at any time.</li>
        <li>Cancellations must be made before the end of the current billing period to avoid subscription renewal.</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Project Payments (e.g., Deposits for Websites and Apps):</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Deposits:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Clients may be required to pay a deposit to initiate a website or app development project.</li>
        <li>Deposits are non-refundable once work has commenced.</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Cancellation Process:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Initiating Cancellation:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Clients must initiate cancellations by contacting our customer support team.</li>
        <li>Cancellation requests are recommended to be made early to avoid potential fees or commitments.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Response to Cancellation:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Cancellation requests will be responded to promptly.</li>
        <li>Avoidance of cancellation fees is possible if cancellations are made before the commencement of work.</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">More about Cancellation:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Cancellation Confirmation:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>A confirmation of the cancellation will be sent via email.</li>
        <li>It's important to verify the confirmation to ensure the completion of the cancellation process.</li>
      </ul>
    </LegalPage>
  );
}
