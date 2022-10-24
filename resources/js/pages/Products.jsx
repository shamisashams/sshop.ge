import React, { useState } from "react";
import { productSliderData } from "../components/Data";
//import RangeSlider from "../components/PriceRange";
import ProductBox from "../components/ProductBox";
import { ColorPick, FilterOptions } from "../components/Shared";
import { TbAdjustments } from "react-icons/tb";
import Layout from "@/Layouts/Layout";
import { Link, usePage } from '@inertiajs/inertia-react'
import {Inertia} from "@inertiajs/inertia";
import RangeSlider from "../components/PriceRange/PriceRange";

const Products = ({seo}) => {

    let appliedFilters = [];
    let urlParams = new URLSearchParams(window.location.search);

    urlParams.forEach((value, index) => {
        appliedFilters[index] = value.split(",");
    });

    const {category,products, filter, localizations} = usePage().props;

    console.log(filter);


    function choseColor(color){



            appliedFilters['color'] = [color.id] ;


        let params = [];

        for (let key in appliedFilters) {
            params.push(key + "=" + appliedFilters[key].join(","));
        }

        Inertia.visit("?" + params.join("&"));
    }

    function clearFilter(){
        appliedFilters = [];
        let params = [];

        for (let key in appliedFilters) {
            params.push(key + "=" + appliedFilters[key].join(","));
        }

        Inertia.visit("?" + params.join("&"));
    }

    let links = function (links) {
        let rows = [];
        //links.shift();
        //links.splice(-1);
        {
            links.map(function (item, index) {
                if (index > 0 && index < links.length - 1) {
                    rows.push(
                        <Link
                            href={item.url}
                            className={
                                item.active
                                    ? "mx-2 bold opacity-100"
                                    : "mx-2 bold opacity-50"
                            }
                        >
                            {item.label}
                        </Link>
                    );
                }
            });
        }
        return <div className="nums"> {rows.length > 1 ? rows : null} </div>;
    };

    let linksPrev = function (links) {
        let rowCount = 0;
        links.map(function (item, index) {
            if (index > 0 && index < links.length - 1) {
                rowCount++;
            }
        });
        return rowCount > 1 ? (
            <Link href={links[0].url}>
                <Arrow color="#2F3E51" rotate="90" />
                <Arrow color="#2F3E51" rotate="90" />
            </Link>
        ) : null;
    };
    let linksNext = function (links) {
        let rowCount = 0;
        links.map(function (item, index) {
            if (index > 0 && index < links.length - 1) {
                rowCount++;
            }
        });
        return rowCount > 1 ? (
            <Link href={links[links.length - 1].url}>
                <Arrow color="#2F3E51" rotate="-90" />
                <Arrow color="#2F3E51" rotate="-90" />
            </Link>
        ) : null;
    };

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


    const sort = function (data) {


        appliedFilters["sort"] = data.sort;
        appliedFilters["order"] = data.order;

        console.log(appliedFilters);
        let params = [];

        for (let key in appliedFilters) {
            if (Array.isArray(appliedFilters[key])) {
                params.push(key + "=" + appliedFilters[key].join(","));
            } else {
                params.push(key + "=" + appliedFilters[key]);
            }
        }

        Inertia.visit("?" + params.join("&"));
    };

    let sort_f, order;
    sort_f = 'created_at';
    order = 'desc';
    if(appliedFilters.hasOwnProperty('sort')){

        sort_f =  appliedFilters['sort'][0];
        order = appliedFilters['order'][0];



    }

    //alert(sort_f);
  return (
      <Layout seo={seo}>
          <div className="bg-custom-zinc-300 py-12">
              <div className="wrapper pb-10">
                  {category ? <div className="text-3xl bold mb-10">
                      {category.title} <span className="text-xl opacity-20 pl-3">{category.product_count} {__('client.products_count',localizations)}</span>
                  </div>:null}
                  <button
                      onClick={() => setShowFilters(true)}
                      className="bold text-lg  whitespace-nowrap"
                  >
                      <TbAdjustments className="w-6 h-6 inline-block mb-1" />
                      {__('client.filter',localizations)}
                  </button>
                  <div className="flex justify-start items-start relative ">
                      <div className="bg-white rounded mr-10 p-7 shrink-0 filterBox">
                          <div className="bold text-lg mb-5">{__('client.filter_price',localizations)}</div>
                          <RangeSlider appliedFilters={appliedFilters} />
                          <div className="my-5">
                              <div className="opacity-50 text-sm mb-3">{__('client.filter_color',localizations)}</div>
                              {/*<ColorPick attribute={filter.color ?? {options:[]}} />*/}
                              <div className="grid grid-cols-5 gap-0">
                              {filter.color.options.map((item,index) => {
                                  return (
                                      <button
                                      style={{ width:"57%"}}
                                          onClick={() => choseColor(item)}
                                          key={index}
                                          className={`inline-block rounded mr-3 mb-2 border-2 border-solid transition-all ${
                                              (appliedFilters.hasOwnProperty('color') ? appliedFilters['color'].includes(item.id.toString()): false)
                                                  ? "border-custom-blue"
                                                  : "border-transparent"
                                          } `}
                                      >
                                          <div
                                              style={{
                                                  background: item.color,
                                              }}
                                              className="w-5 h-5"
                                          ></div>
                                      </button>
                                  )
                              })}
                              </div>
                          </div>
                          {filter.attributes.map((item, index) => {

                              return (
                                  <FilterOptions
                                      key={index}
                                      title={item.name}
                                      options={item.options}
                                      attribute={item}
                                      appliedFilters={appliedFilters}
                                  />
                              );
                          })}
                          <button onClick={clearFilter} className="bg-custom-blue text-white rounded-md p-4 w-full bold">
                              {__('client.filter_clear',localizations)}
                          </button>
                      </div>
                      <div className=" w-full lg:w-auto">
                          <div className="block text-sm mb-5">
                              <button onClick={() => {
                                  sort({sort: 'price', order: 'asc'});
                              }} className={`inline-block bold mr-3 ${sort_f === 'price' && order === 'asc' ? 'opacity-100' : 'opacity-20'}`}>{__('client.filter_price_asc',localizations)}</button>
                              <button onClick={() => {
                                  sort({sort: 'price', order: 'desc'});
                              }} className={`inline-block bold mr-3 ${sort_f === 'price' && order === 'desc' ? 'opacity-100' : 'opacity-20'} `}>{__('client.filter_price_desc',localizations)}</button>
                              <button onClick={() => {
                                  sort({sort: 'created_at', order: 'desc'});
                              }} className={`inline-block bold mr-3 ${sort_f === 'created_at' && order === 'desc' ? 'opacity-100' : 'opacity-20'} `}>{__('client.filter_date_desc',localizations)}</button>
                              <button onClick={() => {
                                  sort({sort: 'created_at', order: 'asc'});
                              }} className={`inline-block bold mr-3 ${sort_f === 'created_at' && order === 'asc' ? 'opacity-100' : 'opacity-20'} `}>{__('client.filter_date_asc',localizations)}</button>
                          </div>
                          <div className="grid xl:grid-cols-4 grid-cols-2 gap-8">
                              {products.data.map((item, index) => {
                                  let discount;
                                  discount = 100 - ((item.special_price * 100) / item.price).toFixed()
                                  return (
                                      <ProductBox
                                          key={index}
                                          img={item.latest_image ? item.latest_image.thumb_full_url:null}
                                          name={item.title}
                                          brand={item.attributes.brand}
                                          oldPrice={item.special_price ? item.price : null}
                                          price={item.special_price ? item.special_price : item.price}
                                          discount={discount}
                                          link={route('client.product.show',item.slug)}
                                          id={item.id}
                                          qty={item.quantity}
                                      />
                                  );
                              })}
                          </div>
                          <div className="flex items-center justify-end mt-10">
                              {/*<button className="mx-2 bold opacity-100">1</button>
                              <button className="mx-2 bold opacity-50">2</button>
                              <button className="mx-2 bold opacity-50">3</button>
                              <button className="mx-2 bold opacity-50">4</button>*/}
                              {links(products.links)}
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default Products;
