import React from "react";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'

const NewsBox = (props) => {
    const {localizations} = usePage().props;
  return (
    <div className="news-s">
      <div className="news-s-box">
        <div className="news-s-cover">
          <img src={props.img} alt="" />
        </div>
        <div className="box-wrapper">
          <div className="news-s-title">{props.title}</div>
          <div className="news-s-date">{props.date}</div>
          <div className="news-s-text">{props.paragraph}</div>
          <div className="btn-style">
            <Link className="main-btn bold" href={props.link}>
                {__('client.details', localizations)}
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
};

export default NewsBox;
