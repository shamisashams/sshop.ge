import { CartTabs, DirectionBtn } from "../components/Shared";
//import Product5 from "../assets/images/products/5.png";
//import Product6 from "../assets/images/products/6.png";
//import Product7 from "../assets/images/products/7.png";
//import { ReactComponent as Flag } from "../assets/images/icons/info/flag.svg";
//import { ReactComponent as Pin } from "../assets/images/icons/info/pin.svg";
//import { ReactComponent as Tel } from "../assets/images/icons/info/tel.svg";
//import { ReactComponent as Info } from "../assets/images/icons/info/info.svg";
import { useState } from "react";

const ShippingDetails = () => {
  const [chooseCity, setChooseCity] = useState(false);
  const [city, setCity] = useState("Choose city");
  const cityOptions = [
    "Current address added in profile",
    "Tbilisi",
    "Kutaisi",
    "Gori",
  ];
  const handleClick = (item) => {
    setCity(item);
    setChooseCity(false);
  };
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
    <div className="bg-custom-zinc-200 py-20">
      <div className="wrapper">
        <CartTabs active={1} />
        <div className="pt-12">
          <div className="flex items-start justify-between flex-col lg:flex-row">
            <div className=" lg:w-1/2 w-full mb-10">
              <div className="bg-white p-5 md:py-20 rounded text-center ">
                <div className="max-w-md mx-auto">
                  <div className="bold md::text-3xl text-xl mb-8">
                    Pick location where we should deliver items
                  </div>
                  <div className="relative w-fill h-16 mb-3 bg-custom-blue rounded">
                    {/*<Flag className="fill-white absolute top-1/2 left-4 -translate-y-1/2 z-20" />*/}
                      <svg className="fill-white absolute top-1/2 left-4 -translate-y-1/2 z-20" xmlns="http://www.w3.org/2000/svg" width="17.172" height="22.727" viewBox="0 0 17.172 22.727">
                          <g id="noun-flag-1014363" transform="translate(-163.518 -22.399)">
                              <path id="Path_128" data-name="Path 128" d="M180.185,32.2a.891.891,0,0,0,.505-.783.905.905,0,0,0-.48-.808l-12.4-6.237V23.283a.884.884,0,0,0-1.768,0V43.359H164.4a.884.884,0,1,0,0,1.768h5.05a.9.9,0,0,0,.884-.884.879.879,0,0,0-.884-.884h-1.641V37.854Zm-2.424-.833-9.949,4.545V26.364Z" />
                          </g>
                      </svg>

                      <button
                      onClick={() => setChooseCity(true)}
                      className="w-full h-full text-center border-none placeholder:text-white text-white"
                    >
                      {city}
                    </button>

                    <div
                      className={`w-full absolute left-0 top-0 z-30 border border-solid transition-all duration-500 ${
                        chooseCity
                          ? "opacity-100 visible"
                          : "opacity-0 invisible"
                      }`}
                    >
                      <input
                        className="w-full p-4 bg-white border-none rounded-none text-center placeholder:opacity-50"
                        type="text"
                        placeholder="Search here..."
                      />
                      {cityOptions.map((item, index) => {
                        return (
                          <button
                            onClick={() => handleClick(item)}
                            key={index}
                            className="w-full p-4 bg-white hover:bg-custom-zinc-200"
                          >
                            {item}
                          </button>
                        );
                      })}
                    </div>
                  </div>
                  <div className="relative w-fill h-16 mb-3">
                    {/*<Pin className="fill-custom-dark absolute top-1/2 left-4 -translate-y-1/2 z-20" />*/}
                      <svg className="fill-custom-dark absolute top-1/2 left-4 -translate-y-1/2 z-20" xmlns="http://www.w3.org/2000/svg" width="15.627" height="22.728" viewBox="0 0 15.627 22.728">
                          <g id="noun-location-1046848" transform="translate(-165.2 -11.199)">
                              <path id="Path_129" data-name="Path 129" d="M173.013,11.2a7.9,7.9,0,0,0-7.813,7.954c0,4.385,3.32,9.058,7.037,14.369a.947.947,0,0,0,1.554,0c3.716-5.31,7.037-9.984,7.037-14.369a7.9,7.9,0,0,0-7.813-7.954Zm0,1.894a5.976,5.976,0,0,1,5.919,6.06c0,3.107-2.6,7.333-5.919,12.142-3.321-4.809-5.919-9.035-5.919-12.142A5.976,5.976,0,0,1,173.013,13.093Zm0,1.421a4.5,4.5,0,1,0,4.5,4.5,4.513,4.513,0,0,0-4.5-4.5Zm0,1.894a2.6,2.6,0,1,1-2.6,2.6A2.59,2.59,0,0,1,173.013,16.408Z" />
                          </g>
                      </svg>

                      <input
                      type="text"
                      className="w-full h-full text-center "
                      placeholder="Enter your address"
                    />
                  </div>
                  <div className="relative w-fill h-16 mb-3">
                    {/*<Tel className="fill-custom-dark stroke-custom-dark absolute top-1/2 left-4 -translate-y-1/2 z-20" />*/}
                      <svg className="fill-custom-dark stroke-custom-dark absolute top-1/2 left-4 -translate-y-1/2 z-20" xmlns="http://www.w3.org/2000/svg" width="18.004" height="22.005" viewBox="0 0 18.004 22.005">
                          <g id="noun-phone-1384969" transform="translate(-196.269 -88.086)">
                              <path id="Path_130" data-name="Path 130" d="M140.605,109.091H129.936a2.675,2.675,0,0,1-2.667-2.667V91.754a2.675,2.675,0,0,1,2.667-2.667h10.669a2.675,2.675,0,0,1,2.667,2.667v14.67a2.676,2.676,0,0,1-2.668,2.667Zm0,0" transform="translate(70)" fill="none"  stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/>
                              <path id="Path_131" data-name="Path 131" d="M321.522,364.4a1.667,1.667,0,1,1-1.667-1.667,1.667,1.667,0,0,1,1.667,1.667" transform="translate(-114.584 -259.306)" />
                              <path id="Path_132" data-name="Path 132" d="M301.281,137.91h-3.867a.867.867,0,1,1,0-1.734h3.867a.867.867,0,0,1,0,1.734Z" transform="translate(-94.077 -44.622)" />
                          </g>
                      </svg>

                      <input
                      type="text"
                      className="w-full h-full text-center "
                      placeholder="Enter phone number"
                    />
                  </div>
                  <div className="relative w-fill h-16 mb-10">
                    {/*<Info className="fill-custom-dark stroke-custom-dark absolute top-1/2 left-4 -translate-y-1/2 z-20 " />*/}
                      <svg className="fill-custom-dark stroke-custom-dark absolute top-1/2 left-4 -translate-y-1/2 z-20 " xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                          <g id="Group_279" data-name="Group 279" transform="translate(-396 -688)">
                              <g id="Ellipse_35" data-name="Ellipse 35" transform="translate(396 688)" fill="none" stroke="#434343" stroke-width="2">
                                  <circle cx="12" cy="12" r="12" stroke="none"/>
                                  <circle cx="12" cy="12" r="11" fill="none"/>
                              </g>
                              <g id="Group_112" data-name="Group 112" transform="translate(-59.33 49.003)">
                                  <line id="Line_70" data-name="Line 70" y2="6.666" transform="translate(467.33 644.997)" fill="none" stroke="#0f1b13" stroke-linecap="round" stroke-width="3"/>
                                  <line id="Line_71" data-name="Line 71" transform="translate(467.33 656.996)" fill="none" stroke="#0f1b13" stroke-linecap="round" stroke-width="3"/>
                              </g>
                          </g>
                      </svg>

                      <input
                      type="text"
                      className="w-full h-full text-center "
                      placeholder="Leave a comment"
                    />
                  </div>
                  <button className="border border-custom-blue text-custom-blue rounded-lg h-12 px-10">
                    Calculate shipping
                  </button>
                </div>
              </div>
            </div>
            <div className="lg:w-1/3 lg:ml-10 mx-auto lg:mx-0">
              <div className="max-w-md">
                <div className="bold text-lg">Summary</div>
                <div className="opacity-50 my-4">(12 items)</div>
                {items.map((item, index) => {
                  return (
                    <div
                      key={index}
                      className="flex justify-between items-start mb-5"
                    >
                      <div className="flex items-start justify-start mr-3">
                        <div className="w-14 h-14 mr-2">
                          <img
                            className="w-full h-full object-contain"
                            src={item.img}
                            alt=""
                          />
                        </div>
                        <div>
                          <div className="bold uppercase">{item.name}</div>
                          <div className="text-sm opacity-50">
                            Color: {item.color}
                          </div>
                          <div className="text-sm opacity-50">
                            Quantity: {item.quantity}
                          </div>
                        </div>
                      </div>
                      <div>{item.price}</div>
                    </div>
                  );
                })}
                <div className="flex justify-between items-center py-5 mt-10 border-t border-b border-solid">
                  <div>Subtotal</div>
                  <div>₾ 4495.55</div>
                </div>
                <div className="flex justify-between items-center py-5 mb-5">
                  <div>Shipping</div>
                  <div>₾ 55.00</div>
                </div>
                <button className="w-full bold text-white bg-custom-blue rounded-xl py-5">
                  Proceed to payment
                </button>
              </div>
            </div>
          </div>
          <div className="mt-10">
            <DirectionBtn text="Back to shopping" back link="/shopping-cart" />
          </div>
        </div>
      </div>
    </div>
  );
};

export default ShippingDetails;
