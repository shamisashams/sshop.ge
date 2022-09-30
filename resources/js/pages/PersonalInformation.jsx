import React, {useState} from "react";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
import CabinetNav from "../components/CabinetNav";
import Input from "../components/Input";
import Layout from "@/Layouts/Layout";
import { Inertia } from "@inertiajs/inertia";

const PersonalInformation = ({seo}) => {

    const { errors, user } = usePage().props;

    const [values, setValues] = useState({
        name: user.name ?? "",
        surname: user.surname ?? "",
        email: user.email,
        id_number: user.id_number,
        address: user.address ?? "",
        phone: user.phone ?? "",
    });

    function handleChange(e) {
        setValues((values) => ({
            ...values,
            [e.target.id]: e.target.value,
        }));
    }

    function handleSubmit(e) {
        e.preventDefault();
        Inertia.post(route("client.save-settings"), values);
    }


    const inputs = [
    {
      label: "First Name",
      type: "text",
      id: "name",
    },
    {
      label: "Last Name",
      type: "text",
      id: "surname",
    },
    {
      label: "ID Number",
      type: "number",
      id: "id_number",
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
      id: "repeat_password",
    },
  ];
  return (
      <Layout seo={seo}>
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
                                      <Input key={index} label={item.label} id={item.id} value={values[item.id]} onChange={handleChange} />
                                  );
                              })}

                              <div className="buttons flex">
                                  <Link href="/">
                                      <div className="main-btn cancel bold">Cancel</div>
                                  </Link>
                                  <Link onClick={handleSubmit} href="javascript:;">
                                      <div className="main-btn save bold">Save changes</div>
                                  </Link>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default PersonalInformation;
