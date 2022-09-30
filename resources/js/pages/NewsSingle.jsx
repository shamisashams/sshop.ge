import React from "react";
//import Cover from "../assets/images/news-single/1.png";
//import Image1 from "../assets/images/news-single/2.png";
//import Cover2 from "../assets/images/news-single/3.png";
import Layout from "@/Layouts/Layout";
import { Link, usePage } from '@inertiajs/inertia-react'

const NewsSingle = ({seo}) => {

    const {news} = usePage().props;

    const renderHTML = (rawHTML) =>
        React.createElement("div", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

  return (
      <Layout seo={seo}>
          <div className="batman">
              <div className="wrapper">
                  <div className="news-single">
                      <div className="news-t-d">
                          <div className="main-title bold">{news.title}</div>
                          <div className="news-date">{news.formatted_date}</div>
                      </div>
                      <div className="cover-image">
                          <img src={news.latest_image ? news.latest_image.file_full_url:null} alt="" />
                      </div>
                      <div className="news-content">
                          <div className="news-paragraphs">

                              {renderHTML(news.text)}

                              {/*<p>
                                  We serve clients in financial services, law, insurance, diverse
                                  corporate sectors and strategy consulting. We design innovative
                                  and differentiated content ideas for our clients` worldwide
                                  conferences and events of all sizes.
                              </p>
                              <p>
                                  On behalf of our clients, we build relationships with senior
                                  executives, experts and speakers across diverse sectors. We
                                  invite them to share their strategic insights and knowledge at
                                  our clients` events globally. The speaking engagements comprise
                                  a variety of formats including video calls, roundtable
                                  discussions, keynote presentations at conferences, etc.
                              </p>
                              <p>
                                  Sales Support Manager for its Tbilisi office. The role is full
                                  time and an integral part of our sales and business development
                                  efforts. Working closely with the management team, you will be
                                  responsible for expansion of existing client segments as well as
                                  managing client accounts.
                              </p>
                              <div className="p-title">Your responsibilities:</div>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Evaluate sales processes and perform collaboratively with
                                  company team
                              </p>
                              <p>
                                  ** Integrate into our high-performance culture while adhering to
                                  business development best practices, and self-tracking sales
                                  efforts and outcomes
                              </p>
                              <div className="i-news">
                                  <img src="/client/assets/images/news-single/2.png" alt="" />
                              </div>
                              <div className="p-title">What we are looking for:</div>
                              <p>** Complete fluency in written and spoken English</p>
                              <p>** Complete fluency in written and spoken English</p>
                              <p>** Complete fluency in written and spoken English</p>
                              <p>** Complete fluency in written and spoken English</p>
                              <p>** Complete fluency in written and spoken English</p>
                              <p>** Complete fluency in written and spoken English</p>
                              <p>** Complete fluency in written and spoken English</p>
                              <p>** Complete fluency in written and spoken English</p>
                              <p>** Complete fluency in written and spoken English</p>
                              <p>** Complete fluency in written and spoken English</p>
                              <p>** Complete fluency in written and spoken English</p>
                              <p>** Complete fluency in written and spoken English</p>*/}
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default NewsSingle;
