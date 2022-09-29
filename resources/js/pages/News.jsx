import React from "react";
import NewsBox from "../components/NewsBox";
//import News1 from "../assets/images/news/1.png";
//import News2 from "../assets/images/news/2.png";
//import News3 from "../assets/images/news/3.png";
//import News4 from "../assets/images/news/4.png";
//import News5 from "../assets/images/news/5.png";
//import News6 from "../assets/images/news/6.png";

const News = () => {
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
    <div className="batman">
      <div className="wrapper">
        <div className="news-titles">
          <div className="title">News</div>
          <div className="paragraph">
            We serve clients in financial services, law, insurance, diverse
            corporate sectors and strategy consulting. We design innovative and
            differentiated content ideas for our clients` worldwide conferences
            and events of all sizes.
          </div>
        </div>
        <div className="news-grid">
          {newsData.map((item, index) => {
            return (
              <NewsBox
                key={index}
                link={item.link}
                img={item.img}
                title={item.title}
                date={item.date}
                paragraph={item.paragraph}
              />
            );
          })}
        </div>
      </div>
    </div>
  );
};

export default News;
