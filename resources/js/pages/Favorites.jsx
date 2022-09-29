import { CartItem, DirectionBtn } from "../components/Shared";
//import Product3 from "../assets/images/products/3.png";
//import Product4 from "../assets/images/products/4.png";
//import Product5 from "../assets/images/products/5.png";
//import Product6 from "../assets/images/products/6.png";
//import Product7 from "../assets/images/products/7.png";
import ProductSlider from "../components/ProductSlider";

const Favorites = () => {
  const items = [
    {
      img: "/client/assets/images/products/3.png",
      name: "KITCHENAID 5KSM185PSBFT",
      brand: "Manufacturer Name",
      price: "249.90",
    },
    {
      img: "/client/assets/images/products/4.png",
      name: "KITCHENAID 5KSM185PSBFT",
      brand: "Manufacturer Name",
      price: "249.90",
    },
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
    <div className="bg-custom-zinc-200 py-10">
      <div className="wrapper">
        <DirectionBtn text="Back to shopping" back />
        <div className="text-2xl my-5 bold ">Favorites</div>
        <div className="bg-white p-5 rounded w-full mb-10 overflow-x-scroll scrollbar lg:overflow-x-hidden">
          <table className="w-full ">
            {items.map((item, index) => {
              return (
                <CartItem
                  btns
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
        <div className="py-10">
          <div className="bold mb-4 text-lg">You may like</div>
          <ProductSlider />
        </div>
      </div>
    </div>
  );
};

export default Favorites;
