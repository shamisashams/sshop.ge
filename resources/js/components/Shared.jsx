import React from "react";
import { useRef, useState } from "react";
//import { Link } from "react-router-dom";
import {Link, usePage} from '@inertiajs/inertia-react'
//import { ReactComponent as FBIcon } from "../assets/images/icons/sm/fb.svg";
//import { ReactComponent as IGIcon } from "../assets/images/icons/sm/ig.svg";
//import { ReactComponent as Arrow } from "../assets/images/icons/arrow-b.svg";
//import { ReactComponent as Delete } from "../assets/images/icons/delete.svg";
import { colors } from "./Data";
import { BiChevronDown } from "react-icons/bi";
import { HiOutlineMinus, HiOutlinePlus } from "react-icons/hi";
import {Inertia} from "@inertiajs/inertia";
import {toast} from "react-toastify";

export const LocationMap = () => {
  return (
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d95218.65792278551!2d44.7676416!3d41.7726464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sge!4v1663743397718!5m2!1sen!2sge"
      width="100%"
      height="100%"
      style={{ border: "0" }}
      allowFullScreen=""
      loading="lazy"
      referrerPolicy="no-referrer-when-downgrade"
    ></iframe>
  );
};

export const SocialMedia = () => {
    const {info} = usePage().props;
  return (
    <div className="flex items-center justify-end">
      <a target="_blank" href={info.facebook}>
        {/*<FBIcon className="fill-custom-dark hover:fill-custom-blue transition-all" />*/}
          <svg className="fill-custom-dark hover:fill-custom-blue transition-all" xmlns="http://www.w3.org/2000/svg" width="25.151" height="25.151" viewBox="0 0 25.151 25.151">
              <path id="facebook-rect" d="M4.592,0A4.582,4.582,0,0,0,0,4.592V20.558A4.582,4.582,0,0,0,4.592,25.15h8.653V15.318h-2.6v-3.54h2.6V8.754c0-2.376,1.536-4.558,5.075-4.558a21.442,21.442,0,0,1,2.492.138L20.729,7.64s-1.081-.01-2.259-.01c-1.276,0-1.48.588-1.48,1.564v2.585h3.842l-.168,3.54H16.99v9.833h3.569a4.582,4.582,0,0,0,4.592-4.592V4.592A4.582,4.582,0,0,0,20.559,0Z" />
          </svg>

      </a>
      <a target="_blank" href={info.instagram} className="ml-4">
        {/*<IGIcon className="fill-custom-dark hover:fill-custom-blue transition-all" />*/}
          <svg className="fill-custom-dark hover:fill-custom-blue transition-all" xmlns="http://www.w3.org/2000/svg" width="25.152" height="25.151" viewBox="0 0 25.152 25.151">
              <path id="instagram" d="M15.575,3c-3.415,0-3.843.015-5.184.075a9.255,9.255,0,0,0-3.052.585A6.427,6.427,0,0,0,3.66,7.338a9.272,9.272,0,0,0-.585,3.052C3.014,11.732,3,12.16,3,15.575s.014,3.843.075,5.184a9.255,9.255,0,0,0,.585,3.052A6.425,6.425,0,0,0,7.339,27.49a9.272,9.272,0,0,0,3.052.585c1.341.06,1.77.075,5.184.075s3.843-.015,5.184-.075a9.255,9.255,0,0,0,3.052-.585,6.425,6.425,0,0,0,3.679-3.679,9.272,9.272,0,0,0,.585-3.052c.06-1.341.075-1.77.075-5.184s-.015-3.843-.075-5.184a9.255,9.255,0,0,0-.585-3.052A6.425,6.425,0,0,0,23.813,3.66a9.272,9.272,0,0,0-3.052-.585C19.418,3.015,18.99,3,15.575,3m0,2.266c3.358,0,3.755.013,5.08.073a6.986,6.986,0,0,1,2.336.433,4.163,4.163,0,0,1,2.387,2.387,6.979,6.979,0,0,1,.433,2.335c.06,1.327.073,1.723.073,5.082s-.013,3.755-.073,5.08a7.031,7.031,0,0,1-.433,2.336,4.163,4.163,0,0,1-2.387,2.387,6.979,6.979,0,0,1-2.335.433c-1.325.06-1.723.073-5.082.073s-3.757-.013-5.08-.073a7.031,7.031,0,0,1-2.336-.433,4.163,4.163,0,0,1-2.387-2.387,6.935,6.935,0,0,1-.433-2.335c-.06-1.327-.073-1.723-.073-5.082s.013-3.755.073-5.08a6.986,6.986,0,0,1,.433-2.336A4.163,4.163,0,0,1,8.158,5.772a6.935,6.935,0,0,1,2.335-.433c1.327-.06,1.723-.073,5.082-.073m0,14.5a4.191,4.191,0,1,1,4.192-4.191,4.191,4.191,0,0,1-4.192,4.191m0-10.649a6.457,6.457,0,1,0,6.457,6.457,6.457,6.457,0,0,0-6.457-6.457M23.8,8.863a1.509,1.509,0,1,1-1.509-1.509A1.509,1.509,0,0,1,23.8,8.863" transform="translate(-3 -3)" fill-rule="evenodd"/>
          </svg>

      </a>
    </div>
  );
};

