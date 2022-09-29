import React from "react";
//import Google from "../assets/images/signin/2.png";
//import Fb from "../assets/images/signin/1.png";
//import { Link } from "react-router-dom";
import { Link } from '@inertiajs/inertia-react'

const SignUp = () => {
  return (
    <div className="batman">
      <div className="wrapper">
        <div className="sign-up">
          <div className="title-text bold">Create account</div>
          <form action="#" className="auth-form">
            <input type="name" placeholder="Name" />
            <input type="surname" placeholder="Surname" />
            <input type="id" placeholder="ID" />
            <input type="email" placeholder="Email" />
            <input type="password" name="password" placeholder="Password" />
            <input
              type="password"
              name="password"
              placeholder="Repeat Password"
            />
            <input type="numbers" placeholder="Phone Number" />
            <div className="flex items-center !justify-start mb-6">
              <input
                className="hidden"
                type="checkbox"
                name=""
                id="term_conditions"
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
          </form>
          <a href="">
            <div className="main-btn bold">Sign Up</div>
          </a>
          <div className="acoount-alternative">
            <p>
              Already have an account?
              <Link href="/login">
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
  );
};

export default SignUp;
