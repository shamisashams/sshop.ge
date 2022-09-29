import React from "react";
//import Location from "../assets/images/contact/1.png";
//import Phone from "../assets/images/contact/2.png";
//import Email from "../assets/images/contact/3.png";
//import Plain from "../assets/images/contact/4.png";
//import Fb from "../assets/images/contact/5.png";
//import Inst from "../assets/images/contact/6.png";
import Layout from "@/Layouts/Layout";

const Contact = ({seo}) => {
  return (
      <Layout seo={seo}>
          <div className="batman">
              <div id="contact-us" className="wrapper">
                  <div className="contact-items flex">
                      {/* Contact Us */}
                      <div className="item-1">
                          <div className="title-text bold">Contact us</div>
                          <div className="sub-item flex">
                              <div className="icn-background flex center">
                                  <img src="/client/assets/images/contact/1.png" alt="location" />
                              </div>
                              <div className="text">
                                  <div className="name bold">Address</div>
                                  <div className="target bold">
                                      Name of the street #13. Tbilisi, georgia
                                  </div>
                              </div>
                          </div>
                          <div className="sub-item flex">
                              <div className="icn-background flex center">
                                  <img src="/client/assets/images/contact/2.png" alt="phone" />
                              </div>
                              <div className="text">
                                  <div className="name bold">Phone number</div>
                                  <div className="target bold">+995 032 2 00 00 00</div>
                              </div>
                          </div>
                          <div className="sub-item flex">
                              <div className="icn-background flex center">
                                  <img src="/client/assets/images/contact/3.png" alt="email" />
                              </div>
                              <div className="text">
                                  <div className="name bold">Email</div>
                                  <div className="target bold">example@mail.com</div>
                              </div>
                          </div>
                      </div>
                      {/* Contact Us Ends */}

                      {/* Form Sart */}
                      <div className="item-2">
                          <div className="title-text bold">Write to us</div>
                          <div className="contact-form">
                              <form action="#">
                                  <input type="text" id="name" placeholder="Name" />
                                  <input type="text" id="surname" placeholder="Surname" />
                                  <input type="text" id="phone" placeholder="Phone Number" />
                                  <input type="text" id="email" placeholder="Email address" />
                                  <textarea
                                      name="message"
                                      id="subject"
                                      placeholder="Your message"></textarea>
                              </form>
                              <a href="#">
                                  <button className="main-btn bold">Send message</button>
                              </a>
                          </div>
                      </div>
                      {/* Form End */}

                      {/* Maps Start */}
                      <div className="item-3">
                          <div className="title-text bold">Find us on map</div>
                          <div className="contact-map">
                              <iframe
                                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255.765481463015!2d44.727261438882586!3d41.71087928520021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x7fb7037984df0a44!2zNDHCsDQyJzM5LjIiTiA0NMKwNDMnMzguMSJF!5e0!3m2!1sen!2sge!4v1663661773578!5m2!1sen!2sge"
                                  width="359"
                                  height="451"
                                  style={{ border: "0" }}
                                  allowFullScreen=""
                                  loading="lazy"
                                  referrerPolicy="no-referrer-when-downgrade"></iframe>
                          </div>
                      </div>
                      {/* Maps End */}
                  </div>{" "}
                  <div className="smedia-contact">
                      <div className="title-text bold">Social media</div>
                      <div className="sm-icons flex">
                          <a href="#">
                              <img src="/client/assets/images/contact/5.png" alt="facebook" />
                          </a>
                          <a href="#">
                              <img src="/client/assets/images/contact/6.png" alt="Instagram" />
                          </a>
                      </div>
                  </div>
              </div>
              <div className="paper-plain">
                  <img src="/client/assets/images/contact/4.png" alt="" />
              </div>
          </div>
      </Layout>

  );
};

export default Contact;
