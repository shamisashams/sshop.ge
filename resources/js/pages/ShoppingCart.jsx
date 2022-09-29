import { CartItem, CartTabs } from "../components/Shared";
//import Product5 from "../assets/images/products/5.png";
//import Product6 from "../assets/images/products/6.png";
//import Product7 from "../assets/images/products/7.png";
import ProductSlider from "../components/ProductSlider";

const ShoppingCart = () => {
  const items = [
    {
      img: "/client/assets/images/products/5.png",
      name: "KITCHENAID 5KSM185PSBFT",
      brand: "Manufacturer Name",
      price: "249.90",
    },
    {
      img: "/client/assets/images/products/6.png",
      name: "KITCHENAID 5KSM185PSBFT",
      brand: "Manufacturer Name",
      price: "249.90",
    },
    {
      img: "/client/assets/images/products/7.png",
      name: "KITCHENAID 5KSM185PSBFT",
      brand: "Manufacturer Name",
      price: "249.90",
    },
  ];
  return (
    <div className="bg-custom-zinc-200 py-20">
      <div className="wrapper">
        <CartTabs active={0} />
        <div className="pt-8">
          <div className="text-2xl mb-5 bold">Shopping cart</div>
          <div className="flex items-start justify-between flex-col lg:flex-row">
            <div className="bg-white p-5 rounded lg:w-2/3 w-full mb-10 overflow-x-scroll scrollbar lg:overflow-x-hidden">
              <table className="w-full ">
                {items.map((item, index) => {
                  return (
                    <CartItem
                      key={index}
                      img={item.img}
                      name={item.name}
                      brand={item.brand}
                      price={item.price}
                    />
                  );
                })}
              </table>
            </div>
            <div className="bg-white p-5 rounded lg:w-1/3 lg:ml-10 w-full">
              <div className="flex items-center justify-between mb-5">
                <div className="text-sm">Product quantity</div>
                <div className="bold text-lg">3</div>
              </div>
              <div className="flex items-center justify-between mb-5">
                <div className="bold text-lg">Subtotal</div>
                <div className="bold text-lg text-custom-blue">₾ 3680.00</div>
              </div>
              <button className="w-full bold text-white bg-custom-blue rounded-xl py-5">
                Proceed to payment
              </button>
            </div>
          </div>
          <div className="py-10">
            <div className="bold mb-4 text-lg">Special offers</div>
            <ProductSlider />
          </div>
        </div>
      </div>
    </div>
  );
};

export default ShoppingCart;