export const DirectionBtn = ({ link, text, back }) => {
  return (
    <Link
      href={link}
      className="flex items-center justify-center text-custom-blue text-sm sm:text-base whitespace-nowrap w-fit"
    >
      <span>{text}</span>
      {/*<Arrow className={`${back ? "rotate-180" : ""} ml-2`} />*/}
        <svg className={`${back ? "rotate-180" : ""} ml-2`} xmlns="http://www.w3.org/2000/svg" width="47.049" height="7.518" viewBox="0 0 47.049 7.518">
            <g id="Group_8" data-name="Group 8" transform="translate(-320.5 -428.741)">
                <line id="Line_1" data-name="Line 1" x2="46" transform="translate(320.5 432.5)" fill="none" stroke="#4FA9D2" stroke-width="1"/>
                <path id="Icon_ionic-ios-arrow-forward" data-name="Icon ionic-ios-arrow-forward" d="M14.249,9.954,11.4,7.111a.535.535,0,0,1,0-.759.542.542,0,0,1,.761,0l3.223,3.221a.536.536,0,0,1,.016.741l-3.236,3.243a.537.537,0,1,1-.761-.759Z" transform="translate(352.004 422.545)" fill="#4FA9D2"/>
            </g>
        </svg>

    </Link>
  );
};

export const ColorPick = ({attribute}) => {
  const [chooseColor, setChooseColor] = useState("");

  const handleClick = (color, index) => {
    setChooseColor(index);
  };
  return (
    <>
      {attribute.options.map((color, index) => {
        return (
          <button
            onClick={() => handleClick(color, index)}
            key={index}
            className={`inline-block rounded mr-3 mb-2 border-2 border-solid transition-all ${
              chooseColor === index
                ? "border-custom-blue"
                : "border-transparent"
            } `}
          >
            <div
              style={{
                background: color.color,
              }}
              className=" w-5 h-5"
            ></div>
          </button>
        );
      })}
    </>
  );
};

