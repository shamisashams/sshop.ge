import React from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/free-mode";
import "swiper/css/pagination";
import { FreeMode, Pagination } from "swiper";
import { productSliderData } from "./Data";
import ProductBox from "./ProductBox";

const ProductSlider = () => {
  return (
    <>
      <Swiper
        slidesPerView={6}
        spaceBetween={20}
        freeMode={true}
        pagination={{
          dynamicBullets: true,
        }}
        grabCursor
        modules={[FreeMode, Pagination]}
        className=""
        breakpoints={{
          1500: {
            slidesPerView: 6,
          },
          1300: {
            slidesPerView: 5,
          },
          1000: {
            slidesPerView: 4,
          },
          750: {
            slidesPerView: 3,
          },
          500: {
            slidesPerView: 2,
            freeMode: true,
          },
          200: {
            slidesPerView: 1,
            freeMode: false,
          },
        }}
      >
        {productSliderData.map((item, index) => {
          return (
            <SwiperSlide key={index} className="pb-10">
              <ProductBox
                img={item.img}
                name={item.name}
                brand={item.brand}
                oldPrice={item.oldPrice}
                price={item.price}
                discount={item.discount}
                link={item.link}
              />
            </SwiperSlide>
          );
        })}
      </Swiper>
    </>
  );
};

export default ProductSlider;
