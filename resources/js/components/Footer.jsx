import React from "react";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
//import Logo from "../assets/images/logo/1.png";
import { LocationMap, SocialMedia } from "../components/Shared";

const Footer = () => {
    const {localizations, info} = usePage().props;
  return (
    <div className="py-10 border-t">
      <div className="wrapper flex justify-between items-start flex-wrap text-sm sm:text-base">
        <Link href="/">
          <img src="/client/assets/images/logo/1.png" alt="" />
        </Link>
        <div className="md:mx-5 mx-3 mb-5">
          <Link className="bold mb-4 block" href={route('client.home.index')}>
              {__('client.nav_home',localizations)}
          </Link>
          <Link className="bold mb-4 block" href={route('client.about.index')}>
              {__('client.nav_about',localizations)}
          </Link>
          <Link className="bold mb-4 block" href={route('client.news.index')}>
              {__('client.nav_news',localizations)}
          </Link>
          <Link className="bold mb-4 block" href={route('client.contact.index')}>
              {__('client.nav_contact',localizations)}
          </Link>
        </div>
        <div className="md:mx-5 mx-3 mb-5">
          <Link className="bold mb-4 block" href={route('search.index')}>
              {__('client.nav_products',localizations)}
          </Link>
          <Link className="bold mb-4 block" href={route('client.category.popular')}>
              {__('client.nav_popular',localizations)}
          </Link>
          <Link className="bold mb-4 block" href={route('client.category.special')}>
              {__('client.nav_best_price',localizations)}
          </Link>
          <Link className="bold mb-4 block" href="/you-may-like">
              {__('client.nav_product_like',localizations)}
          </Link>
        </div>
        <div className="rounded overflow-hidden md:w-1/3 w-1/2 md:mx-5 mx-3 mb-5">
          <LocationMap />
        </div>
        <div className="text-right">
          <Link className="bold mb-4 block" href="/">
              {info.phone}
          </Link>
          <Link className="bold mb-10 block" href="/">
              {info.email}
          </Link>

          <SocialMedia />
        </div>
      </div>
    </div>
  );
};

export default Footer;
