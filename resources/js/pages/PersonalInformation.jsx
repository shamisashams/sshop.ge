import React from "react";
//import { Link } from "react-router-dom";
import { Link } from '@inertiajs/inertia-react'
import CabinetNav from "../components/CabinetNav";
import Input from "../components/Input";

const PersonalInformation = () => {
  const inputs = [
    {
      label: "First Name",
      type: "text",
      id: "name",
    },
    {
      label: "Last Name",
      type: "text",
      id: "surnamename",
    },
    {
      label: "ID Number",
      type: "number",
      id: "id",
    },
    {
      label: "Address",
      type: "text",
      id: "address",
    },
    {
      label: "Phone Number",
      type: "number",
      id: "phone",
    },
    {
      label: "Email Address",
      type: "email",
      id: "email",
    },
    {
      label: "New Password",
      type: "password",
      id: "password",
    },
    {
      label: "Repeat New Password",
      type: "password",
      id: "password",
    },
  ];
  return (
    <div className="batman" id="fio-page">
      <div className="abs-div"></div>
      <div className="wrapper flex">
        <CabinetNav active={1} />
        <div className="batman">
          <div className="fio-details">
            <div className="fio-title">Personal information</div>
            <div className="fio-form">
              {inputs.map((item, index) => {
                return (
                  <Input key={index} label={item.label} id={`input_${index}`} />
                );
              })}

              <div className="buttons flex">
                <Link href="/">
                  <div className="main-btn cancel bold">Cancel</div>
                </Link>
                <Link href="/">
                  <div className="main-btn save bold">Save changes</div>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default PersonalInformation;
