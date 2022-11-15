import React from "react";
//import { Link } from "react-router-dom";
import { Link, usePage } from "@inertiajs/inertia-react";
//import Logo from "../assets/images/logo/1.png";
import { LocationMap, SocialMedia } from "../components/Shared";
import { MdCall, MdEmail, MdLocationOn } from "react-icons/md";

const Footer = () => {
    const { localizations, info } = usePage().props;
    return (
        <div className="py-10 border-t">
            <div className="wrapper flex justify-between items-start flex-wrap text-sm sm:text-base">
                <Link href="/" className="w-full sm:w-auto mb-10">
                    <img src="/client/assets/images/logo/1.png" alt="" />
                </Link>
                <div className="md:mx-5 mx-3 mb-5">
                    <Link
                        className="bold mb-4 block"
                        href={route("client.home.index")}
                    >
                        {__("client.nav_home", localizations)}
                    </Link>
                    <Link
                        className="bold mb-4 block"
                        href={route("client.about.index")}
                    >
                        {__("client.nav_about", localizations)}
                    </Link>
                    <Link
                        className="bold mb-4 block"
                        href={route("client.news.index")}
                    >
                        {__("client.nav_news", localizations)}
                    </Link>
                    <Link
                        className="bold mb-4 block"
                        href={route("client.contact.index")}
                    >
                        {__("client.nav_contact", localizations)}
                    </Link>
                </div>
                <div className="md:mx-5 mx-3 mb-5">
                    <Link
                        className="bold mb-4 block"
                        href={route("search.index")}
                    >
                        {__("client.nav_products", localizations)}
                    </Link>
                    <Link
                        className="bold mb-4 block"
                        href={route("client.category.popular")}
                    >
                        {__("client.nav_popular", localizations)}
                    </Link>
                    <Link
                        className="bold mb-4 block"
                        href={route("client.category.special")}
                    >
                        {__("client.nav_best_price", localizations)}
                    </Link>
                    <Link
                        className="bold mb-4 block"
                        href={route("client.category.like")}
                    >
                        {__("client.nav_product_like", localizations)}
                    </Link>
                </div>
                <div className="md:mx-5 mx-3 mb-5">
                    <Link
                        className="bold mb-4 block"
                        href={route("client.terms")}
                    >
                        {__("client.nav_terms", localizations)}
                    </Link>
                    <Link
                        className="bold mb-4 block"
                        href={route("client.guarantee")}
                    >
                        {__("client.nav_guarantee", localizations)}
                    </Link>
                    <Link
                        className="bold mb-4 block"
                        href={route("client.shipping-payment")}
                    >
                        {__("client.nav_shipping_payment", localizations)}
                    </Link>
                </div>
                <div className="rounded overflow-hidden md:w-1/3 sm:w-1/2 w-full md:ml-5 sm:ml-3 mb-5">
                    <LocationMap />
                </div>
                <div className="sm:text-right sm:w-auto w-full mx-auto sm:mr-0 block">
                    <div className="border mb-5 p-5 rounded w-fit ml-0 md:ml-10">
                        <Link className="bold mb-3 block" href="/">
                            <MdCall className="inline-block mr-1 align-middle w-4 h-4" />{" "}
                            {info.phone}
                        </Link>
                        <Link className="bold mb-3 block" href="/">
                            <MdEmail className="inline-block mr-1 align-middle w-4 h-4" />{" "}
                            {info.email}
                        </Link>
                        <Link className="bold block" href="/">
                            <MdLocationOn className="inline-block mr-1 align-middle w-4 h-4" />{" "}
                            გორი, გურამიშვილის ქ 84
                        </Link>
                    </div>

                    <div className="w-fit mx-auto ml-0 sm:w-auto sm:mr-0 sm:ml-auto">
                        <SocialMedia />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Footer;
