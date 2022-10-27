import React, { useRef, useState } from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import "../../css/zoom.css";
import "swiper/css/thumbs";
import { Pagination, Navigation, Thumbs } from "swiper";
import { BiChevronRight, BiChevronLeft } from "react-icons/bi";

const SingleSlider = ({ images }) => {
    const prevRef = useRef(null);
    const nextRef = useRef(null);
    const [thumbsSwiper, setThumbsSwiper] = useState(null);

    return (
        <>
            <Swiper
                loop
                pagination={true}
                modules={[Pagination, Navigation, Thumbs]}
                grabCursor
                className=" "
                thumbs={{ swiper: thumbsSwiper }}
                onInit={(swiper) => {
                    swiper.params.navigation.prevEl = prevRef.current;
                    swiper.params.navigation.nextEl = nextRef.current;
                    swiper.navigation.init();
                    swiper.navigation.update();
                }}
            >
                {images.map((item, index) => {
                    return (
                        <SwiperSlide key={index}>
                            <div
                                className="singleSlideImg w-full pb-10 w-4/5 mx-auto"
                                style={{ overflow: "hidden" }}
                            >
                                <div className="img-wrapper  w-full">
                                    <img
                                        className="inner-img w-full"
                                        src={item.file_full_url}
                                    />
                                </div>
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
            <Swiper
                onSwiper={setThumbsSwiper}
                spaceBetween={10}
                slidesPerView={4}
                watchSlidesProgress={true}
                modules={[Navigation, Thumbs]}
                className="max-w-lg"
            >
                {images.map((item, index) => {
                    return (
                        <SwiperSlide key={index}>
                            <div
                                className="w-full sm:h-28 h-20 mx-auto bg-white"
                                style={{ overflow: "hidden" }}
                            >
                                <div className="w-full h-full">
                                    <img
                                        className="w-full h-full object-contain"
                                        src={item.file_full_url}
                                    />
                                </div>
                            </div>
                        </SwiperSlide>
                    );
                })}
            </Swiper>
        </>
    );
};

export default SingleSlider;
