//import Img from "../assets/images/other/2.png";
import { DirectionBtn } from "../components/Shared";
import React from "react";
import { Link, usePage } from "@inertiajs/inertia-react";
import Layout from "@/Layouts/Layout";

const PaymentFail = ({seo}) => {
    const { localizations } = usePage().props;

  return (
      <Layout seo={seo}>
          <div className="text-center py-32 bg-custom-zinc-200">
              <div className="wrapper">
                  <div className="bold text-3xl mb-4">{__('client.order_fail_h',localizations)}</div>
                  <div className="text-sm opacity-50 mb-10 max-w-md mx-auto">
                      {__('client.order_fail_t',localizations)}
                  </div>
                  <img className="mx-auto" src="/client/assets/images/other/2.png" alt="" />

                  <div className="mx-auto w-fit mt-10">
                      <DirectionBtn
                          text={__('client.back_to_payment',localizations)}
                          back
                          link={route('client.payment.index')}
                      />
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default PaymentFail;
