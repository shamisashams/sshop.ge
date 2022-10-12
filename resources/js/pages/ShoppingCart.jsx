import React from "react";
import { CartItem, CartTabs } from "../components/Shared";
//import Product5 from "../assets/images/products/5.png";
//import Product6 from "../assets/images/products/6.png";
//import Product7 from "../assets/images/products/7.png";
import ProductSlider from "../components/ProductSlider";
import Layout from "@/Layouts/Layout";
import { Link, usePage } from "@inertiajs/inertia-react";
import { Inertia } from '@inertiajs/inertia'

const ShoppingCart = ({seo}) => {

    const {cart, promocode, localizations, products} = usePage().props;

    function removeItem(id){
        Inertia.get(route('remove-from-cart'), {id:id})
    }

    function proceedToPayment(){
        Inertia.visit(route('client.shipping.index'));
    }

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
      <Layout seo={seo}>
          <div className="bg-custom-zinc-200 py-20">
              <div className="wrapper">
                  <CartTabs active={0} />
                  <div className="pt-8">
                      <div className="text-2xl mb-5 bold">{__('client.nav_cart', localizations)}</div>
                      <div className="flex items-start justify-between flex-col lg:flex-row">
                          <div className="bg-white p-5 rounded lg:w-2/3 w-full mb-10 overflow-x-scroll scrollbar lg:overflow-x-hidden">
                              <table className="w-full ">
                                  {cart.products.map((item, index) => {
                                      let brand;
                                      item.product.attributes.map((attr) => {
                                          if(attr.attribute.code === 'brand'){
                                              brand = attr.option
                                          }
                                      });
                                      return (
                                          <CartItem
                                              key={index}
                                              img={item.product.latest_image ? item.product.latest_image.file_full_url :null}
                                              name={item.product.title}
                                              brand={brand}
                                              price={item.product.special_price ? item.product.special_price : item.product.price}
                                              id={item.product.id}
                                              qty={item.quantity}
                                              cart
                                          />
                                      );
                                  })}
                              </table>
                          </div>
                          <div className="bg-white p-5 rounded lg:w-1/3 lg:ml-10 w-full">
                              <div className="flex items-center justify-between mb-5">
                                  <div className="text-sm">{__('client.product_qty', localizations)}</div>
                                  <div className="bold text-lg">{cart.count}</div>
                              </div>
                              <div className="flex items-center justify-between mb-5">
                                  <div className="bold text-lg">{__('client.subtotal', localizations)}</div>
                                  <div className="bold text-lg text-custom-blue">₾ {cart.total}</div>
                              </div>
                              <button onClick={proceedToPayment} className="w-full bold text-white bg-custom-blue rounded-xl py-5">
                                  {__('client.to_shipping', localizations)}
                              </button>
                          </div>
                      </div>
                      <div className="py-10">
                          <div className="bold mb-4 text-lg">{__('client.special_offer', localizations)}</div>
                          <ProductSlider products={products} />
                      </div>
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default ShoppingCart;
