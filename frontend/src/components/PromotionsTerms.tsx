import React from 'react';
import LegalPage from './LegalPage';

export default function PromotionsTerms() {
  return (
    <LegalPage title="Terms & Conditions of Any Promotions">
      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Eligibility and Duration:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Promotion Availability:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Promotions are open to all current and new customers of Sarab Tech Company.</li>
        <li>Customers must adhere to the specified terms and conditions of the promotions.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Validity Period:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Validity periods vary for each offer; please refer to the specific details to determine the time frame.</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">Promotion Guidelines:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Utilization Conditions:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Specific conditions may apply; customers must comply with them to benefit from the promotions.</li>
        <li>Please read the conditions carefully before taking advantage of the promotions.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Discount Details:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Discount details and offers are clearly specified in each offer.</li>
        <li>Some offers may require the use of specific discount codes during the purchase process.</li>
      </ul>

      <h3 className="text-2xl font-semibold text-white mt-8 mb-4">General Terms:</h3>
      
      <h4 className="text-xl font-medium text-white mt-6 mb-3">Modification or Cancellation of Promotions:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Sarab reserves the right to modify or cancel any promotion at any time without prior notice.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Responsibility:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Sarab is not liable for any issues or consequences arising from the use or benefit of the promotions.</li>
        <li>Customers bear full responsibility for the flexible use of the offers.</li>
      </ul>

      <h4 className="text-xl font-medium text-white mt-6 mb-3">Use of Promotion Information:</h4>
      <ul className="list-disc pl-6 space-y-2">
        <li>Sarab has the right to use details of promotion usage for analysis and service improvement purposes.</li>
      </ul>
    </LegalPage>
  );
}
