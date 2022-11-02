import React, { useState } from "react";
//import Google from "../assets/images/signin/2.png";
//import Fb from "../assets/images/signin/1.png";
//import { Link } from "react-router-dom";
import { Link, usePage } from "@inertiajs/inertia-react";
import Layout from "@/Layouts/Layout";
import { Inertia } from "@inertiajs/inertia";

const ForgotPassword = ({ seo }) => {
    const [passSend, setPassSend] = useState(false);
    const { pathname, errors, localizations } = usePage().props;
    const [values, setValues] = useState({
        email: "",
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
        Inertia.post(route("password.email"), values);
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
        Inertia.post(route("password.email"), values);
        setPassSend(true);
    }

    return (
        <Layout seo={seo}>
            <div className="batman">
                <div className="wrapper pb-60">
                    <div className="sign-in relative p-5">
                        <div className="title-text bold">
                            {__("client.forgot_password", localizations)}
                        </div>
                        <p className="opacity-50 text-sm mb-10">
                            {__(
                                "client.to_reset_pass_enter_mail",
                                localizations
                            )}
                        </p>

                        <div className="flex items-center justify-between">
                            <form onSubmit={handleSubmit} className="auth-form">
                                {errors.email && <div>{errors.email}</div>}
                                <input
                                    className="!mb-0"
                                    name="email"
                                    type="email"
                                    placeholder={__(
                                        "client.form_email",
                                        localizations
                                    )}
                                    onChange={handleChange}
                                />
                                <input
                                    className="!mb-0"
                                    type="submit"
                                    id="submitbtn"
                                    style={{ display: "none" }}
                                />
                            </form>
                            <a
                                onClick={handleClick}
                                href="javascript:;"
                                className="ml-3"
                            >
                                <div className="main-btn bold whitespace-nowrap">
                                    {__("client.send_recover", localizations)}
                                </div>
                            </a>
                        </div>
                        {/* Registration End*/}
                        <div
                            className={`absolute w-full left-0 top-0 pt-40 transition-all duration-500 ${
                                passSend
                                    ? "opacity-100 visible"
                                    : "opacity-0 invisible"
                            }`}
                            style={{ backgroundColor: "#f8f8f9" }}
                        >
                            <div className="title-text bold">
                                {__("client.forgot_password", localizations)}
                            </div>
                            <p className="opacity-50 text-sm mb-5">
                                {__("client.we_sent_link", localizations)}
                            </p>{" "}
                            <img
                                className="mx-auto mb-10"
                                src="/client/assets/images/other/1.png"
                                alt=""
                            />
                            <Link
                                href={route("client.login.index")}
                                className="w-fit  mx-auto"
                            >
                                <div className="main-btn  mx-auto bold whitespace-nowrap w-fit">
                                    {__("client.login", localizations)}
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </Layout>
    );
};

export default ForgotPassword;