export const FilterOptions = ({ title, options, attribute, appliedFilters }) => {
    const {localizations} = usePage().props;
  const [showMore, setShowMore] = useState(false);

    function removeA(arr) {
        var what,
            a = arguments,
            L = a.length,
            ax;
        while (L > 1 && arr.length) {
            what = a[--L];
            while ((ax = arr.indexOf(what)) !== -1) {
                arr.splice(ax, 1);
            }
        }
        return arr;
    }

    const handleFilterClick = function (event, code, value) {
        //Inertia.visit('?brand=12');

        if (event.target.checked === true) {
            if (appliedFilters.hasOwnProperty(code)) {
                appliedFilters[code].push(value);
            } else appliedFilters[code] = [value];
        } else {
            if (appliedFilters[code].length > 1)
                removeA(appliedFilters[code], value.toString());
            else delete appliedFilters[code];
        }

        let params = [];

        for (let key in appliedFilters) {
            params.push(key + "=" + appliedFilters[key].join(","));
        }

        Inertia.visit("?" + params.join("&"));
    };

  return (
    <div className="pb-5 border-b border-solid mb-5">
      {" "}
      <div className="bold text-lg mb-5">{title}</div>
      <div
        className={`transition-all duration-300 overflow-hidden  ${
          showMore ? "h-auto" : "h-32"
        }`}
      >
        {options.map((item, index, id) => {

            let checked;


                if (appliedFilters.hasOwnProperty(attribute.code)) {
                    if (appliedFilters[attribute.code].includes(item.id.toString())) {
                        checked = true;
                    } else checked = false;
                } else checked = false;


          return (
            <div key={index} className="flex items-center justify-start mb-3">
              <input
                className="hidden"
                type="checkbox"
                name=""
                id={`${item.label}_${index}`}
                onClick={(event) => {
                    handleFilterClick(event,attribute.code,item.id)
                }}
                checked={checked}
              />
              <label
                className="w-4 h-4 rounded border border-solid mr-2  cursor-pointer"
                htmlFor={`${item.label}_${index}`}
              ></label>
              <label className="" htmlFor={`${item.label}_${index}`}>
                {`${item.label}`}{" "}
                <span className="opacity-50 text-sm">({item.count})</span>
              </label>
            </div>
          );
        })}
      </div>
        {options.length > 4 ? <button
        onClick={() => setShowMore(!showMore)}
        className="text-custom-blue bold mt-5"
      >
        {showMore ? __('client.filter_less',localizations) : __('client.filter_more',localizations)}{" "}
        <BiChevronDown
          className={`inline-block w-5 h-5 ${showMore ? "rotate-180" : ""}`}
        />{" "}
      </button>:null}
    </div>
  );
};

export const Quantity = (props) => {
    const {localizations} = usePage().props;
  const [number, setNumber] = useState(props.qty ? parseInt(props.qty) : 1);

  const decrease = () => {
    if (number > 1) {
      setNumber(number - 1);
    } else {
      setNumber(1);
    }

      if(props.cart)
          Inertia.get(route('update_cart'), {id:props.id,qty: number > 1 ? number - 1 : 1})
  };
  const increase = () => {
    setNumber(number + 1);

      if(props.cart)
          if(props.count >= number + 1){
              Inertia.get(route('update_cart'), {id:props.id,qty: number + 1})
          } else {
              setNumber(number);
              toast.warn(__('client.remaining_only',localizations) + ' ' + props.count);
          }

  };



  return (
    <div className="flex items-center ">
      <button
        className="flex items-center justify-center bg-custom-zinc-200  rounded-lg w-8 h-8"
        onClick={decrease}
      >
        <HiOutlineMinus />
      </button>
      <div className="bold mx-3 text-lg">{number}</div>
        <input type="hidden" id={'inp_product_' + props.id} value={number}/>
      <button
        className="flex items-center justify-center bg-custom-zinc-200  rounded-lg w-8 h-8"
        onClick={increase}
      >
        <HiOutlinePlus />
      </button>
    </div>
  );
};

export const CartTabs = ({ active }) => {
    const {localizations} = usePage().props;
  return (
    <div className="w-full border-b border-solid flex justify-between text-xs sm:text-sm lg:text-base">
      <Link
        href={route('client.cart.index')}
        className={`opacity-60  pb-5 px-3  ${
          active === 0
            ? "text-custom-blue !opacity-100 border-b-4 border-custom-blue border-solid "
            : ""
        }`}
      >
        1. {__('client.nav_cart', localizations)}
      </Link>
      <Link
        href={route('client.shipping.index')}
        className={`opacity-60  pb-5 px-3  ${
          active === 1
            ? "text-custom-blue !opacity-100 border-b-4 border-custom-blue border-solid "
            : ""
        }`}
      >
        2. {__('client.nav_shipping', localizations)}
      </Link>
      <Link
        href={route('client.payment.index')}
        className={`opacity-60  pb-5 px-3  ${
          active === 2
            ? "text-custom-blue !opacity-100 border-b-4 border-custom-blue border-solid "
            : ""
        }`}
      >
        3. {__('client.nav_payment', localizations)}
      </Link>
    </div>
  );
};

