import React from "react";
//import { Link } from "react-router-dom";
import { Link, usePage } from "@inertiajs/inertia-react";
//import { ReactComponent as HeartIcon } from "../assets/images/icons/header/heart.svg";
//import { ReactComponent as CartIcon } from "../assets/images/icons/header/cart.svg";
import { useState } from "react";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Inertia } from "@inertiajs/inertia";

const ProductBox = (props) => {
    const { localizations } = usePage().props;

    const [favorite, setFavorite] = useState(false);
    const [addToCart, setAddToCart] = useState(false);

    const toCart = () => {
        setAddToCart(!addToCart);
        if (props.qty >= 1) {
            toast.success(__("client.added_to_cart", localizations));
        }
    };

    const toFavorites = () => {
        setFavorite(!favorite);
        toast.info(__("client.added_to_favorites", localizations));
    };

    function addToWishlist(id) {
        Inertia.post(route("client.favorite.add"), { id: id });
    }

    function addToCartF(id) {
        if (props.qty >= 1) {
            Inertia.post(route("add-to-cart"), { id: id, qty: 1 });
        } else {
            toast.warn(__("client.out_of_stock", localizations));
        }
    }

    return (
        <>
            <div className="bg-white rounded p-5 text-sm relative">
                {props.oldPrice ? (
                    <div className="absolute top-5 left-5 text-xs text-white bg-custom-red rounded py-0.5 px-2">
                        {props.discount}%
                    </div>
                ) : (
                    ""
                )}
                <div className="absolute top-5 right-5">
                    <button
                        onClick={() => {
                            toFavorites();
                            addToWishlist(props.id);
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
                                data-name="Icon feather-heart"
                                transform="translate(0.75 0.75)"
                            >
                                <path
                                    id="Icon_feather-heart-2"
                                    data-name="Icon feather-heart"
                                    d="M19.363,5.921a4.858,4.858,0,0,0-6.872,0l-.936.936-.936-.936a4.859,4.859,0,1,0-6.872,6.872l.936.936L11.555,20.6l6.872-6.872.936-.936a4.858,4.858,0,0,0,0-6.872Z"
                                    transform="translate(-2.323 -4.497)"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                />
                            </g>
                        </svg>
                    </button>
                    <button
                        onClick={() => {
                            toCart();
                            addToCartF(props.id);
                        }}
                        className="w-10 h-10 flex justify-center items-center rounded-md bg-custom-zinc-200"
                    >
                        {/*<CartIcon
              className={` ${
                addToCart ? "fill-green-500" : "fill-custom-dark"
              }`}
            />*/}
                        <svg
                            className={` ${
                                addToCart
                                    ? "fill-green-500"
                                    : "fill-custom-dark"
                            }`}
                            id="Component_45_1"
                            data-name="Component 45 – 1"
                            xmlns="http://www.w3.org/2000/svg"
                            width="18.475"
                            height="16.105"
                            viewBox="0 0 18.475 16.105"
                        >
                            <path
                                id="Path_1"
                                data-name="Path 1"
                                d="M262.387,193.239a.734.734,0,0,0-.58-.285h-2.14l-2.841-4.933a.732.732,0,1,0-1.27.731l2.42,4.2h-9.349l2.42-4.2a.733.733,0,1,0-1.27-.731l-2.841,4.933H244.8a.732.732,0,0,0-.709.918l2.442,9.339a.733.733,0,0,0,.709.547h12.127a.733.733,0,0,0,.708-.547l2.442-9.339a.731.731,0,0,0-.128-.633Zm-3.587,9.055h-11l-2.059-7.874h15.113Z"
                                transform="translate(-244.064 -187.654)"
                                stroke=" none"
                            />
                        </svg>
                    </button>
                </div>

                <div className="w-4/5 h-60  mb-4 mx-auto">
                    <Link
                        href={props.link}
                        className="underline text-custom-blue "
                    >
                        <img
                            style={{ cursor: "pointer" }}
                            onClick={() => {
                                Inertia.visit(props.link);
                            }}
                            className=" w-full h-full object-contain"
                            src={props.img}
                            alt=""
                        />
                    </Link>
                </div>

                <div
                    className=" mb-1 uppercase"
                    style={{ height: "40px", overflow: "hidden" }}
                >
                    {props.name}
                </div>
                <div className="opacity-50  mb-2" style={{ height: "20px" }}>
                    {props.brand}
                </div>
                <div className="flex mb-3 items-end justify-start">
                    {props.oldPrice ? (
                        <div className="opacity-70  mr-2 mb-0.5 bold relative">
                            <div className="h-px w-full bg-custom-dark absolute left-0 top-2 rotate-12 scale-110"></div>
                            ₾ {props.oldPrice}
                        </div>
                    ) : (
                        ""
                    )}
                    <div className="bold">
                        ₾ <span className="text-xl ">{props.price}</span>
                    </div>
                </div>
            </div>
        </>
    );
};

export default ProductBox;
