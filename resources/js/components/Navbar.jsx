import React, { useState } from "react";
import { Link, usePage } from "@inertiajs/inertia-react";
import { BiChevronDown, BiChevronRight } from "react-icons/bi";
import { FiSearch } from "react-icons/fi";
import { Inertia } from "@inertiajs/inertia";
import { IoIosArrowRoundBack } from "react-icons/io";

const Navbar = () => {
    const [openMenu, setOpenMenu] = useState(false);

    const [catIndex, setCatIndex] = useState(0);
    const [subCatIndex, setSubCatIndex] = useState(0);

    const [mobileCatState, setMobileCatState] = useState(0);

    const mainCatClick = (index) => {
        //alert(index);
        setCatIndex(index + 1);
        setSubCatIndex(0);
        setMobileCatState(1);
    };

    const {
        locales,
        currentLocale,
        locale_urls,
        cart_count,
        wishlist_count,
        categories,
        localizations,
    } = usePage().props;

    let subCategories = [];
    let subCategories2 = {};
    let n = 0;

    function toSubCategory(slug) {
        Inertia.visit(route("proxy", slug));
    }

    function handleSubmit(e) {
        e.preventDefault();
        Inertia.get(route("search.index"), {
            term: document.getElementById("search_inp").value,
        });
    }
    function handleSubmitMob(e) {
        e.preventDefault();
        Inertia.get(route("search.index"), {
            term: document.getElementById("search_inp_mob").value,
        });
    }

    return (
        <>
            <header className="fixed w-full left-0 top-0 md:bg-white/[0.9] bg-white  py-4 after:backdrop-blur-md after:left-0 after:top-0 after:w-full after:h-full after:-z-10 z-50">
                <div className="wrapper flex justify-between items-center relative z-10">
                    <Link href={route("client.home.index")}>
                        <img src="/client/assets/images/logo/1.png" alt="" />
                    </Link>
                    <button
                        onClick={() => setOpenMenu(!openMenu)}
                        className="flex items-center justify-center order-last md:order-none"
                    >
                        <div
                            className={`menuButton mr-2 ${
                                openMenu ? "clicked" : ""
                            }`}
                        >
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <div className="text-left text-sm md:inline-block hidden">
                            <div className="opacity-50 text-xs -mb-1">
                                {openMenu
                                    ? __("client.nav_select", localizations)
                                    : __("client.nav_close", localizations)}
                                <BiChevronDown
                                    className="inline-block align-middle w-4 h-4  transition-all duration-300 "
                                    style={{ rotate: openMenu ? "180deg" : "" }}
                                />
                            </div>
                            {__("client.nav_categories", localizations)}
                        </div>
                    </button>
                    <div className="h-10 w-1/3 mx-5 relative text-sm  hidden md:inline-block">
                        <form onSubmit={handleSubmitMob} className="h-full">
                            <input
                                className="w-full h-full bg-custom-zinc-100 text-center placeholder:opacity-40 border-solid border-1 border-custom-dark"
                                type="text"
                                placeholder={__(
                                    "client.search_here",
                                    localizations
                                )}
                                name="term"
                                id="search_inp_mob"
                            />
                        </form>

                        <FiSearch className="absolute top-1/2 -translate-y-1/2 right-2 stroke-custom-dark w-5 h-5" />
                    </div>
                    <div className="flex md:ml-20 ">
                        <div className="group relative ">
                            <button className="align-middle">
                                <svg
                                    className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="17.605"
                                    height="17.605"
                                    viewBox="0 0 17.605 17.605"
                                >
                                    <g
                                        id="Icon_feather-globe"
                                        dataname="Icon feather-globe"
                                        transform="translate(0.75 0.75)"
                                    >
                                        <path
                                            id="Path_6"
                                            dataname="Path 6"
                                            d="M19.1,11.052A8.052,8.052,0,1,1,11.052,3,8.052,8.052,0,0,1,19.1,11.052Z"
                                            transform="translate(-3 -3)"
                                            fill="none"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="1.5"
                                        />
                                        <path
                                            id="Path_7"
                                            dataname="Path 7"
                                            d="M3,18H19.1"
                                            transform="translate(-3 -9.948)"
                                            fill="none"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="1.5"
                                        />
                                        <path
                                            id="Path_8"
                                            dataname="Path 8"
                                            d="M15.221,3a12.32,12.32,0,0,1,3.221,8.052A12.32,12.32,0,0,1,15.221,19.1,12.32,12.32,0,0,1,12,11.052,12.32,12.32,0,0,1,15.221,3Z"
                                            transform="translate(-7.169 -3)"
                                            fill="none"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="1.5"
                                        />
                                    </g>
                                </svg>
                            </button>
                            <div
                                className={`absolute bg-white w-10 py-3 transition-all duration-300 top-full left-1/2 -translate-x-1/2 text-sm lg:text-base z-50 rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible`}
                            >
                                {Object.keys(locales).map((name, index) => {
                                    if (locales[name] !== currentLocale) {
                                        return (
                                            <a
                                                key={index}
                                                className={`opacity-30 block transition-all duration-300  px-2 `}
                                                href={locale_urls[name]}
                                            >
                                                <img
                                                    className="w-6 h-6 "
                                                    src={`/client/assets/images/icons/header/${name}.png`}
                                                    alt=""
                                                />
                                            </a>
                                        );
                                    } else {
                                        return (
                                            <a
                                                className={`opacity-100 block transition-all duration-300  px-2  `}
                                                href="javascript:;"
                                            >
                                                {" "}
                                                <img
                                                    className="w-6 h-6 "
                                                    src={`/client/assets/images/icons/header/${name}.png`}
                                                    alt=""
                                                />
                                            </a>
                                        );
                                    }
                                })}
                            </div>
                        </div>
                        <Link
                            className="py-1 relative group  lg:ml-5 ml-3"
                            href={route("client.login.index")}
                        >
                            <svg
                                className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue"
                                id="Component_44_1"
                                dataname="Component 44 – 1"
                                xmlns="http://www.w3.org/2000/svg"
                                width="13.176"
                                height="16.105"
                                viewBox="0 0 13.176 16.105"
                            >
                                <path
                                    id="Path_4"
                                    dataname="Path 4"
                                    d="M214.392,32.114a4.392,4.392,0,1,0-3.106-1.286A4.393,4.393,0,0,0,214.392,32.114Zm0-7.32a2.928,2.928,0,1,1-2.07.858,2.928,2.928,0,0,1,2.07-.858Z"
                                    transform="translate(-207.804 -23.33)"
                                    stroke="none"
                                />
                                <path
                                    id="Path_5"
                                    dataname="Path 5"
                                    d="M149.518,350h-5.856a3.66,3.66,0,0,0-3.66,3.66,2.2,2.2,0,0,0,2.2,2.2h8.784a2.2,2.2,0,0,0,2.2-2.2,3.66,3.66,0,0,0-3.66-3.66Zm1.464,4.392H142.2a.732.732,0,0,1-.732-.732,2.2,2.2,0,0,1,2.2-2.2h5.856a2.2,2.2,0,0,1,2.2,2.2.732.732,0,0,1-.732.732Z"
                                    transform="translate(-140.002 -339.752)"
                                    stroke="none"
                                />
                            </svg>
                            <p className="text-xs whitespace-nowrap text-custom-blue absolute left-1/2 -translate-x-1/2 top-full group-hover:opacity-100 opacity-0 transition-all duration-300">
                                {__("client.signin_up", localizations)}
                            </p>
                        </Link>
                        <Link
                            className="py-1 relative group lg:ml-5 ml-3"
                            href={route("client.favorite.index")}
                        >
                            <svg
                                className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue"
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

                            {wishlist_count > 0 ? (
                                <button className="absolute bottom-4 left-3 w-5 h-5 rounded-full bg-custom-blue text-white text-xs ">
                                    {wishlist_count}
                                </button>
                            ) : null}
                            <p className="text-xs whitespace-nowrap text-custom-blue absolute left-1/2 -translate-x-1/2 top-full group-hover:opacity-100 opacity-0 transition-all duration-300">
                                {__("client.favorite", localizations)}
                            </p>
                        </Link>
                        <Link
                            className="py-1 relative group lg:ml-5 ml-3"
                            href={route("client.cart.index")}
                        >
                            <svg
                                className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue"
                                id="Component_45_1"
                                dataname="Component 45 – 1"
                                xmlns="http://www.w3.org/2000/svg"
                                width="18.475"
                                height="16.105"
                                viewBox="0 0 18.475 16.105"
                            >
                                <path
                                    id="Path_1"
                                    dataname="Path 1"
                                    d="M262.387,193.239a.734.734,0,0,0-.58-.285h-2.14l-2.841-4.933a.732.732,0,1,0-1.27.731l2.42,4.2h-9.349l2.42-4.2a.733.733,0,1,0-1.27-.731l-2.841,4.933H244.8a.732.732,0,0,0-.709.918l2.442,9.339a.733.733,0,0,0,.709.547h12.127a.733.733,0,0,0,.708-.547l2.442-9.339a.731.731,0,0,0-.128-.633Zm-3.587,9.055h-11l-2.059-7.874h15.113Z"
                                    transform="translate(-244.064 -187.654)"
                                    stroke=" none"
                                />
                            </svg>

                            {cart_count > 0 ? (
                                <button className="absolute bottom-4 left-3 w-5 h-5 rounded-full bg-custom-blue text-white text-xs ">
                                    {cart_count}
                                </button>
                            ) : null}
                            <p className="text-xs whitespace-nowrap text-custom-blue absolute left-1/2 -translate-x-1/2 top-full group-hover:opacity-100 opacity-0 transition-all duration-300 pt-px">
                                {__("client.cart", localizations)}
                            </p>
                        </Link>
                    </div>
                </div>
                <div className="wrapper py-2 block  md:hidden">
                    <div className="h-10 w-full  relative text-sm">
                        <form onSubmit={handleSubmit} className="h-full">
                            <input
                                className="w-full h-full bg-custom-zinc-100 text-center placeholder:opacity-40 border-solid border-1 border-custom-dark"
                                type="text"
                                placeholder={__(
                                    "client.search_here",
                                    localizations
                                )}
                                name="term"
                                id="search_inp"
                            />
                        </form>

                        <FiSearch className="absolute top-1/2 -translate-y-1/2 right-2 stroke-custom-dark w-5 h-5" />
                    </div>
                </div>

                {/* category start */}
                <div
                    onMouseLeave={() => {
                        setCatIndex("1000");
                        setSubCatIndex("1000");
                    }}
                    className={`categories absolute left-0 top-full w-full transition-all duration-500 lg:text-base text-sm  ${
                        openMenu
                            ? "translate-y-0 top-full"
                            : "-translate-y-full -top-full"
                    }`}
                >
                    <div className="w-full h-full  md:bg-white/[0.9] bg-white backdrop-blur-md py-10 ">
                        <div className="wrapper flex items-start justify-start relative">
                            <div className="md:pr-10 pr-5 md:mr-10 mr-5  cat-0">
                                {categories.map((item, index) => {
                                    subCategories.push(item.children);

                                    console.log(subCategories);
                                    return (
                                        <button
                                            onMouseEnter={() =>
                                                mainCatClick(index)
                                            }
                                            key={index + 1}
                                            className={`mb-3 block hover:text-custom-blue transition-all text-left ${
                                                index + 1 === catIndex
                                                    ? "text-custom-blue"
                                                    : ""
                                            }`}
                                        >
                                            {item.title}
                                        </button>
                                    );
                                })}
                            </div>
                            <div
                                className={`transition-all duration-500 cat-1
                                  ${
                                      catIndex === 0
                                          ? "invisible opacity-0 -translate-x-full"
                                          : "visible opacity-100 translate-x-0"
                                  }
                                  ${mobileCatState === 1 ? "show" : ""}
                               `}
                            >
                                <button
                                    className="md:hidden"
                                    onClick={() => setMobileCatState(0)}
                                >
                                    <IoIosArrowRoundBack className="w-8 h-8" />
                                </button>
                                {subCategories.map((cat, index) => {
                                    let children = [];
                                    return (
                                        <div
                                            key={index}
                                            className={`${
                                                catIndex === index + 1
                                                    ? "block"
                                                    : "hidden"
                                            } md:mr-20 mr-10 `}
                                        >
                                            {cat.map((item, index) => {
                                                subCategories2[item.id] =
                                                    item.children;
                                                console.log(subCategories2);
                                                return (
                                                    <Link
                                                        href={
                                                            item.children > 0
                                                                ? "/"
                                                                : route(
                                                                      "proxy",
                                                                      item.url_path
                                                                  )
                                                        }
                                                        key={index + 1}
                                                        onClick={(e) => {
                                                            if (
                                                                item.children
                                                                    .length > 0
                                                            ) {
                                                                e.preventDefault();
                                                                setSubCatIndex(
                                                                    item.id
                                                                );
                                                                setMobileCatState(
                                                                    2
                                                                );
                                                            } else {
                                                                toSubCategory(
                                                                    item.url_path
                                                                );
                                                            }

                                                            //alert(subCatIndex)
                                                        }}
                                                        onMouseEnter={() => {
                                                            if (
                                                                item.children
                                                                    .length > 0
                                                            ) {
                                                                setSubCatIndex(
                                                                    item.id
                                                                );
                                                            }
                                                        }}
                                                        className={`block mb-3 hover:text-custom-blue hover:fill-custom-blue transition-all text-left ${
                                                            item.id ===
                                                            subCatIndex
                                                                ? "text-custom-blue fill-custom-blue"
                                                                : ""
                                                        }`}
                                                    >
                                                        {item.title}
                                                        {item.children.length >
                                                        0 ? (
                                                            <BiChevronRight className="inline-block w-5 h-5 fill-inherit" />
                                                        ) : null}
                                                    </Link>
                                                );
                                            })}
                                        </div>
                                    );
                                })}
                            </div>
                            <div
                                className={` transition-all duration-500 cat-2
                                   ${
                                       subCatIndex === 0
                                           ? "invisible opacity-0 -translate-x-full"
                                           : "visible opacity-100 translate-x-0"
                                   }
                                   ${mobileCatState === 2 ? "show" : ""}
                                `}
                            >
                                <button
                                    className="md:hidden"
                                    onClick={() => setMobileCatState(1)}
                                >
                                    <IoIosArrowRoundBack className="w-8 h-8" />
                                </button>
                                {Object.keys(subCategories2).map(
                                    (cat, index) => {
                                        cat = parseInt(cat);
                                        return (
                                            <div
                                                key={index}
                                                className={`${
                                                    subCatIndex === cat
                                                        ? "block"
                                                        : "hidden"
                                                } `}
                                            >
                                                {subCategories2[cat].map(
                                                    (item, index) => {
                                                        return (
                                                            <Link
                                                                key={index}
                                                                href={route(
                                                                    "proxy",
                                                                    item.url_path
                                                                )}
                                                                className={`block mb-3 hover:text-custom-blue hover:fill-custom-blue transition-all `}
                                                            >
                                                                {item.title}
                                                            </Link>
                                                        );
                                                    }
                                                )}
                                            </div>
                                        );
                                    }
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </>
    );
};

export default Navbar;
