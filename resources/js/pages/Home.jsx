import React from "react";
import CategoryBox from "../components/CategoryBox";
import HeroSlider from "../components/HeroSlider";
import PartnerSlider from "../components/PartnerSlider";
import ProductSlider from "../components/ProductSlider";
import { DirectionBtn } from "../components/Shared";
//import Img1 from "../assets/images/products/14.png";
//import { Link } from "react-router-dom";
import { Link } from '@inertiajs/inertia-react'
//import Arrow from "../assets/images/icons/arrow.svg";
import Layout from "@/Layouts/Layout";


const Home = ({seo}) => {
  return (
      <Layout seo={seo}>
          <>
              <HeroSlider />
              <section className="py-10 wrapper">
                  <div className="flex item-center justify-between mb-5">
                      <div className="text-lg bold">Best Price</div>
                      <DirectionBtn text="Go to page" link="products" />
                  </div>
                  <ProductSlider />
              </section>
              <section className="wrapper py-10">
                  <CategoryBox />
              </section>
              <section className="py-10 wrapper">
                  <div className="text-lg bold mb-5">Popular Now</div>
                  <PartnerSlider />
              </section>
              <section className="py-10 wrapper">
                  <div className="flex item-center justify-between mb-5">
                      <div className="text-lg bold">Best Price</div>
                      <DirectionBtn text="Go to page" link="products" />
                  </div>
                  <ProductSlider />
              </section>
              <section className="bg-custom-yellow py-10 mb-10">
                  <div className="wrapper flex justify-between items-center flex-col md:flex-row">
                      <img className="xl:ml-40 md:w-1/2 lg:w-auto" src="/client/assets/images/products/14.png" alt="" />
                      <div className="max-w-lg text-right">
                          <div className="text-custom-blue mb-3">Product of a week</div>
                          <div className="lg:text-4xl text-2xl bold mb-6">
                              Bluetooth JBL Speaker for listening music.
                          </div>
                          <Link className="text-sm" href="/">
                              Learn More
                              <img className="inline-block ml-2" src="/client/assets/images/icons/arrow.svg" alt="" />
                          </Link>
                      </div>
                  </div>
              </section>
              <section className="py-10 wrapper">
                  <div className="flex item-center justify-between mb-5">
                      <div className="text-lg bold">You may like</div>
                      <DirectionBtn text="Go to page" link="products" />
                  </div>
                  <ProductSlider />
              </section>
          </>
      </Layout>

  );
};

export default Home;
