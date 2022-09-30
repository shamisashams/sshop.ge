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
                      <div className="title-text bold">Create account</div>
                      <form onSubmit={handleSubmit} className="auth-form">
                          <input name="name" type="name" placeholder="Name" onChange={handleChange} />
                          {errors.name && <div>{errors.name}</div>}
                          <input name="surname" type="surname" placeholder="Surname" onChange={handleChange} />
                          {errors.surname && <div>{errors.surname}</div>}
                          <input name="id_number" type="id" placeholder="ID" onChange={handleChange} />
                          {errors.id_number && <div>{errors.id_number}</div>}
                          <input name="email" type="email" placeholder="Email" onChange={handleChange} />
                          {errors.email && <div>{errors.email}</div>}
                          <input type="password" name="password" placeholder="Password" onChange={handleChange} />
                          {errors.password && <div>{errors.password}</div>}
                          <input
                              type="password"
                              name="password_repeat"
                              placeholder="Repeat Password"
                              onChange={handleChange}
                          />
                          {errors.password_repeat && <div>{errors.password_repeat}</div>}
                          <input name="phone" type="numbers" placeholder="Phone Number" onChange={handleChange} />
                          {errors.phone && <div>{errors.phone}</div>}
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
                                  I accept{" "}
                                  <Link className="text-custom-blue pl-1" href="/terms-conditions">
                                      terms and conditions
                                  </Link>
                              </label>
                          </div>
                          {errors.agree && <div>{errors.agree}</div>}
                      </form>
                      <a onClick={handleSubmit} href="javascript:;">
                          <div className="main-btn bold">Sign Up</div>
                      </a>
                      <div className="acoount-alternative">
                          <p>
                              Already have an account?
                              <Link href={route('client.login.index')}>
                                  <span> Sign In</span>
                              </Link>
                          </p>
                      </div>
                      <div className="or">
                          <hr className="hr-text" data-content="Or" />
                      </div>
                      {/* Alternative Sign in */}
                      <div className="alternative-sign-up">
                          <a href="#">
                              <div className="options flex center">
                                  <img src="/client/assets/images/signin/2.png" alt="" />
                              </div>
                          </a>
                          <a href="#">
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
