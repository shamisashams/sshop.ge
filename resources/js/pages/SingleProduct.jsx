import React, { useState } from "react";
import { ColorPick, DirectionBtn } from "../components/Shared";
import SingleSlider from "../components/SingleSlider";
import { BsPlay } from "react-icons/bs";
//import { ReactComponent as HeartIcon } from "../assets/images/icons/header/heart.svg";
//import { Link } from "react-router-dom";
import { BiChevronRight } from "react-icons/bi";
import ProductSlider from "../components/ProductSlider";
import Installment from "../components/Installment";
import Layout from "@/Layouts/Layout";
import { Link, usePage } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import { toast } from "react-toastify";

const SingleProduct = ({ seo }) => {
    const [favorite, setFavorite] = useState(false);
    const [showPopup, setShowPopup] = useState(false);

    const renderHTML = (rawHTML) =>
        React.createElement("div", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

    const {
        product,
        category_path,
        product_images,
        variants,
        similar_products,
        urlPrev,
        localizations,
    } = usePage().props;

    //alert(urlPrev);
    console.log(product, variants);
    let discount;
    discount = product.special_price
        ? 100 - ((product.special_price * 100) / product.price).toFixed()
        : null;

    function goToVideo(video) {
        window.open(
            video.path,
            "_blank" // <- This is what makes it open in a new window.
        );
    }

    function addToCart(product, qty) {
        if (product.quantity >= qty) {
            Inertia.post(route("add-to-cart"), { id: product.id, qty: qty });
        } else {
            toast.warn(__("client.out_of_stock", localizations));
        }
    }

    function buyNow(product, qty) {
        if (product.quantity >= qty) {
            Inertia.post(route("add-to-cart"), {
                id: product.id,
                qty: qty,
                buy_now: true,
            });
        } else {
            toast.warn(__("client.out_of_stock", localizations));
        }
    }

    function addToWishlist(id) {
        Inertia.post(route("client.favorite.add"), { id: id });
    }

    return (
        <Layout seo={seo}>
            <>
                <div className="bg-custom-zinc-200 py-10">
                    <div className="wrapper">
                        <div className="flex justify-start ">
                            <DirectionBtn
                                link={urlPrev}
                                text={__("client.product_back", localizations)}
                                back
                            />
                        </div>
                        <div className="flex items-center justify-start flex-wrap mt-4 text-sm">
                            {category_path.map((item, index) => {
                                if (index + 1 < category_path.length)
                                    return (
                                        <span className="flex items-center justify-start flex-wrap">
                                            <span className="opacity-50 pr-1">
                                                {item.title}
                                            </span>
                                            <span className="opacity-50 pr-1">
                                                {" "}
                                                <BiChevronRight />{" "}
                                            </span>
                                        </span>
                                    );
                                else
                                    return (
                                        <span className="flex items-center justify-start flex-wrap">
                                            <span>{item.title}</span>
                                        </span>
                                    );
                            })}
                            {/*<span className="opacity-50 pr-1">Technic</span>
                          <span className="opacity-50 pr-1">
              {" "}
                              <BiChevronRight />{" "}
            </span>
                          <span className="opacity-50 pr-1">Laptop, Computers, Monitors</span>
                          <span className="opacity-50 pr-1">
              {" "}
                              <BiChevronRight />{" "}
            </span>
                          <span>Gaming PC</span>*/}
                        </div>
                        <div className="flex items-start justify-start pt-10 flex-col lg:flex-row">
                            <div className="lg:w-1/2 w-full lg:mr-10 mb-10">
                                <SingleSlider images={product_images} />
                            </div>
                            <div>
                                <div className="bold text-3xl mb-3">
                                    {product.title}
                                </div>
                                <div className="bold mb-2">
                                    {product.quantity > 0 ? (
                                        <img
                                            className="inline-block mr-2 mb-1"
                                            src="/client/assets/images/icons/checked.png"
                                            alt=""
                                        />
                                    ) : null}
                                    {product.quantity > 0 ? (
                                        <span>
                                            {__(
                                                "client.in_stock",
                                                localizations
                                            )}
                                        </span>
                                    ) : null}

                                    {!product.quantity ? (
                                        <img
                                            className="inline-block mr-2 mb-1"
                                            src="/client/assets/images/icons/cancel.png"
                                            alt=""
                                        />
                                    ) : null}
                                    {!product.quantity ? (
                                        <span>
                                            {__(
                                                "client.out_of_stock",
                                                localizations
                                            )}
                                        </span>
                                    ) : null}
                                </div>
                                {product.attributes.brand ? (
                                    <div className="mb-5 text-sm text-black/[0.5]">
                                        {__("client.made_by", localizations)}:{" "}
                                        <span className="bold text-lg text-black">
                                            {product.attributes.brand.option}
                                        </span>
                                    </div>
                                ) : null}
                                <div className="text-lg bold">
                                    {__(
                                        "client.product_specifications",
                                        localizations
                                    )}
                                </div>
                                <div className="grid grid-cols-1 gap-y-2 gap-x-5 opacity-50 text-sm mb-5 mt-3">
                                    {Object.keys(product.attributes).map(
                                        (item, index) => {
                                            return item !== "brand" ? (
                                                <div>
                                                    {
                                                        product.attributes[item]
                                                            .attribute
                                                    }
                                                    :{" "}
                                                    {
                                                        product.attributes[item]
                                                            .option
                                                    }
                                                </div>
                                            ) : null;
                                        }
                                    )}
                                    {/*<div>Cpu: Intel Core i3-12100</div>
                                  <div>SSD: 256GB</div>
                                  <div>Ram: 8GB</div>
                                  <div>Gpu: Geforce RTX 3090</div>
                                  <div>HDD: 1TB</div>
                                  <div>Psu: 550WA</div>*/}
                                </div>
                                <a
                                    href="#scrollHere"
                                    className=" text-custom-blue mb-5 bg-transparent"
                                >
                                    {__(
                                        "client.product_see_more_details_scroll",
                                        localizations
                                    )}
                                </a>
                                {Object.keys(variants).length > 0 ? (
                                    <div className="mb-4">
                                        <div className="bold mb-2 text-lg">
                                            {__(
                                                "client.choose_color",
                                                localizations
                                            )}
                                        </div>
                                        {/*<ColorPick attribute={{options:[]}} />*/}

                                        {Object.keys(variants).map(
                                            (item, index) => {
                                                return (
                                                    <Link
                                                        className={`inline-block rounded mr-3 mb-2 border-2 border-solid transition-all ${
                                                            product.slug ===
                                                            item
                                                                ? "border-custom-blue"
                                                                : "border-transparent"
                                                        }`}
                                                        href={route(
                                                            "client.product.show",
                                                            item
                                                        )}
                                                    >
                                                        {variants[item]
                                                            .color ? (
                                                            <div
                                                                style={{
                                                                    background:
                                                                        variants[
                                                                            item
                                                                        ].color
                                                                            .option,
                                                                }}
                                                                className=" w-5 h-5"
                                                            ></div>
                                                        ) : null}
                                                    </Link>
                                                );
                                            }
                                        )}
                                    </div>
                                ) : null}
                                {discount ? (
                                    <div className="text-sm">
                                        <span className="text-xs text-white bg-custom-red rounded py-0.5 px-2 mr-2">
                                            {discount}%
                                        </span>
                                        {__(
                                            "client.product_discount",
                                            localizations
                                        )}
                                    </div>
                                ) : null}
                                {product.special_price ? (
                                    <div className="opacity-70  mr-2 mb-0.5 bold relative w-fit h-fit">
                                        <div className="h-px w-full bg-custom-dark absolute left-0 top-2 rotate-12 scale-110"></div>
                                        ₾ {product.price}
                                    </div>
                                ) : null}
                                <div className="text-2xl bold my-5">
                                    {" "}
                                    ₾{" "}
                                    <span className="text-4xl">
                                        {product.special_price
                                            ? product.special_price
                                            : product.price}
                                    </span>{" "}
                                </div>
                                {product.video ? (
                                    <button
                                        onClick={() => {
                                            goToVideo(product.video);
                                        }}
                                        className="flex items-center judtify-start bold text-sm"
                                    >
                                        <div className="flex items-center justify-center w-10 h-10 bg-white shadow-xl rounded-full mr-2">
                                            <BsPlay className="w-6 h-6 " />
                                        </div>
                                        <span>
                                            {__(
                                                "client.product_video",
                                                localizations
                                            )}
                                        </span>
                                    </button>
                                ) : null}
                                <div className="flex justify-start items-center  my-6 flex-wrap">
                                    <button
                                        onClick={() => {
                                            buyNow(product, 1);
                                        }}
                                        className="bg-custom-blue text-white rounded-md bold border-custom-blue  border border-solid py-4 px-10 mr-3 mb-2"
                                    >
                                        {__("client.buy_now", localizations)}
                                    </button>
                                    <button
                                        onClick={() => {
                                            addToCart(product, 1);
                                        }}
                                        className=" rounded-md bold border-custom-blue text-custom-blue border border-solid py-4 px-10 mr-3 mb-2"
                                    >
                                        {__(
                                            "client.add_to_cart",
                                            localizations
                                        )}
                                    </button>
                                    <button
                                        onClick={() => {
                                            setFavorite(!favorite);
                                            addToWishlist(product.id);
                                        }}
                                        className="w-10 h-10 flex justify-center items-center rounded-md bg-custom-zinc-200 mb-2"
                                    >
                                        {/*<HeartIcon
                    className={` ${
                      favorite ? "stroke-red-400" : "stroke-custom-dark"
                    }`}
                  />*/}
                                        <svg
                                            className={` ${
                                                favorite
                                                    ? "stroke-red-400"
                                                    : "stroke-custom-dark"
                                            }`}
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="19.964"
                                            height="17.605"
                                            viewBox="0 0 19.964 17.605"
                                        >
                                            <g
                                                id="Icon_feather-heart"
                                                dataname="Icon feather-heart"
                                                transform="translate(0.75 0.75)"
                                            >
                                                <path
                                                    id="Icon_feather-heart-2"
                                                    dataname="Icon feather-heart"
                                                    d="M19.363,5.921a4.858,4.858,0,0,0-6.872,0l-.936.936-.936-.936a4.859,4.859,0,1,0-6.872,6.872l.936.936L11.555,20.6l6.872-6.872.936-.936a4.858,4.858,0,0,0,0-6.872Z"
                                                    transform="translate(-2.323 -4.497)"
                                                    fill="none"
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth="1.5"
                                                />
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                                {/*<button
                                  onClick={() => setShowPopup(true)}
                                  className="bold underline text-custom-blue"
                              >
                                  {__('client.make_installment',localizations)}
                              </button>*/}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="scrollHere" className="bg-white py-10">
                    <div className="wrapper text-sm pb-20">
                        <div className="text-custom-blue mb-6">
                            {__("client.more_details", localizations)}
                        </div>
                        <div className="lg:columns-3 sm:columns-2 w-full leading-relaxed gap-10">
                            <div className="break-inside-avoid mb-7">
                                {renderHTML(product.description)}
                            </div>
                            {/*<div className="break-inside-avoid mb-7">
                              <p>processor</p>
                              <p>• Processor model: Intel Core i3-12100</p>
                              <p>• Number of cores: 4</p>
                              <p>• Number of streams: 8</p>
                              <p>• Frequency: 3.30 GHz</p>
                              <p>• Maximum frequency: 4.40 GHz</p>
                              <p>• Cache memory: 12 MB</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>RAM</p>
                              <p>Memory capacity: 8GB (1x 8GB DIMM)</p>
                              <p>• Number of cores: 4</p>
                              <p>• Memory type: DDR4</p>
                              <p>• RAM frequency: 3200MHz</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>processor</p>
                              <p>• Processor model: Intel Core i3-12100</p>
                              <p>• Number of cores: 4</p>
                              <p>• Number of streams: 8</p>
                              <p>• Frequency: 3.30 GHz</p>
                              <p>• Maximum frequency: 4.40 GHz</p>
                              <p>• Cache memory: 12 MB</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>RAM</p>
                              <p>Memory capacity: 8GB (1x 8GB DIMM)</p>
                              <p>• Number of cores: 4</p>
                              <p>• Memory type: DDR4</p>
                              <p>• RAM frequency: 3200MHz</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>processor</p>
                              <p>• Processor model: Intel Core i3-12100</p>
                              <p>• Number of cores: 4</p>
                              <p>• Number of streams: 8</p>
                              <p>• Frequency: 3.30 GHz</p>
                              <p>• Maximum frequency: 4.40 GHz</p>
                              <p>• Cache memory: 12 MB</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>RAM</p>
                              <p>Memory capacity: 8GB (1x 8GB DIMM)</p>
                              <p>• Number of cores: 4</p>
                              <p>• Memory type: DDR4</p>
                              <p>• RAM frequency: 3200MHz</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>processor</p>
                              <p>• Processor model: Intel Core i3-12100</p>
                              <p>• Number of cores: 4</p>
                              <p>• Number of streams: 8</p>
                              <p>• Frequency: 3.30 GHz</p>
                              <p>• Maximum frequency: 4.40 GHz</p>
                              <p>• Cache memory: 12 MB</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>RAM</p>
                              <p>Memory capacity: 8GB (1x 8GB DIMM)</p>
                              <p>• Number of cores: 4</p>
                              <p>• Memory type: DDR4</p>
                              <p>• RAM frequency: 3200MHz</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>processor</p>
                              <p>• Processor model: Intel Core i3-12100</p>
                              <p>• Number of cores: 4</p>
                              <p>• Number of streams: 8</p>
                              <p>• Frequency: 3.30 GHz</p>
                              <p>• Maximum frequency: 4.40 GHz</p>
                              <p>• Cache memory: 12 MB</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>RAM</p>
                              <p>Memory capacity: 8GB (1x 8GB DIMM)</p>
                              <p>
                                  * The manufacturer reserves the right to make changes to product
                                  features and design without prior notice. The store does not
                                  take responsibility for changes made by the manufacturer.
                              </p>
                          </div>*/}
                        </div>
                    </div>
                </div>
                <div className="bg-custom-zinc-200 py-10 pb-20">
                    <div className="wrapper">
                        <div className="bold text-lg mb-10">
                            {__("client.you_may_like", localizations)}
                        </div>
                        <ProductSlider products={similar_products} />
                    </div>
                </div>
                <Installment
                    product={product}
                    show={showPopup}
                    hide={() => setShowPopup(false)}
                />
            </>
        </Layout>
    );
};

export default SingleProduct;
