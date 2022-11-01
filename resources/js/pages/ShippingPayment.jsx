import React from "react";
import { HiOutlineArrowNarrowRight } from "react-icons/hi";
//import arrow from "../assets/images/terms/arrow-left.png";
import { Link, usePage } from "@inertiajs/inertia-react";
import Layout from "@/Layouts/Layout";

const ShippingPayment = ({seo}) => {
    const { localizations, urlPrev, page } = usePage().props;

    const renderHTML = (rawHTML) =>
        React.createElement("p", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

  return (
      <Layout seo={seo}>
          <div className="batman">
              <div className="container">
                  <div id="terms-conditions">
                      <div className="title bold">{page.title}</div>
                      <div className="paragraphs">
                          {renderHTML(page.description)}
                          {/*<p>
                              Unlike Privacy Policies, which are required by laws such as the
                              GDPR, CalOPPA and many others, there's no law or regulation on
                              Terms and Conditions.
                          </p>
                          <p>
                              However, having a Terms and Conditions gives you the right to
                              terminate the access of abusive users or to terminate the access
                              to users who do not follow your rules and guidelines, as well as
                              other desirable business benefits.
                          </p>
                          <p>
                              It's extremely important to have this agreement if you operate a
                              SaaS app.
                          </p>
                          <p>Here are a few examples of how this agreement can help you:</p>
                          <p>
                              If users abuse your website or mobile app in any way, you can
                              terminate their account. Your "Termination" clause can inform
                              users that their accounts would be terminated if they abuse your
                              service.
                          </p>
                          <p>
                              If users can post content on your website or mobile app (create
                              content and share it on your platform), you can remove any content
                              they created if it infringes copyright. Your Terms and Conditions
                              will inform users that they can only create and/or share content
                              they own rights to. Similarly, if users can register for an
                              account and choose a username, you can inform users that they are
                              not allowed to choose usernames that may infringe trademarks, i.e.
                              usernames like Google, Facebook, and so on.
                          </p>
                          <p>
                              If you sell products or services, you could cancel specific orders
                              if a product price is incorrect. Your Terms and Conditions can
                              include a clause to inform users that certain orders, at your sole
                              discretion, can be canceled if the products ordered have incorrect
                              prices due to various errors.
                          </p>
                          <p>And many more examples.</p>
                          <p>
                              In summary, while you do not legally need a Terms and Conditions
                              agreement, there are many many reasons for you to have one. Not
                              only will it make your business look more professional and
                              trustworthy, but you'll also be maintaining more control over how
                              your users are able to interact with your platforms and content.
                          </p>
                          <p>What Information to Include in Terms and Conditions</p>
                          <p>What Information to Include in Terms and Conditions</p>
                          <p>
                              In your Terms and Conditions, you can include rules and guidelines
                              on how users can access and use your website and mobile app.
                          </p>
                          <p>Here are a few examples:</p>
                          <p>
                              An Intellectual Property clause will inform users that the
                              contents, logo and other visual media you created is your property
                              and is protected by copyright laws. A Termination clause will
                              inform users that any accounts on your website and mobile app, or
                              users' access to your website and app, can be terminated in case
                              of abuses or at your sole discretion.
                          </p>
                          <p>
                              A Governing Law clause will inform users which laws govern the
                              agreement. These laws should come from the country in which your
                              company is headquartered or the country from which you operate
                              your website and mobile app. A Links to Other Websites clause will
                              inform users that you are not responsible for any third party
                              websites that you link to. This kind of clause will generally
                              inform users that they are responsible for reading and agreeing
                              (or disagreeing) with the Terms and Conditions or Privacy Policies
                              of these third parties. If your website or mobile app allows users
                              to create content and make that content public to other users, a
                              Content clause will inform users that they own the rights to the
                              content they have created. This clause usually mentions that users
                              must give you (the website or mobile app developer/owner) a
                              license so that you can share this content on your website/mobile
                              app and to make it available to other users.
                          </p>
                          <p>
                              Because the content created by users is public to other users, a
                              DMCA notice clause (or Copyright Infringement ) section is helpful
                              to inform users and copyright authors that, if any content is
                              found to be a copyright infringement, you will respond to any DMCA
                              takedown notices received and you will take down the content.
                          </p>
                          <p>
                              A Limit What Users Can Do clause can inform users that by agreeing
                              to use your service, they're also agreeing to not do certain
                              things. This can be part of a very long and thorough list in your
                              Terms and Conditions agreement so as to encompass the most amount
                              of negative uses.
                          </p>
                          <p>Here's how 500px lists its prohibited activities:</p>*/}
                      </div>
                      <div className="btn">
                          <Link href={urlPrev}>
                              {__('client.ship_back',localizations)}
                              <img src="/client/assets/images/terms/arrow-left.png" alt="" />
                          </Link>
                      </div>
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default ShippingPayment;
