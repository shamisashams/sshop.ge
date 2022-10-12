import React from "react";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
//import SignOut from "../assets/images/cabinet/3.png";
import { IoSettingsOutline } from "react-icons/io5";
import { RiHistoryFill } from "react-icons/ri";
import { Inertia } from "@inertiajs/inertia";

const CabinetNav = ({ active }) => {

    const {user,localizations} = usePage().props;

    function sendVerificationLink(e){
        e.preventDefault();
        Inertia.post(route('verification.send'));
    }

  return (
    <div className="cabinet-nav">
      <div className="cabinet-nav-wrapper">
        <div className="location-name">{__('client.cabinet', localizations)}</div>
        <div className="fio">{user.name} {user.surname}</div>
        <div className="mb-10">
          <div className="location-name">{__('client.status', localizations)}</div>
            {!user.email_verified_at ? <div className="text-red-300">
                {__('client.not_verified', localizations)}{" "}
            <Link onClick={sendVerificationLink} className="text-custom-blue underline">
                {__('client.verify_now', localizations)}
            </Link>{" "}
          </div>:<div className="text-green-300">
                {__('client.verified', localizations)}{" "}
            </div>}
        </div>
        <div className="fio-buttons-wrapper">
          <div className="fio-buttons">
            <Link href={route('client.cabinet')}>
              <div
                className={`main-btn bold account-btn tabBtns flex ${
                  active === 1 ? "active" : ""
                }`}
              >
                <IoSettingsOutline className="w-6 h-6  mr-4" />
                  {__('client.account_settings', localizations)}
              </div>
            </Link>
            <Link href={route('client.orders')}>
              <div
                className={`main-btn bold account-btn  tabBtns flex ${
                  active === 2 ? "active" : ""
                }`}
              >
                <RiHistoryFill className="w-6 h-6  mr-4" />
                  {__('client.order_history', localizations)}
              </div>
            </Link>
          </div>
        </div>{" "}
        <Link href={route("logout")}>
          <div className="main-btn bold sign-out-btn">
            <img src="/client/assets/images/cabinet/3.png" alt="" />
              {__('client.logout', localizations)}
          </div>
        </Link>
      </div>
    </div>
  );
};

export default CabinetNav;
