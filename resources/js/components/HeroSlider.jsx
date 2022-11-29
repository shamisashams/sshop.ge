import React, { useRef, useState } from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/pagination";
import { Pagination, Navigation } from "swiper";
import { Link, usePage } from "@inertiajs/inertia-react";
import { MdChevronLeft, MdChevronRight } from "react-icons/md";

const HeroSlider = () => {
    const prevRef = useRef(null);
    const nextRef = useRef(null);
    const renderHTML = (rawHTML) =>
        React.createElement("div", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

    const { sliders, localizations } = usePage().props;

    return (
        <>
            {" "}
            <Swiper
                loop
                pagination={{
                    clickable: true,
                }}
                navigation={true}
                modules={[Pagination, Navigation]}
                grabCursor
                className="relative heroSlider group desktopImages"
                onInit={(swiper) => {
                    swiper.params.navigation.prevEl = prevRef.current;
                    swiper.params.navigation.nextEl = nextRef.current;
                    swiper.navigation.init();
                    swiper.navigation.update();
                }}
            >
                {sliders.map((item, index) => {
                    let image = item.file ? item.file.file_full_url : null;
                    if(item.desktop) image = item.desktop.file_full_url;
                    return (
                        <SwiperSlide key={index} className="self-stretch ">
                            <div className="w-full h-fit bg-no-repeat ">
                                <img
                                    className="w-full h-full object-contain"
                                    src={
                                        image
                                    }
                                    alt=""
                                />

                                <Link
                                    className="text-sm absolute left-1/2 -translate-x-1/2 sm:bottom-5 bottom-3 z-40"
                                    href={item.youtube_url}
                                >
                                    {__("client.learn_more", localizations)}
                                    <img
                                        className="sm:inline-block hidden ml-2"
                                        src="/client/assets/images/icons/arrow.svg"
                                        alt=""
                                    />
                                </Link>
                            </div>
                        </SwiperSlide>
                    );
                })}

                <div className="h-0.5 w-full flex">
                    <div
                        className="w-1/4 h-full"
                        style={{ background: "#4FA9D2" }}
                    ></div>
                    <div
                        className="w-1/4 h-full"
                        style={{ background: "#F0DD5D" }}
                    ></div>
                    <div
                        className="w-1/4 h-full"
                        style={{ background: "#81BF97" }}
                    ></div>
                    <div
                        className="w-1/4 h-full"
                        style={{ background: "#DF6756" }}
                    ></div>
                </div>

                <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 wrapper flex items-center justify-between text-white z-40 h-fit group-hover:opacity-100 opacity-0 transition-all duration-300">
                    <button
                        ref={prevRef}
                        className="w-10 h-10 flex items-center justify-center rounded-lg bg-custom-dark/[0.5] transition-all duration-300 hover:bg-custom-red"
                    >
                        <MdChevronLeft />
                    </button>
                    <button
                        ref={nextRef}
                        className="w-10 h-10 flex items-center justify-center rounded-lg bg-custom-dark/[0.5] transition-all duration-300 hover:bg-custom-red"
                    >
                        <MdChevronRight />
                    </button>
                </div>
            </Swiper>
            <Swiper
                loop
                pagination={{
                    clickable: true,
                }}
                navigation={true}
                modules={[Pagination, Navigation]}
                grabCursor
                className="relative heroSlider group mobileImages"
                onInit={(swiper) => {
                    swiper.params.navigation.prevEl = prevRef.current;
                    swiper.params.navigation.nextEl = nextRef.current;
                    swiper.navigation.init();
                    swiper.navigation.update();
                }}
            >
                {sliders.map((item, index) => {
                    let image = item.file ? item.file.file_full_url : null;
                    if(item.mobile) image = item.mobile.file_full_url;
                    return (
                        <SwiperSlide key={index} className="self-stretch ">
                            <div className="w-full h-fit bg-no-repeat ">
                                <img
                                    className="w-full h-full object-contain"
                                    src={
                                        image
                                    }
                                    alt=""
                                />

                                <Link
                                    className="text-sm absolute left-1/2 -translate-x-1/2 sm:bottom-5 bottom-3 z-40"
                                    href={item.youtube_url}
                                >
                                    {__("client.learn_more", localizations)}
                                    <img
                                        className="sm:inline-block hidden ml-2"
                                        src="/client/assets/images/icons/arrow.svg"
                                        alt=""
                                    />
                                </Link>
                            </div>
                        </SwiperSlide>
                    );
                })}

                <div className="h-0.5 w-full flex">
                    <div
                        className="w-1/4 h-full"
                        style={{ background: "#4FA9D2" }}
                    ></div>
                    <div
                        className="w-1/4 h-full"
                        style={{ background: "#F0DD5D" }}
                    ></div>
                    <div
                        className="w-1/4 h-full"
                        style={{ background: "#81BF97" }}
                    ></div>
                    <div
                        className="w-1/4 h-full"
                        style={{ background: "#DF6756" }}
                    ></div>
                </div>

                <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 wrapper flex items-center justify-between text-white z-40 h-fit group-hover:opacity-100 opacity-0 transition-all duration-300">
                    <button
                        ref={prevRef}
                        className="w-10 h-10 flex items-center justify-center rounded-lg bg-custom-dark/[0.5] transition-all duration-300 hover:bg-custom-red"
                    >
                        <MdChevronLeft />
                    </button>
                    <button
                        ref={nextRef}
                        className="w-10 h-10 flex items-center justify-center rounded-lg bg-custom-dark/[0.5] transition-all duration-300 hover:bg-custom-red"
                    >
                        <MdChevronRight />
                    </button>
                </div>
            </Swiper>
        </>
    );
};

export default HeroSlider;
