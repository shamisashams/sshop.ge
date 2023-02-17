import React from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/free-mode";
import "swiper/css/pagination";
import { FreeMode, Pagination } from "swiper";
import { Link, usePage } from "@inertiajs/inertia-react";
//import Partner1 from "../assets/images/partners/1.png";
//import Partner2 from "../assets/images/partners/2.png";
//import Partner3 from "../assets/images/partners/3.png";
//import Partner4 from "../assets/images/partners/4.png";
//import Partner5 from "../assets/images/partners/5.png";
//import Partner6 from "../assets/images/partners/6.png";

const PartnerSlider = () => {
    const { partners } = usePage().props;

    const partnersData = [
        "/client/assets/images/partners/1.png",
        "/client/assets/images/partners/2.png",
        "/client/assets/images/partners/3.png",
        "/client/assets/images/partners/4.png",
        "/client/assets/images/partners/5.png",
        "/client/assets/images/partners/6.png",
        "/client/assets/images/partners/2.png",
        "/client/assets/images/partners/3.png",
        "/client/assets/images/partners/4.png",
    ];

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
                className="partnerSlider"
                breakpoints={{
                    1400: {
                        slidesPerView: 6,
                    },
                    1200: {
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
                        centeredSlides: false,
                    },
                    200: {
                        slidesPerView: 2,
                        centeredSlides: true,
                    },
                }}
            >
                {partners.map((item, index) => {
                    return (
                        <SwiperSlide key={index} className="pb-10">
                            <div className="transition-all duration-500 h-24 ">
                                <img
                                    className="mx-auto h-full w-full object-contain"
                                    src={item.file_full_url}
                                    alt=""
                                />
                            </div>
                        </SwiperSlide>
                    );
                })}
            </Swiper>
        </>
    );
};

export default PartnerSlider;
