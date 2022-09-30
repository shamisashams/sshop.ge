import React, { useState } from "react";
import { ColorPick, DirectionBtn } from "../components/Shared";
import SingleSlider from "../components/SingleSlider";
import { BsPlay } from "react-icons/bs";
//import { ReactComponent as HeartIcon } from "../assets/images/icons/header/heart.svg";
//import { Link } from "react-router-dom";
import { BiChevronRight } from "react-icons/bi";
import ProductSlider from "../components/ProductSlider";
import Installment from "../components/Installment";
import Layout from "@/Layouts/Layout";
import { Link, usePage } from '@inertiajs/inertia-react'

const SingleProduct = ({seo}) => {
  const [favorite, setFavorite] = useState(false);
  const [showPopup, setShowPopup] = useState(false);

  const {product,category_path, product_images} = usePage().props;

    let discount;
    discount = 100 - ((product.special_price * 100) / product.price).toFixed();

  return (
      <Layout seo={seo}>
          <>
              <div className="bg-custom-zinc-200 py-10">
                  <div className="wrapper">
                      <div className="flex justify-start ">
                          <DirectionBtn text="Back to Categorie" back />
                      </div>
                      <div className="flex items-center justify-start flex-wrap mt-4 text-sm">
                          {category_path.map((item,index) => {
                              if((index + 1) < category_path.length)
                              return (
                                  <span className="flex items-center justify-start flex-wrap">
                                      <span className="opacity-50 pr-1">{item.title}</span>
                                      <span className="opacity-50 pr-1">
                                            {" "}
                                          <BiChevronRight />{" "}
                                        </span>
                                  </span>
                              )
                              else
                                  return (
                                      <span className="flex items-center justify-start flex-wrap">
                                      <span>{item.title}</span>

                                  </span>
                                  )
                          })}
                          {/*<span className="opacity-50 pr-1">Technic</span>
                          <span className="opacity-50 pr-1">
              {" "}
                              <BiChevronRight />{" "}
            </span>
                          <span className="opacity-50 pr-1">Laptop, Computers, Monitors</span>
                          <span className="opacity-50 pr-1">
              {" "}
                              <BiChevronRight />{" "}
            </span>
                          <span>Gaming PC</span>*/}
                      </div>
                      <div className="flex items-start justify-start pt-10 flex-col lg:flex-row">
                          <div className="lg:w-1/2 w-full lg:mr-10 mb-10">
                              <SingleSlider images={product_images} />
                          </div>
                          <div>
                              <div className="bold text-3xl mb-2">{product.title}</div>
                              <div className="mb-5 text-sm text-black/[0.5]">
                                  Made By: <span className="bold text-lg text-black">{product.attributes.brand}</span>
                              </div>
                              <div className="text-lg bold">Specification</div>
                              <div className="grid grid-cols-2 gap-y-2 gap-x-5 opacity-50 text-sm mb-5 mt-3">
                                  <div>Cpu: Intel Core i3-12100</div>
                                  <div>SSD: 256GB</div>
                                  <div>Ram: 8GB</div>
                                  <div>Gpu: Geforce RTX 3090</div>
                                  <div>HDD: 1TB</div>
                                  <div>Psu: 550WA</div>
                              </div>
                              <select className=" text-custom-blue mb-5 bg-transparent">
                                  <option value="1">See All Specs</option>
                                  <option value="2">asdf drgf adrg</option>
                                  <option value="3">uilh l vhjkfhjk</option>
                              </select>
                              <div className="mb-4">
                                  <div className="bold mb-2 text-lg">Choose color</div>
                                  <ColorPick />
                              </div>
                              <div className="text-sm">
                <span className="text-xs text-white bg-custom-red rounded py-0.5 px-2 mr-2">
                  {discount}%
                </span>
                                  Discount for this product
                              </div>
                              <div className="text-2xl bold my-5">
                                  {" "}
                                  ₾ <span className="text-4xl">{product.price}</span>{" "}
                              </div>
                              <button className="flex items-center judtify-start bold text-sm">
                                  <div className="flex items-center justify-center w-10 h-10 bg-white shadow-xl rounded-full mr-2">
                                      <BsPlay className="w-6 h-6 " />
                                  </div>
                                  <span>Watch the video</span>
                              </button>
                              <div className="flex justify-start items-center  my-6 flex-wrap">
                                  <button className="bg-custom-blue text-white rounded-md bold border-custom-blue  border border-solid py-4 px-10 mr-3 mb-2">
                                      Buy now
                                  </button>
                                  <button className=" rounded-md bold border-custom-blue text-custom-blue border border-solid py-4 px-10 mr-3 mb-2">
                                      Add to cart
                                  </button>
                                  <button
                                      onClick={() => setFavorite(!favorite)}
                                      className="w-10 h-10 flex justify-center items-center rounded-md bg-custom-zinc-200 mb-2"
                                  >
                                      {/*<HeartIcon
                    className={` ${
                      favorite ? "stroke-red-400" : "stroke-custom-dark"
                    }`}
                  />*/}
                                      <svg  className={` ${
                                          favorite ? "stroke-red-400" : "stroke-custom-dark"
                                      }`} xmlns="http://www.w3.org/2000/svg" width="19.964" height="17.605" viewBox="0 0 19.964 17.605">
                                          <g id="Icon_feather-heart" data-name="Icon feather-heart" transform="translate(0.75 0.75)">
                                              <path id="Icon_feather-heart-2" data-name="Icon feather-heart" d="M19.363,5.921a4.858,4.858,0,0,0-6.872,0l-.936.936-.936-.936a4.859,4.859,0,1,0-6.872,6.872l.936.936L11.555,20.6l6.872-6.872.936-.936a4.858,4.858,0,0,0,0-6.872Z" transform="translate(-2.323 -4.497)" fill="none"  stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                                          </g>
                                      </svg>

                                  </button>
                              </div>
                              <button
                                  onClick={() => setShowPopup(true)}
                                  className="bold underline text-custom-blue"
                              >
                                  Make an installment
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
              <div className="bg-white py-10">
                  <div className="wrapper text-sm pb-20">
                      <div className="text-custom-blue mb-6">More details</div>
                      <div className="lg:columns-3 sm:columns-2 w-full leading-relaxed gap-10">
                          {/*<div className="break-inside-avoid mb-7">
                              <p>processor</p>
                              <p>• Processor model: Intel Core i3-12100</p>
                              <p>• Number of cores: 4</p>
                              <p>• Number of streams: 8</p>
                              <p>• Frequency: 3.30 GHz</p>
                              <p>• Maximum frequency: 4.40 GHz</p>
                              <p>• Cache memory: 12 MB</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>RAM</p>
                              <p>Memory capacity: 8GB (1x 8GB DIMM)</p>
                              <p>• Number of cores: 4</p>
                              <p>• Memory type: DDR4</p>
                              <p>• RAM frequency: 3200MHz</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>processor</p>
                              <p>• Processor model: Intel Core i3-12100</p>
                              <p>• Number of cores: 4</p>
                              <p>• Number of streams: 8</p>
                              <p>• Frequency: 3.30 GHz</p>
                              <p>• Maximum frequency: 4.40 GHz</p>
                              <p>• Cache memory: 12 MB</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>RAM</p>
                              <p>Memory capacity: 8GB (1x 8GB DIMM)</p>
                              <p>• Number of cores: 4</p>
                              <p>• Memory type: DDR4</p>
                              <p>• RAM frequency: 3200MHz</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>processor</p>
                              <p>• Processor model: Intel Core i3-12100</p>
                              <p>• Number of cores: 4</p>
                              <p>• Number of streams: 8</p>
                              <p>• Frequency: 3.30 GHz</p>
                              <p>• Maximum frequency: 4.40 GHz</p>
                              <p>• Cache memory: 12 MB</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>RAM</p>
                              <p>Memory capacity: 8GB (1x 8GB DIMM)</p>
                              <p>• Number of cores: 4</p>
                              <p>• Memory type: DDR4</p>
                              <p>• RAM frequency: 3200MHz</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>processor</p>
                              <p>• Processor model: Intel Core i3-12100</p>
                              <p>• Number of cores: 4</p>
                              <p>• Number of streams: 8</p>
                              <p>• Frequency: 3.30 GHz</p>
                              <p>• Maximum frequency: 4.40 GHz</p>
                              <p>• Cache memory: 12 MB</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>RAM</p>
                              <p>Memory capacity: 8GB (1x 8GB DIMM)</p>
                              <p>• Number of cores: 4</p>
                              <p>• Memory type: DDR4</p>
                              <p>• RAM frequency: 3200MHz</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>processor</p>
                              <p>• Processor model: Intel Core i3-12100</p>
                              <p>• Number of cores: 4</p>
                              <p>• Number of streams: 8</p>
                              <p>• Frequency: 3.30 GHz</p>
                              <p>• Maximum frequency: 4.40 GHz</p>
                              <p>• Cache memory: 12 MB</p>
                          </div>
                          <div className="break-inside-avoid mb-7">
                              <p>RAM</p>
                              <p>Memory capacity: 8GB (1x 8GB DIMM)</p>
                              <p>
                                  * The manufacturer reserves the right to make changes to product
                                  features and design without prior notice. The store does not
                                  take responsibility for changes made by the manufacturer.
                              </p>
                          </div>*/}
                      </div>
                  </div>
              </div>
              <div className="bg-custom-zinc-200 py-10 pb-20">
                  <div className="wrapper">
                      <div className="bold text-lg mb-10">You may also like</div>
                      <ProductSlider />
                  </div>
              </div>
              <Installment show={showPopup} hide={() => setShowPopup(false)} />
          </>
      </Layout>

  );
};

export default SingleProduct;
