import React from "react";
//import Google from "../assets/images/signin/2.png";
//import Fb from "../assets/images/signin/1.png";
//import { Link } from "react-router-dom";
import { Link } from '@inertiajs/inertia-react'

const LogIn = () => {
  return (
    <div className="batman">
      <div className="wrapper">
        <div className="sign-in">
          <div className="title-text bold">Log in</div>
          <form action="#" className="auth-form">
            <input type="email" placeholder="Email" />
            <input type="password" name="password" placeholder="Password" />
          </form>
          <a href="#">
            <div className="main-btn bold">Sign In</div>
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
              Don't have an account?
              <Link href="/signup">
                <span> Sign up</span>
              </Link>
            </p>
          </div>
          {/* Registration End*/}
        </div>
      </div>
    </div>
  );
};

export default LogIn;
