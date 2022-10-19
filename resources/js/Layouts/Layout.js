import React, { useEffect, useState } from "react";
import "./index.css";
import "./style.css";

import "aos/dist/aos.css";
import Footer from "../components/Footer";
import Navbar from "../components/Navbar";
//import ScrollToTop from "../components/ScrollToTop";

import setSeoData from "./SetSeoData";
// import {Fragment} from "react";
// import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import Aos from "aos";
import { usePage } from "@inertiajs/inertia-react";

import { ToastContainer, toast } from "react-toastify";

import "react-toastify/dist/ReactToastify.css";
import Preloader from "../components/Preloader/Preloader";
import { Inertia } from '@inertiajs/inertia'

export default function Layout({ children, seo = null }) {
    function detectQueryString() {
        var currentQueryString = window.location.search;
        if (currentQueryString) {
            return true;
        } else {
            return false;
        }
    }
    const [loading, setLoading] = useState(!detectQueryString);

    /*useEffect(() => {
        setTimeout(() => {
            setLoading(false);
        }, [3000]);
    }, []);*/



    Inertia.on('finish', () => {
        setTimeout(() => {
            setLoading(false);
        }, [500]);
    })


    window.addEventListener("load", ()=>{
        setTimeout(() => {
            setLoading(false);
        }, [500]);
    })

    if (seo) {
        setSeoData(seo);
    }
    useEffect(() => {
        Aos.init({ duration: 2000 });
    }, []);

    console.log(usePage().props);
    const { currentLocale, flash } = usePage().props;

    if (currentLocale == "ge") {
        import("./Geo.css");
    }
    //console.log(flash);

    if (flash.success) {
        toast.success(flash.success);
        flash.success = null;
    }
    if (flash.error) {
        toast.error(flash.error);
        flash.error = null;
    }
    if (flash.warning) {
        toast.warn(flash.warning);
        flash.warning = null;
    }

    return loading ? (
        <Preloader />
    ) : (
        <>
            {/*<Router>*/}
            {/*<Fragment>*/}
            <ToastContainer
                position="top-center"
                autoClose={5000}
                hideProgressBar={false}
                newestOnTop={false}
                closeOnClick
                rtl={false}
                pauseOnFocusLoss
                draggable
                pauseOnHover
            />
            <Navbar />
            {children}
            <Footer />
            {/*</Fragment>*/}
            {/*</Router>*/}
        </>
    );
}
