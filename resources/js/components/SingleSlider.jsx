import React, { useRef, useState } from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import { Pagination, Navigation } from "swiper";
//import Product1 from "../assets/images/products/1.png";
//import Product2 from "../assets/images/products/2.png";
//import Product3 from "../assets/images/products/3.png";
//import Product4 from "../assets/images/products/4.png";
import { BiChevronRight, BiChevronLeft } from "react-icons/bi";

const SingleSlider = () => {
  const prevRef = useRef(null);
  const nextRef = useRef(null);
  const imgs = ["/client/assets/images/products/1.png", "/client/assets/images/products/2.png", "/client/assets/images/products/3.png", "/client/assets/images/products/4.png"];

  return (
    <Swiper
      loop
      pagination={true}
      modules={[Pagination, Navigation]}
      grabCursor
      className=" "
      onInit={(swiper) => {
        swiper.params.navigation.prevEl = prevRef.current;
        swiper.params.navigation.nextEl = nextRef.current;
        swiper.navigation.init();
        swiper.navigation.update();
      }}
    >
      {imgs.map((item, index) => {
        return (
          <SwiperSlide key={index}>
            <div className="w-full pb-10">
              <img className="w-4/5 mx-auto" src={item} alt="" />
            </div>
          </SwiperSlide>
        );
      })}
      <div
        ref={prevRef}
        className="flex items-center justify-center absolute top-1/2 -translate-y-1/2 left-0  w-12 h-12 cursor-pointer group bg-white rounded-xl  shadow-lg z-40"
      >
        <BiChevronLeft className="fill-custom-blue w-6 h-6 " />
      </div>
      <div
        ref={nextRef}
        className="flex items-center justify-center absolute top-1/2 -translate-y-1/2 right-0  w-12 h-12 cursor-pointer group bg-white rounded-xl  shadow-lg z-40"
      >
        <BiChevronRight className="fill-custom-blue w-6 h-6 " />
      </div>
    </Swiper>
  );
};

export default SingleSlider;