export const CartItem = (props) => {
    const {localizations} = usePage().props;
  const [remove, setRemove] = useState(false);

    function removeFromWishlist(id){
        Inertia.get(route('client.favorite.remove'), {id:id})
    }

    function removeItem(id){
        Inertia.get(route('remove-from-cart'), {id:id})
    }

    function addToCart(product,qty){

        if (props.count >= qty){
            Inertia.post(route('add-to-cart'), {id: product,qty:qty});
        } else {
            toast.warn(__('client.remaining_only',localizations)  + ' ' + props.count);
        }


    }

    function buyNow(product,qty){

        if (props.count >= qty){
            Inertia.post(route('add-to-cart'), {id: product,qty:qty, buy_now:true});
        } else {
            toast.warn(__('client.remaining_only',localizations) + ' ' + props.count);
        }


    }


    //alert(qty)

  return (
    <tr className={remove ? "hidden" : ""}>
      <td className="p-4 border-b border-solid ">
        <div className="w-32 h-32">
          <img
            className="w-full h-full object-contain"
            src={props.img}
            alt=""
          />
        </div>
      </td>
      <td className="p-4 border-b border-solid ">
        <div className="uppercase mb-1">{props.name}</div>
        <div className="opacity-50 text-sm">{props.brand}</div>
      </td>
      <td className="p-4 border-b border-solid ">
        <Quantity id={props.id} qty={props.qty} cart={props.cart} count={props.count} />
      </td>
      <td className="p-4 border-b border-solid whitespace-nowrap">
        ₾ {props.price}
      </td>
      {props.btns && (
        <td className="p-4 border-b border-solid whitespace-nowrap">
          <button onClick={() => {
              let qty = document.getElementById('inp_product_' + props.id);
              qty = qty ? qty.value : 1;
              buyNow(props.id,qty);
          }} className="bg-custom-blue text-white rounded-md bold border-custom-blue  border border-solid py-4 px-10 mr-3 mb-2">
              {__('client.buy_now', localizations)}
          </button>
          <button onClick={() => {
              let qty = document.getElementById('inp_product_' + props.id);
              qty = qty ? qty.value : 1;
              addToCart(props.id,qty)
          }} className=" rounded-md bold border-custom-blue text-custom-blue border border-solid py-4 px-10 mr-3 mb-2">
              {__('client.add_to_cart', localizations)}
          </button>
        </td>
      )}

      <td className="p-4 border-b border-solid ">
        <button onClick={() => {
            setRemove(true)
            if (props.cart){
                //alert(4);
                removeItem(props.id)

            } else
            removeFromWishlist(props.id)
        }}>
          {/*<Delete />*/}
            <svg xmlns="http://www.w3.org/2000/svg" width="18.797" height="21.93" viewBox="0 0 18.797 21.93">
                <g id="delete" transform="translate(-4.5 -2.25)">
                    <path id="Path_93" data-name="Path 93" d="M13.5,13.5h1.566v9.4H13.5Z" transform="translate(-2.734 -3.418)" fill="#434343"/>
                    <path id="Path_94" data-name="Path 94" d="M20.25,13.5h1.566v9.4H20.25Z" transform="translate(-4.785 -3.418)" fill="#434343"/>
                    <path id="Path_95" data-name="Path 95" d="M4.5,6.75V8.316H6.066V23.98a1.566,1.566,0,0,0,1.566,1.566H20.164A1.566,1.566,0,0,0,21.73,23.98V8.316H23.3V6.75ZM7.633,23.98V8.316H20.164V23.98Z" transform="translate(0 -1.367)" fill="#434343"/>
                    <path id="Path_96" data-name="Path 96" d="M13.5,2.25h6.266V3.816H13.5Z" transform="translate(-2.734)" fill="#434343"/>
                </g>
            </svg>

        </button>
      </td>
    </tr>
  );
};
