import React from "react";
import CabinetNav from "../components/CabinetNav";
import Input from "../components/Input";

const Verification = () => {
  return (
    <div className="batman" id="fio-page">
      <div className="abs-div"></div>
      <div className="wrapper flex">
        <CabinetNav active={0} />
        <div className="batman">
          <div className="fio-details ">
            <div className="fio-title ">Email verification</div>
            <p className="opacity-50 text-sm -mt-10 mb-10">
              For more security please verify your email address
            </p>
            <div className="fio-form">
              {" "}
              <Input label="Enter your email here" id="verify-email" />
              <button className="main-btn ">Send verification link</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Verification;
