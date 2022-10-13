import React, {useState} from "react";
//import Google from "../assets/images/signin/2.png";
//import Fb from "../assets/images/signin/1.png";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
import Layout from "@/Layouts/Layout";
import { Inertia } from "@inertiajs/inertia";

const LogIn = ({seo}) => {

    const { errors, localizations } = usePage().props;
    const [values, setValues] = useState({
        email: "",
        password: "",
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
        Inertia.post(route("client.login"), values);
    }

  return (
      <Layout seo={seo}>
          <div className="batman">
              <div className="wrapper">
                  <div className="sign-in">
                      <div className="title-text bold">{__('client.login',localizations)}</div>
                      <form action="#" className="auth-form">
                          {errors.email && <div>{errors.email}</div>}
                          <input name="email" type="email" placeholder={__('client.form_email',localizations)} onChange={handleChange} />
                          <input type="password" name="password" placeholder={__('client.form_password',localizations)} onChange={handleChange} />
                      </form>
                      <a onClick={handleSubmit} href="javascript:;">
                          <div className="main-btn bold">{__('client.login_btn',localizations)}</div>
                      </a>
                      <div className="or">
                          <hr className="hr-text" data-content="Or" />
                      </div>
                      {/* Alternative Sign in */}
                      <div className="alternative-sign">
                          <a href="#">
                              <div className="options flex center">
                                  <img src="/client/assets/images/signin/2.png" alt="" />
                                  <p>Sing in with Google</p>
                              </div>
                          </a>
                          <a href="#">
                              <div className="options flex center">
                                  <img src="/client/assets/images/signin/1.png" alt="" />
                                  <p>Sing in with Facebook</p>
                              </div>
                          </a>
                      </div>
                      {/* Alternative Sign in ends */}
                      {/* Registration */}
                      <div className="acoount-alternative">
                          <p>
                              {__('client.dont_have_account',localizations)}
                              <Link href={route('client.registration.index')}>
                                  <span> {__('client.signup_link',localizations)}</span>
                              </Link>
                          </p>
                      </div>
                      {/* Registration End*/}
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default LogIn;