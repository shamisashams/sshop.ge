import React, { useRef, useState } from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/pagination";
import { Pagination } from "swiper";
import { heroData } from "./Data";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
//import Arrow from "../assets/images/icons/arrow.svg";

const HeroSlider = () => {

    const renderHTML = (rawHTML) =>
        React.createElement("div", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

    const {sliders, localizations} = usePage().props;

  return (
    <>
      {" "}
      <Swiper
        loop
        pagination={true}
        modules={[Pagination]}
        grabCursor
        className="relative heroSlider"
      >
        {sliders.map((item, index) => {
          return (
            <SwiperSlide key={index} className="self-stretch !h-auto">
              <div
                className="w-full h-full bg-center bg-cover bg-no-repeat "
                style={{ backgroundImage: `url(${item.file ? item.file.file_full_url : null})`, maxHeight : "525px"}}
              >
                <div className="wrapper md:py-32 py-10">
                  <div className="max-w-sm">
                    <div className="text-custom-blue text-sm">
                      {item.title}
                    </div>
                    <div className="bold my-3 text-xl ">{item.title_2}</div>
                    <div className="opacity-50 text-sm mb-5">{renderHTML(item.description)}</div>
                    <Link className="text-sm" href={item.youtube_url}>
                        {__('client.learn_more',localizations)}
                      <img className="inline-block ml-2" src="/client/assets/images/icons/arrow.svg" alt="" />
                    </Link>
                  </div>
                </div>
              </div>
            </SwiperSlide>
          );
        })}
        <div className="h-0.5 w-full flex">
          <div className="w-1/4" style={{ background: "#4FA9D2" }}></div>
          <div className="w-1/4" style={{ background: "#F0DD5D" }}></div>
          <div className="w-1/4" style={{ background: "#81BF97" }}></div>
          <div className="w-1/4" style={{ background: "#DF6756" }}></div>
        </div>
      </Swiper>
    </>
  );
};

export default HeroSlider;
