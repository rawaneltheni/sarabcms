import React from 'react';
import LegalPage from './LegalPage';

export default function TermsAndConditions() {
  return (
    <LegalPage title="Terms and Conditions">
      <p>
        Terms of service (also known as terms of use and terms and conditions, commonly abbreviated as TOS or ToS, ToU or T&C) are the legal agreements between a service provider and a person who wants to use that service. The person must agree to abide by the terms of service in order to use the offered service.[1] Terms of service can also be merely a disclaimer, especially regarding the use of websites. Vague language and lengthy sentences used in the terms of use have brought concerns on customer privacy and raised public awareness in many ways.
      </p>

      <p>A terms of service agreement typically contains sections pertaining to one or more of the following topic:</p>

      <ul className="list-disc pl-6 space-y-2">
        <li>Disambiguation/definition of key words and phrases</li>
        <li>User rights and responsibilities</li>
        <li>Proper or expected usage; definition of misuse</li>
        <li>Accountability for online actions, behavior, and conduct</li>
        <li>Privacy policy outlining the use of personal data</li>
        <li>Payment details such as membership or subscription fees, etc.</li>
        <li>Opt-out policy describing procedure for account termination, if available</li>
        <li>Sometimes contains a Arbitration clause detailing the dispute resolution process and limited rights to take a claim to court</li>
        <li>Disclaimer/Limitation of Liability clarifying the site's legal liability for damages incurred by users</li>
        <li>User notification upon modification of terms, if offered</li>
      </ul>

      <p>Among 102 companies marketing genetic testing to consumers in 2014 for health purposes, 71 had publicly available terms and conditions:[4]</p>

      <ul className="list-disc pl-6 space-y-2">
        <li>57 of the 71 had disclaimer clauses (including 10 disclaiming liability for injury caused by their own negligence),</li>
        <li>51 let the company change terms (including 17 without notice),</li>
        <li>34 allow data disclosure in certain circumstances,</li>
        <li>31 require consumers to indemnify the company,</li>
        <li>20 promise not to sell data.</li>
      </ul>

      <p>Among 260 mass market consumer software license agreements in 2010,[5]</p>

      <ul className="list-disc pl-6 space-y-2">
        <li>91% disclaimed warranties of merchantability or fitness for purpose or said it was "As is"</li>
        <li>92% disclaimed consequential, incidental, special or foreseeable damages</li>
        <li>69% did not warrant the software was free of defects or would work as described in the manual</li>
        <li>55% capped damages at the purchase price or less</li>
        <li>36% said they were not warranting whether it infringed others' intellectual property rights</li>
        <li>32% required arbitration or a specific court</li>
        <li>17% required the customer to pay legal bills of the maker (indemnify), but not vice versa</li>
      </ul>

      <p>Among the terms and conditions of 31 cloud-computing services in January-July 2010, operating in England,[6]</p>

      <ul className="list-disc pl-6 space-y-2">
        <li>27 specified the law to be used (a US state or other country),</li>
        <li>most specify that consumers can claim against the company only in a particular city in that jurisdiction, though often the company can claim against the consumer anywhere,</li>
        <li>some require claims to be brought within half a year to 2 years,</li>
        <li>7 impose arbitration, all forbid illegal and objectionable conduct by the consumer,</li>
        <li>13 can amend terms just by posting changes on their own website,</li>
        <li>a majority disclaim responsibility for confidentiality or backups,</li>
        <li>most promise to preserve data only briefly after terminating service,</li>
        <li>few promise to delete data thoroughly when the customer leaves,</li>
        <li>some monitor the customers' data to enforce their policies on use,</li>
        <li>all disclaim warranties and almost all disclaim liability,</li>
        <li>24 require the customer to indemnify them, a few indemnify the customer,</li>
        <li>a few give credits for poor service, 15 promise "best efforts" and can suspend or stop any time.</li>
      </ul>

      <p className="pt-4">
        The researchers note that rules on location and time limits may be unenforceable for consumers in many jurisdictions with consumer protections, that acceptable use policies are rarely enforced, that quick deletion is dangerous if a court later rules the termination wrongful, that local laws often require warranties (and UK forced Apple to say so).
      </p>
    </LegalPage>
  );
}
