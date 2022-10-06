import React, { useState } from "react";
import { CartTabs, DirectionBtn } from "../components/Shared";
//import Product5 from "../assets/images/products/5.png";
//import Product6 from "../assets/images/products/6.png";
//import Product7 from "../assets/images/products/7.png";
//import Bank1c from "../assets/images/banks/1c.png";
//import Bank2c from "../assets/images/banks/2c.png";
//import Bank3c from "../assets/images/banks/3c.png";
//import Bank1 from "../assets/images/banks/1.png";
//import Bank2 from "../assets/images/banks/2.png";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
import Layout from "@/Layouts/Layout";
import {Inertia} from "@inertiajs/inertia";


const PaymentDetails = ({seo}) => {
    const {cart,promocode, shipping, city, localizations} = usePage().props;
  const [bankSelect, setBankSelect] = useState(null);

    const [bank,setBank] = useState(null);
  //const [chooseCity, setChooseCity] = useState(false);
  //const [city, setCity] = useState("Choose city");
  const cityOptions = [
    "Current address added in profile",
    "Tbilisi",
    "Kutaisi",
    "Gori",
  ];


    function makeOrder(){
        if(bankSelect == null){
            alert('select bank');
            return;
        }
        Inertia.post(route('client.checkout.order'),{payment_type:bank})
    }


    function selectBank(bank){
        setBank(bank);
    }

  /*const handleClick = (item) => {
    setCity(item);
    setChooseCity(false);
  };*/
  const items = [
    {
      img: "/client/assets/images/products/5.png",
      name: "KITCHENAID 5KSM185PSBFT",
      color: "gray",
      quantity: "1",
      price: "249.90",
    },
    {
      img: "/client/assets/images/products/6.png",
      name: "Small Chair",
      color: "gray",
      quantity: "1",
      price: "249.90",
    },
    {
      img: "/client/assets/images/products/7.png",
      name: "5KSM185PSBFT",
      color: "gray",
      quantity: "1",
      price: "249.90",
    },
  ];
  return (
      <Layout seo={seo}>
          <div className="bg-custom-zinc-200 py-20">
              <div className="wrapper">
                  <CartTabs active={2}/>
                  <div className="pt-12">
                      <div className="flex items-start justify-between flex-col lg:flex-row">
                          <div className=" lg:w-1/2 w-full mb-10">
                              <div className="bg-white p-5 md:py-20 rounded text-center ">
                                  <div className="max-w-md mx-auto">
                                      <div className="bold text-lg mb-5">Shipping details</div>
                                      <div
                                          className="flex items-center justify-start text-sm border border-solid w-full h-14 px-4 mb-2 rounded">
                                          <div className="w-1/4 text-left">Ship to:</div>
                                          <div className="opacity-50 pl-1">
                                              {city.title}, {shipping.address}
                                          </div>
                                      </div>
                                      <div
                                          className="flex items-center justify-start text-sm border border-solid w-full h-14 px-4 mb-5 rounded">
                                          <div className="w-1/4 text-left">Contact:</div>
                                          <div className="opacity-50 pl-1">{shipping.phone}</div>
                                      </div>
                                      <div className="flex items-center justify-between mb-6">
                                          <div className="bold text-lg whitespace-nowrap">
                                              Payment details
                                          </div>
                                          <div>
                                              <span className="opacity-50 ">Cards we accept</span>
                                              <img className="inline-block ml-1"
                                                   src="/client/assets/images/banks/1c.png" alt=""/>
                                              <img className="inline-block ml-1"
                                                   src="/client/assets/images/banks/2c.png" alt=""/>
                                              <img className="inline-block ml-1"
                                                   src="/client/assets/images/banks/3c.png" alt=""/>
                                          </div>
                                      </div>
                                      <div className="text-left">Choose bank for payment</div>
                                      <div className="grid grid-cols-2 gap-4 mt-6">
                                          <button
                                              onClick={() => {
                                                  setBankSelect(0)
                                                  selectBank('tbc');
                                              }}
                                              className={` text-center mb-3 rounded-xl bg-white  border-solid border-2 w-full h-16   transition-all shadow-lg  hover:border-zinc-300  ${
                                                  bankSelect === 0
                                                      ? "!border-custom-blue"
                                                      : "border-white"
                                              }`}
                                          >
                                              <img className={`  mx-auto `} src="/client/assets/images/banks/1.png"
                                                   alt=""/>
                                          </button>
                                          <button
                                              onClick={() => {
                                                  setBankSelect(1)
                                                  selectBank('bog');
                                              }}
                                              className={` text-center mb-3 rounded-xl bg-white  border-solid border-2 w-full h-16   transition-all  shadow-lg hover:border-zinc-300  ${
                                                  bankSelect === 1
                                                      ? "!border-custom-blue"
                                                      : "border-white"
                                              }`}
                                          >
                                              <img className={`  mx-auto `} src="/client/assets/images/banks/2.png"
                                                   alt=""/>
                                          </button>
                                      </div>
                                      <div className="my-5">Or</div>
                                      <button
                                          className={`block text-center mb-3 rounded-xl bg-white border-solid border-2 w-full h-16 transition-all shadow-lg border-white hover:border-zinc-300 bold text-lg`}
                                      >
                                          Make an installment
                                      </button>
                                      <div className="opacity-50 mt-10">Enter a promo code</div>
                                      <input
                                          type="text"
                                          maxLength="8"
                                          className="text-center border-none"
                                          placeholder="--------"
                                          name="promocode"
                                      />
                                      <button className="mb-5">
                                      <img className="" src="/client/assets/images/icons/enter.png" alt="" />
                                      </button>
                                      <div className="flex items-center justify-center mb-6">
                                          <input
                                              className="hidden"
                                              type="checkbox"
                                              name="agree"
                                              id="term_conditions"
                                          />
                                          <label
                                              className="w-4 h-4 rounded border border-solid mr-2 mb-1 cursor-pointer"
                                              htmlFor="term_conditions"
                                          ></label>
                                          <label>
                                              I accept{" "}
                                              <Link
                                                  className="text-custom-blue pl-1"
                                                  href="/terms-conditions"
                                              >
                                                  terms and conditions
                                              </Link>
                                          </label>
                                      </div>
                                      <button onClick={makeOrder} className="w-full bold text-white bg-custom-blue rounded-xl py-5">
                                          Make a payment now
                                      </button>
                                  </div>
                              </div>
                          </div>
                          <div className="lg:w-1/3 lg:ml-10 mx-auto lg:mx-0">
                              <div className="max-w-md">
                                  <div className="bold text-lg">Summary</div>
                                  <div className="opacity-50 my-4">({cart.count} items)</div>
                                  {cart.products.map((item, index) => {
                                      return (
                                          <div
                                              key={index}
                                              className="flex justify-between items-start mb-5"
                                          >
                                              <div className="flex items-start justify-start mr-3">
                                                  <div className="w-14 h-14 mr-2">
                                                      <img
                                                          className="w-full h-full object-contain"
                                                          src={item.product.latest_image ? item.product.latest_image.file_full_url :null}
                                                          alt=""
                                                      />
                                                  </div>
                                                  <div>
                                                      <div className="bold uppercase">{item.product.title}</div>
                                                      {item.product.attributes.map((attr,ind) => {

                                                          return <div className="text-sm opacity-50">{attr.attribute.name} : {attr.option}</div>
                                                      })}
                                                      {/*<div className="text-sm opacity-50">
                                                          Color: {item.color}
                                                      </div>*/}
                                                      <div className="text-sm opacity-50">
                                                          Quantity: {item.quantity}
                                                      </div>
                                                  </div>
                                              </div>
                                              <div>{item.product.special_price ? item.product.special_price :item.product.price}</div>
                                          </div>
                                      );
                                  })}
                                  <div
                                      className="flex justify-between items-center py-5 mt-10 border-t border-b border-solid">
                                      <div>Subtotal</div>
                                      <div>₾ {cart.total}</div>
                                  </div>
                                  <div className="flex justify-between items-center py-5 mb-5">
                                      <div>Shipping</div>
                                      <div>₾ {shipping.ship_price}</div>
                                  </div>
                                  <div className="flex justify-between items-center py-5 mt-14 bold text-xl">
                                      <span>Total</span>
                                      <span className="text-3xl">₾ {parseFloat(cart.total) + parseFloat(shipping.ship_price)}</span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div className="mt-10">
                          <DirectionBtn
                              text="Back to shipping"
                              back
                              link="/shipping-details"
                          />
                      </div>
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default PaymentDetails;
