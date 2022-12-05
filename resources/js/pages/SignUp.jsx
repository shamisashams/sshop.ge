import React, {useState} from "react";
//import Google from "../assets/images/signin/2.png";
//import Fb from "../assets/images/signin/1.png";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
import Layout from "@/Layouts/Layout";
import { Inertia } from "@inertiajs/inertia";

const SignUp = ({seo}) => {

    const { errors, localizations } = usePage().props;
    const [values, setValues] = useState({
        name: "",
        Surname: "",
        id: "",
        email: "",
        password: "",
        password_repeat: "",
        phone: "",
        agree: false,
    });

    function handleChange(e) {
        const key = e.target.name;
        let value = e.target.value;
        if (e.target.name === "agree") {
            value = e.target.checked ? true : false;
        }
        setValues((values) => ({
            ...values,
            [key]: value,
        }));
    }

    function handleSubmit(e) {
        e.preventDefault();
        Inertia.post(route("client.register"), values);
    }

  return (
      <Layout seo={seo}>
          <div className="batman">
              <div className="wrapper">
                  <div className="sign-up">
                      <div className="title-text bold">{__('client.signup',localizations)}</div>
                      <form onSubmit={handleSubmit} className="auth-form">
                          <input name="name" type="name" placeholder={__('client.form_name',localizations)} onChange={handleChange} />
                          {errors.name && <div>{errors.name}</div>}
                          <input name="surname" type="surname" placeholder={__('client.form_surname',localizations)} onChange={handleChange} />
                          {errors.surname && <div>{errors.surname}</div>}
                          <input name="phone" type="numbers" placeholder={__('client.form_phone',localizations)} onChange={handleChange} />
                          {errors.phone && <div>{errors.phone}</div>}
                          {/*<input name="id_number" type="id" placeholder={__('client.form_id',localizations)} onChange={handleChange} />
                          {errors.id_number && <div>{errors.id_number}</div>}*/}
                          <input name="email" type="email" placeholder={__('client.form_email',localizations)} onChange={handleChange} />
                          {errors.email && <div>{errors.email}</div>}
                          <input type="password" name="password" placeholder={__('client.form_password',localizations)} onChange={handleChange} />
                          {errors.password && <div>{errors.password}</div>}
                          <input
                              type="password"
                              name="password_repeat"
                              placeholder={__('client.form_password_repeat',localizations)}
                              onChange={handleChange}
                          />
                          {errors.password_repeat && <div>{errors.password_repeat}</div>}

                          <div className="flex items-center !justify-start mb-6">
                              <input
                                  className="hidden"
                                  type="checkbox"
                                  name="agree"
                                  id="term_conditions"
                                  onChange={handleChange}
                              />
                              <label
                                  className="w-4 h-4 rounded border border-solid mr-2 mb-1 cursor-pointer"
                                  htmlFor="term_conditions"
                              ></label>
                              <label>
                                  {__('client.i_accept',localizations)}{" "}
                                  <Link className="text-custom-blue pl-1" href={route('client.terms')}>
                                      {__('client.term_conditions',localizations)}
                                  </Link>
                              </label>
                          </div>
                          {errors.agree && <div>{errors.agree}</div>}
                      </form>
                      <a onClick={handleSubmit} href="javascript:;">
                          <div className="main-btn bold">{__('client.signup_btn',localizations)}</div>
                      </a>
                      <div className="acoount-alternative">
                          <p>
                              {__('client.already_have_account',localizations)}
                              <Link href={route('client.login.index')}>
                                  <span> {__('client.login_link',localizations)}</span>
                              </Link>
                          </p>
                      </div>
                      <div className="or">
                          <hr className="hr-text" data-content={__('client.or_do_this',localizations)} />
                      </div>
                      {/* Alternative Sign in */}
                      <div className="alternative-sign-up">
                          <a href={route('google-redirect')}>
                              <div className="options flex center">
                                  <img src="/client/assets/images/signin/2.png" alt="" />
                              </div>
                          </a>
                          <a href={route('fb-redirect')}>
                              <div className="options flex center">
                                  <img src="/client/assets/images/signin/1.png" alt="" />
                              </div>
                          </a>
                      </div>
                      {/* Alternative Sign in ends */}
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default SignUp;
