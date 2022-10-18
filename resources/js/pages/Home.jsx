import React from "react";
import CategoryBox from "../components/CategoryBox";
import HeroSlider from "../components/HeroSlider";
import PartnerSlider from "../components/PartnerSlider";
import ProductSlider from "../components/ProductSlider";
import { DirectionBtn } from "../components/Shared";
//import Img1 from "../assets/images/products/14.png";
//import { Link } from "react-router-dom";
import { Link, usePage } from "@inertiajs/inertia-react";
//import Arrow from "../assets/images/icons/arrow.svg";
import Layout from "@/Layouts/Layout";

const Home = ({ seo }) => {
    const { categories, products, images, localizations, sections } =
        usePage().props;

    let categories_ = [];

    categories.map((item, index) => {
        if (parseInt(item.on_page) === 1) categories_.push(item);
    });

    //console.log(categories_,categories, products)
    return (
        <Layout seo={seo}>
            <>
                <HeroSlider />
                <section className="py-10 wrapper">
                    <div className="flex item-center justify-between mb-5">
                        <div className="text-lg bold">
                            {__("client.nav_best_price", localizations)}
                        </div>
                        <DirectionBtn
                            text={__("client.goto_page", localizations)}
                            link={route("client.category.special")}
                        />
                    </div>
                    <ProductSlider products={products.special_price_tag} />
                </section>
                <section className="wrapper py-10">
                    <CategoryBox categories={categories_} />
                </section>
                <section className="py-10 wrapper">
                    <div className="text-lg bold mb-5">
                        {__("client.partners", localizations)}
                    </div>
                    <PartnerSlider />
                </section>
                <section className="py-10 wrapper">
                    <div className="flex item-center justify-between mb-5">
                        <div className="text-lg bold">
                            {__("client.nav_popular", localizations)}
                        </div>
                        <DirectionBtn
                            text={__("client.goto_page", localizations)}
                            link={route("client.category.popular")}
                        />
                    </div>
                    <ProductSlider products={products.popular} />
                </section>
                <section className="bg-custom-yellow py-10 mb-10">
                    <div className="wrapper flex justify-between items-center flex-col md:flex-row">
                        <img
                            className="xl:ml-40 md:w-1/2 lg:w-auto"
                            src={images[0]}
                            alt=""
                        />
                        <div className="max-w-lg text-right">
                            <div className="text-custom-blue mb-3">
                                {sections[0].title}
                            </div>
                            <div className="lg:text-4xl text-2xl bold mb-6">
                                {sections[0].text}
                            </div>
                            <Link className="text-sm" href={sections[0].link}>
                                {__("client.learn_more", localizations)}
                                <img
                                    className="inline-block ml-2"
                                    src="/client/assets/images/icons/arrow.svg"
                                    alt=""
                                />
                            </Link>
                        </div>
                    </div>
                </section>
                <section className="py-10 wrapper">
                    <div className="flex item-center justify-between mb-5">
                        <div className="text-lg bold">
                            {__("client.nav_product_like", localizations)}
                        </div>
                        <DirectionBtn
                            text={__("client.goto_page", localizations)}
                            link={route("client.category.like")}
                        />
                    </div>
                    <ProductSlider products={products.rand_products} />
                </section>
            </>
        </Layout>
    );
};

export default Home;
