import React from "react";
import { CartItem, DirectionBtn } from "../components/Shared";
//import Product3 from "../assets/images/products/3.png";
//import Product4 from "../assets/images/products/4.png";
//import Product5 from "../assets/images/products/5.png";
//import Product6 from "../assets/images/products/6.png";
//import Product7 from "../assets/images/products/7.png";
import ProductSlider from "../components/ProductSlider";
import Layout from "@/Layouts/Layout";
import { Link, usePage } from "@inertiajs/inertia-react";
import {Inertia} from "@inertiajs/inertia";

const Favorites = ({seo}) => {

    const {wishlist,localizations} = usePage().props;



    function addToCart(product,qty){



        Inertia.post(route('add-to-cart'), {id: product.id,qty:qty});
    }

    function buyNow(product,qty){

        Inertia.post(route('add-to-cart'), {id: product.id,qty:qty, buy_now:true});
    }


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
      <Layout seo={seo}>
          <div className="bg-custom-zinc-200 py-10">
              <div className="wrapper">
                  <DirectionBtn text="Back to shopping" back />
                  <div className="text-2xl my-5 bold ">Favorites</div>
                  <div className="bg-white p-5 rounded w-full mb-10 overflow-x-scroll scrollbar lg:overflow-x-hidden">
                      <table className="w-full ">
                          {wishlist.map((item, index) => {
                              let brand;
                              item.product.attributes.map((attr) => {
                                  if(attr.attribute.code === 'brand'){
                                      brand = attr.option
                                  }
                              });
                              return (
                                  <CartItem
                                      btns
                                      key={index}
                                      img={item.product.latest_image ? item.product.latest_image.file_full_url:null}
                                      name={item.product.title}
                                      brand={brand}
                                      price={item.product.special_price ? item.product.special_price : item.product.price}
                                      id={item.product.id}
                                  />
                              );
                          })}
                      </table>
                  </div>
                  <div className="py-10">
                      <div className="bold mb-4 text-lg">You may like</div>
                      <ProductSlider products={[]} />
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default Favorites;
