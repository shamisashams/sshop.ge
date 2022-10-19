import React from "react";
import { Link, usePage } from "@inertiajs/inertia-react";
import { DirectionBtn } from "./Shared";

const CategoryBox = ({ categories }) => {
    const { localizations } = usePage().props;

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
                                                    href={route(
                                                        "client.category.show",
                                                        el.slug
                                                    )}
                                                    className="block lg:mb-3 mb-1"
                                                >
                                                    {el.title}
                                                </Link>
                                            );
                                        })}
                                    </div>
                                </div>
                                <DirectionBtn
                                    link={route(
                                        "client.category.show",
                                        item.slug
                                    )}
                                    text={__("client.goto_page", localizations)}
                                />
                            </div>
                            <img
                                className="max-w-sm xl:w-auto w-1/2"
                                src={item.file ? item.file.file_full_url : null}
                                alt=""
                            />
                        </div>
                    );
                })}
            </div>
        </>
    );
};

export default CategoryBox;
