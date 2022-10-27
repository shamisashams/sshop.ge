<div
    className={`categories absolute left-0 top-full w-full transition-all duration-500 lg:text-base text-sm  ${
        openMenu ? "translate-y-0 top-full" : "-translate-y-full -top-full"
    }`}
>
    <div className="w-full h-full bg-white/[0.9] backdrop-blur-md py-10 ">
        <div className="wrapper flex items-start justify-start">
            <div className="md:pr-10 pr-5 md:mr-10 mr-5 ">
                {categories.map((item, index) => {
                    subCategories.push(item.children);

                    console.log(subCategories);
                    return (
                        <button
                            onClick={() => mainCatClick(index)}
                            key={index + 1}
                            className={`mb-3 block hover:text-custom-blue transition-all text-left ${
                                index + 1 === catIndex ? "text-custom-blue" : ""
                            }`}
                        >
                            {item.title}
                        </button>
                    );
                })}
            </div>
            <div
                className={`transition-all duration-500
              ${
                  catIndex === 0
                      ? "invisible opacity-0 -translate-x-full"
                      : "visible opacity-100 translate-x-0"
              }
           `}
            >
                {subCategories.map((cat, index) => {
                    let children = [];
                    return (
                        <div
                            key={index}
                            className={`${
                                catIndex === index + 1 ? "block" : "hidden"
                            } md:mr-20 mr-10 `}
                        >
                            {cat.map((item, index) => {
                                subCategories2[item.id] = item.children;
                                console.log(subCategories2);
                                return (
                                    <button
                                        key={index + 1}
                                        onClick={() => {
                                            if (item.children.length > 0) {
                                                setSubCatIndex(item.id);
                                            } else {
                                                toSubCategory(item.slug);
                                            }

                                            //alert(subCatIndex)
                                        }}
                                        className={`block mb-3 hover:text-custom-blue hover:fill-custom-blue transition-all text-left ${
                                            item.id === subCatIndex
                                                ? "text-custom-blue fill-custom-blue"
                                                : ""
                                        }`}
                                    >
                                        {item.title}
                                        {item.children.length > 0 ? (
                                            <BiChevronRight className="inline-block w-5 h-5 fill-inherit" />
                                        ) : null}
                                    </button>
                                );
                            })}
                        </div>
                    );
                })}
            </div>
            <div
                className={` transition-all duration-500
               ${
                   subCatIndex === 0
                       ? "invisible opacity-0 -translate-x-full"
                       : "visible opacity-100 translate-x-0"
               }
            `}
            >
                {Object.keys(subCategories2).map((cat, index) => {
                    cat = parseInt(cat);
                    return (
                        <div
                            key={index}
                            className={`${
                                subCatIndex === cat ? "block" : "hidden"
                            } `}
                        >
                            {subCategories2[cat].map((item, index) => {
                                return (
                                    <Link
                                        key={index}
                                        href={route(
                                            "client.category.show",
                                            item.slug
                                        )}
                                        className={`block mb-3 hover:text-custom-blue hover:fill-custom-blue transition-all `}
                                    >
                                        {item.title}
                                    </Link>
                                );
                            })}
                        </div>
                    );
                })}
            </div>
        </div>
    </div>
    ;
</div>;
