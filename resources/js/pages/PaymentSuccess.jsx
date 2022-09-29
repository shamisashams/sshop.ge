//import Img from "../assets/images/other/1.png";
import { DirectionBtn } from "../components/Shared";
import { RiHistoryFill } from "react-icons/ri";

const PaymentSuccess = () => {
  return (
    <div className="text-center py-32 bg-custom-zinc-200">
      <div className="wrapper">
        <div className="bold text-3xl mb-4">Payment Successfull</div>
        <div className="text-sm opacity-50 mb-10">
          We have received your payment and are preparing your order
        </div>
        <img className="mx-auto" src="/client/assets/images/other/1.png" alt="" />
        <div
          className="rounded-2xl h-3 w-full bg-zinc-300 relative mx-auto my-10 "
          style={{ maxWidth: "511px" }}
        >
          <div className="absolute top-0 left-0 bg-custom-blue h-full w-1/2 rounded-2xl "></div>
          <div className="flex justify-between items-center absolute left-0 top-1/2 -translate-y-1/2 w-full text-sm">
            <button className="relative w-7 h-7 rounded-full text-white bg-custom-blue shadow">
              1
              <div className="absolute left-0 top-full pt-3 text-custom-dark text-xs whitespace-nowrap ">
                Choose product
              </div>
            </button>
            <button className="relative w-7 h-7 rounded-full text-white bg-custom-blue shadow">
              2
              <div className="absolute left-0 top-full pt-3 text-custom-dark text-xs whitespace-nowrap ">
                make payment
              </div>
            </button>
            <button className="relative w-7 h-7 rounded-full text-white  bg-zinc-300  shadow">
              3
              <div className="absolute left-0 top-full pt-3 text-custom-dark text-xs whitespace-nowrap opacity-50">
                Prepare order
              </div>
            </button>
            <button className="relative w-7 h-7 rounded-full text-white  bg-zinc-300  shadow">
              4
              <div className="absolute right-0 top-full pt-3 text-custom-dark text-xs whitespace-nowrap opacity-50">
                Deliver
              </div>
            </button>
          </div>
        </div>
        <div className="pt-10 mb-4 text-sm opacity-50">
          you can check your order statys in order history
        </div>
        <button className=" relative bg-custom-blue rounded-xl shadow bold text-lg py-4 px-16 text-white w-fit mx-auto mb-10">
          <RiHistoryFill className="absolute top-1/2 -translate-y-1/2 left-5" />
          Order history
        </button>

        <div className="mx-auto w-fit">
          <DirectionBtn text="Back to Home" back link="/" />
        </div>
      </div>
    </div>
  );
};

export default PaymentSuccess;
