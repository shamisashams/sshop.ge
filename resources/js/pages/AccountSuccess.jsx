import React from "react";
import { Link, usePage } from '@inertiajs/inertia-react'
import Layout from "@/Layouts/Layout";

const AccountSuccess = ({seo}) => {
    const {localizations} = usePage().props;
  return (
      <Layout seo={seo}>
          <div className="py-40 text-center bg-custom-zinc-200 min-h-screen">
              <div className="bold text-4xl mb-2">{__('client.account_success_h',localizations)}</div>
              <div className="text-sm opacity-50">
                  {__('client.account_success_t',localizations)}
              </div>
          </div>
      </Layout>

  );
};

export default AccountSuccess;
