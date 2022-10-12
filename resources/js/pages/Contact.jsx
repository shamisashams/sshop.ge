import React, {useState} from "react";
//import Location from "../assets/images/contact/1.png";
//import Phone from "../assets/images/contact/2.png";
//import Email from "../assets/images/contact/3.png";
//import Plain from "../assets/images/contact/4.png";
//import Fb from "../assets/images/contact/5.png";
//import Inst from "../assets/images/contact/6.png";
import Layout from "@/Layouts/Layout";
import { Link, usePage } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";

const Contact = ({seo}) => {

    const { errors, info, localizations } = usePage().props;

    const [values, setValues] = useState({
        name: "",
        email: "",
        phone: "",
        message: "",
    });

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setValues((values) => ({
            ...values,
            [key]: value,
        }));
    }

    function handleSubmit(e) {
        e.preventDefault();
        Inertia.post(route("client.contact.mail"), values);
    }

  return (
      <Layout seo={seo}>
          <div className="batman">
              <div id="contact-us" className="wrapper">
                  <div className="contact-items flex">
                      {/* Contact Us */}
                      <div className="item-1">
                          <div className="title-text bold">{__('client.contact_contact',localizations)}</div>
                          <div className="sub-item flex">
                              <div className="icn-background flex center">
                                  <img src="/client/assets/images/contact/1.png" alt="location" />
                              </div>
                              <div className="text">
                                  <div className="name bold">{__('client.contact_address',localizations)}</div>
                                  <div className="target bold">
                                      {info.address}
                                  </div>
                              </div>
                          </div>
                          <div className="sub-item flex">
                              <div className="icn-background flex center">
                                  <img src="/client/assets/images/contact/2.png" alt="phone" />
                              </div>
                              <div className="text">
                                  <div className="name bold">{__('client.contact_phone',localizations)}</div>
                                  <div className="target bold">{info.phone}</div>
                              </div>
                          </div>
                          <div className="sub-item flex">
                              <div className="icn-background flex center">
                                  <img src="/client/assets/images/contact/3.png" alt="email" />
                              </div>
                              <div className="text">
                                  <div className="name bold">{__('client.contact_email',localizations)}</div>
                                  <div className="target bold">{info.email}</div>
                              </div>
                          </div>
                      </div>
                      {/* Contact Us Ends */}

                      {/* Form Sart */}
                      <div className="item-2">
                          <div className="title-text bold">{__('client.contact_write_msg',localizations)}</div>
                          <div className="contact-form">
                              <form action="#">
                                  <input onChange={handleChange} type="text" name="name" placeholder={__('client.form_name',localizations)} />
                                  {errors.name && <div>{errors.name}</div>}
                                  <input onChange={handleChange} type="text" name="surname" placeholder={__('client.form_surname',localizations)} />
                                  {errors.surname && <div>{errors.surname}</div>}
                                  <input onChange={handleChange} type="text" name="phone" placeholder={__('client.form_phone',localizations)} />
                                  {errors.phone && <div>{errors.phone}</div>}
                                  <input onChange={handleChange} type="text" name="email" placeholder={__('client.form_email',localizations)} />
                                  {errors.email && <div>{errors.email}</div>}
                                  <textarea
                                      name="message"
                                      onChange={handleChange}
                                      placeholder={__('client.form_msg',localizations)}></textarea>
                                  {errors.message && <div>{errors.message}</div>}
                              </form>
                              <a onClick={handleSubmit} href="javascript:;">
                                  <button className="main-btn bold">{__('client.send_msg_btn',localizations)}</button>
                              </a>
                          </div>
                      </div>
                      {/* Form End */}

                      {/* Maps Start */}
                      <div className="item-3">
                          <div className="title-text bold">{__('client.contact_find_on_map',localizations)}</div>
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
                      <div className="title-text bold">{__('client.contact_social',localizations)}</div>
                      <div className="sm-icons flex">
                          <a href={info.facebook}>
                              <img src="/client/assets/images/contact/5.png" alt="facebook" />
                          </a>
                          <a href={info.instagram}>
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
