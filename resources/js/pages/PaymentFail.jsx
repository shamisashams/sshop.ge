//import Img from "../assets/images/other/2.png";
import { DirectionBtn } from "../components/Shared";

const PaymentFail = () => {
  return (
    <div className="text-center py-32 bg-custom-zinc-200">
      <div className="wrapper">
        <div className="bold text-3xl mb-4">Payment Fail</div>
        <div className="text-sm opacity-50 mb-10 max-w-md mx-auto">
          There is some problem in your payment, please check the information
          you provide to bank
        </div>
        <img className="mx-auto" src="/client/assets/images/other/2.png" alt="" />

        <div className="mx-auto w-fit mt-10">
          <DirectionBtn
            text="Back to payment details"
            back
            link="/payment-details"
          />
        </div>
      </div>
    </div>
  );
};

export default PaymentFail;
