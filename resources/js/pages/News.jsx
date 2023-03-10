import React from "react";
import NewsBox from "../components/NewsBox";
//import News1 from "../assets/images/news/1.png";
//import News2 from "../assets/images/news/2.png";
//import News3 from "../assets/images/news/3.png";
//import News4 from "../assets/images/news/4.png";
//import News5 from "../assets/images/news/5.png";
//import News6 from "../assets/images/news/6.png";
import Layout from "@/Layouts/Layout";
import { Link, usePage } from '@inertiajs/inertia-react'

const News = ({seo}) => {

    const {news, localizations, page} = usePage().props;

    const renderHTML = (rawHTML) =>
        React.createElement("p", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

  const newsData = [
    {
      img: "/client/assets/images/news/1.png",
      title: "News name",
      date: "10.09.2022",
      paragraph:
        "Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.",
      link: "/news-single",
    },
    {
      img: "/client/assets/images/news/2.png",
      title: "News name",
      date: "10.09.2022",
      paragraph:
        "Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.",
      link: "/news-single",
    },
    {
      img: "/client/assets/images/news/3.png",
      title: "News name",
      date: "10.09.2022",
      paragraph:
        "Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.",
      link: "/news-single",
    },
    {
      img: "/client/assets/images/news/4.png",
      title: "News name",
      date: "10.09.2022",
      paragraph:
        "Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.",
      link: "/news-single",
    },
    {
      img: "/client/assets/images/news/5.png",
      title: "News name",
      date: "10.09.2022",
      paragraph:
        "Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.",
      link: "/news-single",
    },
    {
      img: "/client/assets/images/news/6.png",
      title: "News name",
      date: "10.09.2022",
      paragraph:
        "Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.",
      link: "/news-single",
    },
  ];

  return (
      <Layout seo={seo}>
          <div className="batman">
              <div className="wrapper">
                  <div className="news-titles">
                      <div className="title">{page.title}</div>
                      <div className="paragraph">
                          {renderHTML(page.description)}
                      </div>
                  </div>
                  <div className="news-grid">
                      {news.data.map((item, index) => {
                          return (
                              <NewsBox
                                  key={index}
                                  link={route('client.news.show',item.slug)}
                                  img={item.latest_image ? item.latest_image.file_full_url : null}
                                  title={item.title}
                                  date={item.formatted_date}
                                  paragraph={item.short_description}
                              />
                          );
                      })}
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default News;
