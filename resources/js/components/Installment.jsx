import { useState } from "react";
//import Bank1 from "../assets/images/banks/1.png";
//import Bank2 from "../assets/images/banks/2.png";
//import Bank3 from "../assets/images/banks/3.png";
//import Bank4 from "../assets/images/banks/4.png";
//import Bank5 from "../assets/images/banks/5.png";
//import productimg from "../assets/images/products/2.png";
import DiscreteSlider from "./Duration";
import { Quantity } from "./Shared";
import { IoCloseSharp } from "react-icons/io5";

const Installment = ({ show, hide }) => {
  const banks = ["/client/assets/images/banks/1.png", "/client/assets/images/banks/2.png", "/client/assets/images/banks/3.png", "/client/assets/images/banks/4.png", "/client/assets/images/banks/5.png"];
  const [bankSelect, setBankSelect] = useState(0);

  return (
    <>
      <div
        className={`fixed left-0 top-0 w-screen h-screen text-sm z-50 flex items-center justify-center md:p-10 p-2 overflow-y-scroll transition-all duration-700 ${
          show ? "opacity-100 visible " : "opacity-0 invisible"
        }`}
        style={{ background: "#030e1dd7" }}
      >
        <div className="relative wrapper max-h-4/5 bg-custom-zinc-200 md:p-10 p-3 flex items-start justify-between rounded flex-col xl:flex-row">
          <button onClick={hide} className="absolute top-2 right-2">
            <IoCloseSharp className="w-6 h-6" />
          </button>
          <div className="xl:w-1/2 xl:mr-10 ">
            <div className="text-2xl mb-3 bold">Make an online installment</div>
            <div className="flex justify-between items-start  flex-col sm:flex-row">
              <div className="mr-5 text-justify">
                <div className="mb-5">How it works</div>
                <p className="opacity-50 mb-3">
                  1. Select the desired bank and press the button "Payment in
                  installments".
                </p>
                <p className="opacity-50">
                  2. After placing an order on our website, the system on the
                  bank's website You will be redirected to where you need to
                  fill out the installment form. If any obstacle Call us and we
                  will help you. The bank's response to your application Then
                  the store manager will contact you immediately.
                </p>
              </div>
              <div>
                <div className="text-right text-custom-blue mb-5">
                  Choose bank
                </div>
                {banks.map((item, index) => {
                  return (
                    <button
                      onClick={() => setBankSelect(index)}
                      key={index}
                      className={`block text-center mb-3 rounded-xl bg-white  border-solid border-2 w-60 h-16 group  transition-all  ${
                        bankSelect === index
                          ? "border-custom-blue"
                          : "border-white"
                      }`}
                    >
                      <img
                        className={`transition-all opacity-50 group-hover:opacity-100 mx-auto ${
                          bankSelect === index ? "opacity-100" : ""
                        }`}
                        src={item}
                        alt=""
                      />
                    </button>
                  );
                })}
              </div>
            </div>
          </div>
          <div className="md:bg-white md:py-6 md:px-10 rounded xl:w-2/3 w-full">
            <div className="border-b border-solid pb-5">
              <div className="flex items-start justify-start flex-col md:flex-row">
                <div>
                  <div className="mb-2">Installment duration</div>

                  <DiscreteSlider />
                </div>
                <div className="ml-10">
                  <div className="mb-2">Monthly fee</div>
                  <div className="text-custom-blue text-xl">
                    <span className="text-3xl">145</span> GEL
                  </div>
                </div>
              </div>
            </div>
            <div className="border-b border-solid pb-5">
              <table className="w-full my-5">
                <tr className="opacity-50">
                  <td className=" pb-3">Product</td>
                  <td className=" pb-3">Product name</td>
                  <td className=" pb-3">Quantity</td>
                  <td className=" pb-3">Price</td>
                </tr>
                <tr>
                  <td>
                    <img className="w-32" src="/client/assets/images/products/2.png" alt="" />
                  </td>
                  <td>
                    <div className="md:text-lg">KITCHENAID 5KSM185PSBFT</div>
                    <div className="opacity-50">Manufacturer Name</div>
                  </td>
                  <td>
                    <Quantity />
                  </td>
                  <td> ₾ 3255.00</td>
                </tr>
              </table>
            </div>
            <div className="py-5">
              <div>Terms of installments:</div>
              <div className="opacity-50 mt-2 mb-7">
                Cost of item to be purchased: 100 to 10,000 Term of <br />
                installments: up to 3-24 months <br />
                Interest rate from 7 to 12 months: 0% <br />
                Borrower's age: from 18 to 65 years
              </div>
              <div>Minimum requirements:</div>
              <div className="opacity-50 mt-2 mb-7">
                Minimum income for TBCbank customers: 100 GEL <br />
                Minimum income for customers of other banks: 200 GEL
              </div>
            </div>
            <div className="flex justify-between items-center flex-wrap">
              <img src={banks[bankSelect]} alt="" />
              <button className="bg-custom-blue text-white rounded-md bold border-custom-blue  border border-solid py-4 px-10 ">
                Make an order
              </button>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default Installment;
