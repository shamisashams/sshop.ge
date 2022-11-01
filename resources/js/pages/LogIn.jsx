import React, { useState } from "react";
//import Google from "../assets/images/signin/2.png";
//import Fb from "../assets/images/signin/1.png";
//import { Link } from "react-router-dom";
import { Link, usePage } from "@inertiajs/inertia-react";
import Layout from "@/Layouts/Layout";
import { Inertia } from "@inertiajs/inertia";

const LogIn = ({ seo }) => {
    const { pathname, errors, localizations } = usePage().props;
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

    /*window.addEventListener("keypress", function(event) {
        // If the user presses the "Enter" key on the keyboard
        if (event.key === "Enter" && pathname === route('client.login.index')) {
            // Cancel the default action, if needed

            event.preventDefault();
            // Trigger the button element with a click
            Inertia.post(route("client.login"), values);
        }
    });*/

    function handleClick(e) {
        e.preventDefault();
        Inertia.post(route("client.login"), values);
    }

    return (
        <Layout seo={seo}>
            <div className="batman">
                <div className="wrapper">
                    <div className="sign-in">
                        <div className="title-text bold">
                            {__("client.login", localizations)}
                        </div>
                        <form onSubmit={handleSubmit} className="auth-form">
                            {errors.email && <div>{errors.email}</div>}
                            <input
                                name="email"
                                type="email"
                                placeholder={__(
                                    "client.form_email",
                                    localizations
                                )}
                                onChange={handleChange}
                            />
                            <input
                                id="pass"
                                type="password"
                                name="password"
                                placeholder={__(
                                    "client.form_password",
                                    localizations
                                )}
                                onChange={handleChange}
                            />
                            <input
                                type="submit"
                                id="submitbtn"
                                style={{ display: "none" }}
                            />
                        </form>{" "}
                        <p className="mb-5 text-left ">
                            Can't remember password?{" "}
                            <Link
                                className="text-custom-blue underline"
                                href={route("password.request")}
                            >
                                {" "}
                                Reset It
                            </Link>
                        </p>
                        <a onClick={handleClick} href="javascript:;">
                            <div className="main-btn bold">
                                {__("client.login_btn", localizations)}
                            </div>
                        </a>
                        <div className="or">
                            <hr
                                className="hr-text"
                                data-content={__(
                                    "client.or_do_this",
                                    localizations
                                )}
                            />
                        </div>
                        {/* Alternative Sign in */}
                        <div className="alternative-sign">
                            <a href={route("google-redirect")}>
                                <div className="options flex center">
                                    <img
                                        src="/client/assets/images/signin/2.png"
                                        alt=""
                                    />
                                    <p>
                                        {__(
                                            "client.sign_in_with_google",
                                            localizations
                                        )}
                                    </p>
                                </div>
                            </a>
                            <a href={route("fb-redirect")}>
                                <div className="options flex center">
                                    <img
                                        src="/client/assets/images/signin/1.png"
                                        alt=""
                                    />
                                    <p>
                                        {__(
                                            "client.sign_in_with_facebook",
                                            localizations
                                        )}
                                    </p>
                                </div>
                            </a>
                        </div>
                        {/* Alternative Sign in ends */}
                        {/* Registration */}
                        <div className="acoount-alternative">
                            <p>
                                {__("client.dont_have_account", localizations)}
                                <Link href={route("client.registration.index")}>
                                    <span>
                                        {" "}
                                        {__(
                                            "client.signup_link",
                                            localizations
                                        )}
                                    </span>
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
