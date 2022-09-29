import { useState } from "react";
import { productSliderData } from "../components/Data";
import RangeSlider from "../components/PriceRange";
import ProductBox from "../components/ProductBox";
import { ColorPick, FilterOptions } from "../components/Shared";
import { TbAdjustments } from "react-icons/tb";

const Products = () => {
  const [showFilters, setShowFilters] = useState(false);
  const options = [
    {
      title: "Brands",
      list: [
        {
          label: "Apple",
          quantity: "10",
        },
        {
          label: "Asus",
          quantity: "10",
        },
        {
          label: "Hp",
          quantity: "32",
        },
        {
          label: "Dell",
          quantity: "7",
        },
        {
          label: "HyperPC",
          quantity: "2",
        },
        {
          label: "Hp",
          quantity: "32",
        },
        {
          label: "Dell",
          quantity: "7",
        },
        {
          label: "HyperPC",
          quantity: "2",
        },
      ],
    },
    {
      title: "Gpu",
      list: [
        {
          label: "Geforce RfghTX 3090",
          quantity: "1",
        },
        {
          label: "Geforce RTfghX 3090",
          quantity: "34",
        },
        {
          label: "Geforce RfghTX 3090",
          quantity: "7",
        },
        {
          label: "Geforce gf",
          quantity: "2",
        },
        {
          label: "Geforce Rfgh 3090",
          quantity: "34",
        },
        {
          label: "Geforce fghRTX 3090",
          quantity: "7",
        },
        {
          label: "Geforce RTfghX 3090",
          quantity: "2",
        },
      ],
    },
  ];
  return (
    <div className="bg-custom-zinc-300 py-12">
      <div className="wrapper pb-10">
        <div className="text-3xl bold mb-10">
          Computers <span className="text-xl opacity-20 pl-3">53 products</span>
        </div>
        <button
          onClick={() => setShowFilters(true)}
          className="bold text-lg  whitespace-nowrap"
        >
          <TbAdjustments className="w-6 h-6 inline-block mb-1" />
          Filter
        </button>
        <div className="flex justify-start items-start relative ">
          <div className="bg-white rounded mr-10 p-7 shrink-0 filterBox">
            <div className="bold text-lg mb-5">Price</div>
            <RangeSlider />
            <div className="my-5">
              <div className="opacity-50 text-sm mb-3">Choose Color</div>
              <ColorPick />
            </div>
            {options.map((item, index) => {
              return (
                <FilterOptions
                  key={index}
                  title={item.title}
                  options={item.list}
                />
              );
            })}
            <button className="bg-custom-blue text-white rounded-md p-4 w-full bold">
              Search products
            </button>
          </div>
          <div>
            <div className="grid xl:grid-cols-3 grid-cols-2 gap-8">
              {productSliderData.map((item, index) => {
                return (
                  <ProductBox
                    key={index}
                    img={item.img}
                    name={item.name}
                    brand={item.brand}
                    oldPrice={item.oldPrice}
                    price={item.price}
                    discount={item.discount}
                    link={item.link}
                  />
                );
              })}
            </div>
            <div className="flex items-center justify-end mt-10">
              <button className="mx-2 bold opacity-100">1</button>
              <button className="mx-2 bold opacity-50">2</button>
              <button className="mx-2 bold opacity-50">3</button>
              <button className="mx-2 bold opacity-50">4</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Products;
