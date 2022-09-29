//import { Link } from "react-router-dom";
import { Link } from '@inertiajs/inertia-react'
//import SignOut from "../assets/images/cabinet/3.png";
import { IoSettingsOutline } from "react-icons/io5";
import { RiHistoryFill } from "react-icons/ri";

const CabinetNav = ({ active }) => {
  return (
    <div className="cabinet-nav">
      <div className="cabinet-nav-wrapper">
        <div className="location-name">Partner Cabinet</div>
        <div className="fio">Name Surname</div>
        <div className="mb-10">
          <div className="location-name">Status</div>
          <div className="text-red-300">
            Email not verified{" "}
            <Link href="/verification" className="text-custom-blue underline">
              Verify now!
            </Link>{" "}
          </div>
        </div>
        <div className="fio-buttons-wrapper">
          <div className="fio-buttons">
            <Link href="/personal-information">
              <div
                className={`main-btn bold account-btn tabBtns flex ${
                  active === 1 ? "active" : ""
                }`}
              >
                <IoSettingsOutline className="w-6 h-6  mr-4" />
                Account settings
              </div>
            </Link>
            <Link href="/order-history">
              <div
                className={`main-btn bold account-btn  tabBtns flex ${
                  active === 2 ? "active" : ""
                }`}
              >
                <RiHistoryFill className="w-6 h-6  mr-4" />
                Order history
              </div>
            </Link>
          </div>
        </div>{" "}
        <Link href="/">
          <div className="main-btn bold sign-out-btn">
            <img src="/client/assets/images/cabinet/3.png" alt="" />
            Sign out
          </div>
        </Link>
      </div>
    </div>
  );
};

export default CabinetNav;
