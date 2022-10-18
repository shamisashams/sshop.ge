import React from "react";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
//import Logo from "../assets/images/logo/1.png";
import { BiChevronDown, BiChevronRight } from "react-icons/bi";
import { FiSearch } from "react-icons/fi";
//import { ReactComponent as GlobeIcon } from "../assets/images/icons/header/globe.svg";
//import { ReactComponent as UserIcon } from "../assets/images/icons/header/user.svg";
//import { ReactComponent as HeartIcon } from "../assets/images/icons/header/heart.svg";
//import { ReactComponent as CartIcon } from "../assets/images/icons/header/cart.svg";
import { useState } from "react";
import { mainCategory, subCategory, catProducts } from "./Data";
import { Inertia } from "@inertiajs/inertia";

const Navbar = () => {
  const [showLang, setShowLang] = useState(false);
  const [openMenu, setOpenMenu] = useState(false);

  const [catIndex, setCatIndex] = useState(0);
  const [subCatIndex, setSubCatIndex] = useState(0);

  const mainCatClick = (index) => {
      //alert(index);
    setCatIndex(index + 1);
    setSubCatIndex(0);
  };

    const { locales, currentLocale, locale_urls, cart_count, wishlist_count, categories, localizations } = usePage().props;

    let subCategories = [];
    let subCategories2 = {};
    let n = 0;

    function toSubCategory(slug){
        Inertia.visit(route('client.category.show',slug));
    }

  return (
    <>
      <header className="fixed w-full left-0 top-0 bg-white/[0.9]  py-4 after:backdrop-blur-md after:left-0 after:top-0 after:w-full after:h-full after:z-0 z-50">
        <div className="wrapper flex justify-between items-center relative z-10">
          <Link href={route('client.home.index')}>
            <img src="/client/assets/images/logo/1.png" alt="" />
          </Link>
          <button
            onClick={() => setOpenMenu(!openMenu)}
            className="flex items-center justify-center"
          >
            <div className={`menuButton mr-2 ${openMenu ? "clicked" : ""}`}>
              <div></div>
              <div></div>
              <div></div>
            </div>
            <div className="text-left text-sm">
              <div className="opacity-50 text-xs -mb-1">
                {openMenu ? __('client.nav_select',localizations) : __('client.nav_close',localizations)}
                <BiChevronDown
                  className="inline-block align-middle w-4 h-4  transition-all duration-300 "
                  style={{ rotate: openMenu ? "180deg" : "" }}
                />
              </div>
                {__('client.nav_categories',localizations)}
            </div>
          </button>
          <div className="h-10 w-1/3 mx-5 relative text-sm  hidden md:inline-block">
              <form action={route('search.index')}>
                  <input
                      className="w-full h-full bg-custom-zinc-100 text-center border-none placeholder:opacity-40"
                      type="text"
                      placeholder={__('client.search_here',localizations)}
                      name="term"
                  />
              </form>

            <FiSearch className="absolute top-1/2 -translate-y-1/2 right-2 stroke-custom-dark w-5 h-5" />
          </div>
          <div className="md:flex ml-20 hidden">
            <div className="group relative ">
              <button onClick={() => setShowLang(!showLang)}>
                {/*<GlobeIcon
                  className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue"
                  style={{ stroke: showLang ? "#4FA9D2" : "" }}
                />*/}
                  <svg className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue" style={{ stroke: showLang ? "#4FA9D2" : "" }} xmlns="http://www.w3.org/2000/svg" width="17.605" height="17.605" viewBox="0 0 17.605 17.605">
                      <g id="Icon_feather-globe" data-name="Icon feather-globe" transform="translate(0.75 0.75)">
                          <path id="Path_6" data-name="Path 6" d="M19.1,11.052A8.052,8.052,0,1,1,11.052,3,8.052,8.052,0,0,1,19.1,11.052Z" transform="translate(-3 -3)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                          <path id="Path_7" data-name="Path 7" d="M3,18H19.1" transform="translate(-3 -9.948)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                          <path id="Path_8" data-name="Path 8" d="M15.221,3a12.32,12.32,0,0,1,3.221,8.052A12.32,12.32,0,0,1,15.221,19.1,12.32,12.32,0,0,1,12,11.052,12.32,12.32,0,0,1,15.221,3Z" transform="translate(-7.169 -3)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                      </g>
                  </svg>

              </button>
              <div
                className={`absolute flex transition-all duration-300 top-0 right-full text-sm lg:text-base ${
                  showLang
                    ? "opacity-100 visible lg:pr-3 pr-1"
                    : "opacity-0 invisible"
                }`}
              >

                  {Object.keys(locales).map((name, index) => {
                      if (locales[name] !== currentLocale) {
                          return (
                          <a
                              className={`opacity-50  transition-all duration-300 ${
                                  showLang ? "ml-2" : "-ml-3"
                              } `}
                              href={locale_urls[name]}
                          >
                              {name}
                          </a>
                          );
                      } else {
                          return (
                              <a
                                  className={`opacity-100 transition-all duration-300  ${
                                      showLang ? "ml-2" : "-ml-3"
                                  }  `}
                                  href="javascript:;"
                              >
                                  {name}
                              </a>
                          )
                      }
                  })}

                {/*<a
                  className={`opacity-50  transition-all duration-300 ${
                    showLang ? "ml-2" : "-ml-3"
                  } `}
                  href="#"
                >
                  Geo
                </a>
                <a
                  className={`opacity-100 transition-all duration-300  ${
                    showLang ? "ml-2" : "-ml-3"
                  }  `}
                  href="#"
                >
                  Eng
                </a>
                <a
                  className={`opacity-50  transition-all duration-300 ${
                    showLang ? "ml-2" : "-ml-3"
                  } `}
                  href="#"
                >
                  Rus
                </a>*/}
              </div>
            </div>
            <Link className=" group  lg:ml-5 ml-3" href={route("client.login.index")}>
              {/*<UserIcon className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue" />*/}
                <svg className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue" id="Component_44_1" data-name="Component 44 – 1" xmlns="http://www.w3.org/2000/svg" width="13.176" height="16.105" viewBox="0 0 13.176 16.105">
                    <path id="Path_4" data-name="Path 4" d="M214.392,32.114a4.392,4.392,0,1,0-3.106-1.286A4.393,4.393,0,0,0,214.392,32.114Zm0-7.32a2.928,2.928,0,1,1-2.07.858,2.928,2.928,0,0,1,2.07-.858Z" transform="translate(-207.804 -23.33)" stroke="none" />
                    <path id="Path_5" data-name="Path 5" d="M149.518,350h-5.856a3.66,3.66,0,0,0-3.66,3.66,2.2,2.2,0,0,0,2.2,2.2h8.784a2.2,2.2,0,0,0,2.2-2.2,3.66,3.66,0,0,0-3.66-3.66Zm1.464,4.392H142.2a.732.732,0,0,1-.732-.732,2.2,2.2,0,0,1,2.2-2.2h5.856a2.2,2.2,0,0,1,2.2,2.2.732.732,0,0,1-.732.732Z" transform="translate(-140.002 -339.752)" stroke="none" />
                </svg>

            </Link>
            <Link className="relative group lg:ml-5 ml-3" href={route("client.favorite.index")}>
              {/*<HeartIcon className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue" />*/}
                <svg className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue" xmlns="http://www.w3.org/2000/svg" width="19.964" height="17.605" viewBox="0 0 19.964 17.605">
                    <g id="Icon_feather-heart" data-name="Icon feather-heart" transform="translate(0.75 0.75)">
                        <path id="Icon_feather-heart-2" data-name="Icon feather-heart" d="M19.363,5.921a4.858,4.858,0,0,0-6.872,0l-.936.936-.936-.936a4.859,4.859,0,1,0-6.872,6.872l.936.936L11.555,20.6l6.872-6.872.936-.936a4.858,4.858,0,0,0,0-6.872Z" transform="translate(-2.323 -4.497)" fill="none"  stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                    </g>
                </svg>


                {wishlist_count > 0 ? <button className="absolute bottom-4 left-3 w-5 h-5 rounded-full bg-custom-blue text-white text-xs ">
                    {wishlist_count}
              </button>:null}
            </Link>
            <Link className="relative group lg:ml-5 ml-3" href={route("client.cart.index")}>
              {/*<CartIcon className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue" />*/}
                <svg className="transition-all duration-300 fill-custom-dark stroke-custom-dark group-hover:stroke-custom-blue group-hover:fill-custom-blue" id="Component_45_1" data-name="Component 45 – 1" xmlns="http://www.w3.org/2000/svg" width="18.475" height="16.105" viewBox="0 0 18.475 16.105">
                    <path id="Path_1" data-name="Path 1" d="M262.387,193.239a.734.734,0,0,0-.58-.285h-2.14l-2.841-4.933a.732.732,0,1,0-1.27.731l2.42,4.2h-9.349l2.42-4.2a.733.733,0,1,0-1.27-.731l-2.841,4.933H244.8a.732.732,0,0,0-.709.918l2.442,9.339a.733.733,0,0,0,.709.547h12.127a.733.733,0,0,0,.708-.547l2.442-9.339a.731.731,0,0,0-.128-.633Zm-3.587,9.055h-11l-2.059-7.874h15.113Z" transform="translate(-244.064 -187.654)" stroke=" none"/>
                </svg>

                {cart_count > 0 ? <button className="absolute bottom-4 left-3 w-5 h-5 rounded-full bg-custom-blue text-white text-xs ">
                    {cart_count}
              </button>:null}
            </Link>
          </div>
        </div>
        <div
          className={`absolute left-0 top-full w-full transition-all duration-500 lg:text-base text-sm  ${
            openMenu ? "translate-y-0 top-full" : "-translate-y-full -top-full"
          }`}
        >
          <div className="w-full h-full bg-white/[0.9] backdrop-blur-md py-10 ">
            <div className="wrapper flex items-start justify-start">
              <div className="scrollbar overflow-y-scroll md:pr-10 pr-5 md:mr-10 mr-5 ">
                {categories.map((item, index) => {

                        subCategories.push(item.children);

                    console.log(subCategories);
                  return (
                    <button
                      onClick={() => mainCatClick(index)}
                      key={index + 1}
                      className={`mb-3 block hover:text-custom-blue transition-all text-left ${
                        index + 1 === catIndex ? "text-custom-blue" : ""
                      }`}
                    >
                      {item.title}
                    </button>
                  );
                })}
              </div>
              <div className={catIndex === 0 ? "hidden" : "block"}>
                {subCategories.map((cat, index) => {

                    let children = [];
                  return (
                    <div
                      key={index}
                      className={`${
                        catIndex === index + 1 ? "block" : "hidden"
                      } md:mr-20 mr-10 `}
                    >
                      {cat.map((item, index) => {
                          subCategories2[item.id] = item.children;
                          console.log(subCategories2);
                        return (
                          <button
                            key={index + 1}
                            onClick={() => {
                                if (item.children.length > 0){
                                    setSubCatIndex(item.id)
                                } else {
                                    toSubCategory(item.slug);
                                }

                                //alert(subCatIndex)
                            }}
                            className={`block mb-3 hover:text-custom-blue hover:fill-custom-blue transition-all text-left ${
                                item.id === subCatIndex
                                ? "text-custom-blue fill-custom-blue"
                                : ""
                            }`}
                          >
                            {item.title}
                              {item.children.length > 0 ? <BiChevronRight className="inline-block w-5 h-5 fill-inherit" />:null}
                          </button>
                        );
                      })}
                    </div>
                  );
                })}
              </div>
              <div className={subCatIndex === 0 ? "hidden" : "block"}>
                {Object.keys(subCategories2).map((cat, index) => {
                    cat = parseInt(cat);
                  return (
                    <div
                      key={index}
                      className={`${
                        subCatIndex === cat ? "block" : "hidden"
                      } `}
                    >
                      {subCategories2[cat].map((item, index) => {
                        return (
                          <Link
                            key={index}
                            href={route('client.category.show',item.slug)}
                            className={`block mb-3 hover:text-custom-blue hover:fill-custom-blue transition-all `}
                          >
                            {item.title}
                          </Link>
                        );
                      })}
                    </div>
                  );
                })}
              </div>
            </div>
          </div>
        </div>
      </header>
    </>
  );
};

export default Navbar;
