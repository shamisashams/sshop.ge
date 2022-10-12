//import Cart from "../assets/images/about/1.png";
import React from "react";
import Layout from "@/Layouts/Layout";
import { Link, usePage } from '@inertiajs/inertia-react'

const About = ({seo}) => {
    const {images, localizations} = usePage().props;

    const renderHTML = (rawHTML) =>
        React.createElement("p", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

  return (
      <Layout seo={seo}>
          <div className="batman about-us-background">
              <div className="wrapper">
                  <div id="about-us">
                      <div className="text">
                          <div className="title bold">{__('client.about_h',localizations)}</div>
                          <div className="paragraphs">
                              {renderHTML(__('client.about_t',localizations).newLineToBr())}
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
                                  service. If users can post content on your website or mobile app
                                  (create content and share it on your platform), you can remove
                                  any content they created if it infringes copyright. Your Terms
                                  and Conditions will inform users that they can only create
                                  and/or share content they own rights to. Similarly, if users can
                                  register for an account and choose a username, you can inform
                                  users that they are not allowed to choose usernames that may
                                  infringe trademarks, i.e. usernames like Google, Facebook, and
                                  so on.
                              </p>*/}
                          </div>
                      </div>
                      <div className="cart-image">
                          <img src={images[0]} alt="" />
                      </div>
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default About;
