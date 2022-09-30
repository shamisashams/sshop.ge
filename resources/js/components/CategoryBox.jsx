import React from "react";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
import { DirectionBtn } from "./Shared";
//import Img1 from "../assets/images/products/10.png";
//import Img2 from "../assets/images/products/11.png";
//import Img3 from "../assets/images/products/12.png";
//import Img4 from "../assets/images/products/13.png";

const CategoryBox = ({categories}) => {

  const categoryBoxes = [
    {
      title: "Computers",
      img: "/client/assets/images/products/10.png",
      link: "/",
      list: [
        {
          href: "/",
          text: "Data storage",
        },
        {
          href: "/",
          text: "Destkop PC",
        },
        {
          href: "/",
          text: "Keyboard",
        },
        {
          href: "/",
          text: "Monitors",
        },
        {
          href: "/",
          text: "Mouse",
        },
        {
          href: "/",
          text: "Tablet",
        },
      ],
    },
    {
      title: "Home Electronics",
      img: "/client/assets/images/products/11.png",
      link: "/",
      list: [
        {
          href: "/",
          text: "Sewing Technique",
        },
        {
          href: "/",
          text: "Vacuum Cleaners",
        },
        {
          href: "/",
          text: "Irons",
        },
        {
          href: "/",
          text: "Epilators",
        },
        {
          href: "/",
          text: "Hair Dryers",
        },
        {
          href: "/",
          text: "Electric Shavers",
        },
      ],
    },
    {
      title: "Toys and Games",
      img: "/client/assets/images/products/12.png",
      link: "/",
      list: [
        {
          href: "/",
          text: "Building Toys",
        },
        {
          href: "/",
          text: "Accessories",
        },
        {
          href: "/",
          text: "Irons",
        },
        {
          href: "/",
          text: "Epilators",
        },
        {
          href: "/",
          text: "Hair Dryers",
        },
        {
          href: "/",
          text: "Puzzles",
        },
      ],
    },
    {
      title: "Furniture and Mattress",
      img: "/client/assets/images/products/13.png",
      link: "/",
      list: [
        {
          href: "/",
          text: "Furniture",
        },
        {
          href: "/",
          text: "Garden Furniture and Accessories",
        },
        {
          href: "/",
          text: "Mattress",
        },
      ],
    },
  ];

  return (
    <>
      <div className="grid lg:grid-cols-2 lg:gap-6 gap-3 xl:text-base text-sm">
        {categories.map((item, index) => {
          return (
            <div
              key={index}
              className="rounded sm:p-8 p-4 w-full h-full flex justify-between items-center"
              style={{ background: "#EEF3F9" }}
            >
              <div className="flex flex-col justify-between items-start h-full">
                <div>
                  <div className="bold lg:text-2xl text-lg mb-5">
                    {item.title}
                  </div>
                  <div className="mb-6">
                    {item.children.map((el, index) => {
                      return (
                        <Link
                          key={index}
                          href={route('client.category.show',el.slug)}
                          className="block lg:mb-3 mb-1"
                        >
                          {el.title}
                        </Link>
                      );
                    })}
                  </div>
                </div>
                <DirectionBtn link={route('client.category.show',item.slug)} text="Go to page" />
              </div>
              <img className="max-w-sm xl:w-auto w-1/2" src={item.file ? item.file.file_full_url:null} alt="" />
            </div>
          );
        })}
      </div>
    </>
  );
};

export default CategoryBox;
