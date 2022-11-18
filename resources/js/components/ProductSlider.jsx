import React from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/free-mode";
import "swiper/css/pagination";
import { FreeMode, Pagination } from "swiper";
import ProductBox from "./ProductBox";

const ProductSlider = ({ products }) => {
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
                        spaceBetween: 20,
                    },
                    350: {
                        slidesPerView: 2,
                        freeMode: true,
                        spaceBetween: 10,
                    },
                    0: {
                        slidesPerView: 1,
                        freeMode: false,
                    },
                }}
            >
                {products.map((item, index) => {
                    console.log(item);
                    let discount;
                    discount =
                        100 -
                        ((item.special_price * 100) / item.price).toFixed();
                    return (
                        <SwiperSlide key={index} className="pb-10">
                            <ProductBox
                                img={
                                    item.latest_image
                                        ? item.latest_image.thumb_full_url
                                        : null
                                }
                                name={item.title}
                                brand={item.attributes.brand}
                                oldPrice={
                                    item.special_price ? item.price : null
                                }
                                price={
                                    item.special_price
                                        ? item.special_price
                                        : item.price
                                }
                                discount={discount}
                                link={route("client.product.show", item.slug)}
                                id={item.id}
                                qty={item.quantity}
                            />
                        </SwiperSlide>
                    );
                })}
            </Swiper>
        </>
    );
};

export default ProductSlider;
