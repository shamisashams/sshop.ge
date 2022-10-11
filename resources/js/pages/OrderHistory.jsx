import React from "react";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
import CabinetNav from "../components/CabinetNav";
import Layout from "@/Layouts/Layout";

const OrderHistory = ({seo}) => {

    const {orders} = usePage().props;


    let links = function (links) {
        let rows = [];
        //links.shift();
        //links.splice(-1);
        {
            links.map(function (item, index) {
                if (index > 0 && index < links.length - 1) {
                    rows.push(
                        <li>
                        <Link
                            href={item.url}
                            className={
                                item.active
                                    ? "bold mx-2 underline"
                                    : "bold mx-2"
                            }
                        >
                            <span className="visuallyhidden"> </span>{item.label}
                        </Link>
                        </li>
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
            <li>
            <Link href={links[0].url}>
                <span aria-hidden="true">«</span>
                <span className="visuallyhidden">
                          This takes you to the first page
                        </span>
            </Link>
        </li>
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
            <li>
            <Link href={links[links.length - 1].url}>
                <span aria-hidden="true">»</span>
                <span className="visuallyhidden">
                          This takes you to the last page
                        </span>
            </Link>
        </li>
        ) : null;
    };

  return (
      <Layout seo={seo}>
          <div className="batman" id="fio-page">
              <div className="abs-div"></div>
              <div className="wrapper flex">
                  <CabinetNav active={2} />
                  <div className="batman">
                      <div id="order-history">
                          <div className="fio-details">
                              <div className="fio-title">Order history</div>
                              <div className="table">
                                  <table>
                                      <tr>
                                          <th>Id</th>
                                          <th>Date</th>
                                          <th>Price</th>
                                      </tr>
                                      {orders.data.map((item,index) => {
                                          let grand_total = item.grand_total;
                                          if (item.discount){
                                              grand_total = grand_total - ((item.discount * grand_total) / 100);
                                          }
                                          return (
                                              <tr>
                                                  <td>
                                                      {/*<p>Small Chair</p>
                                                      <p>Color: gray</p>
                                                      <p>Quantity: 1</p>*/}
                                                      {item.id}
                                                  </td>
                                                  <td className="opacity-h">{item.formatted_date}</td>
                                                  <td className="bold">₾{grand_total}</td>
                                              </tr>
                                          )
                                      })}
                                      {/*<tr>
                                          <td>
                                              <p>Small Chair</p>
                                              <p>Color: gray</p>
                                              <p>Quantity: 1</p>
                                          </td>
                                          <td className="opacity-h">15.05.2022</td>
                                          <td className="bold">₾3255.00</td>
                                      </tr>
                                      <tr>
                                          <td>
                                              <p>Small Chair</p>
                                              <p>Color: gray</p>
                                              <p>Quantity: 1</p>
                                          </td>
                                          <td className="opacity-h">15.05.2022</td>
                                          <td className="bold">₾125.00</td>
                                      </tr>
                                      <tr>
                                          <td>
                                              <p>Small Chair</p>
                                              <p>Color: gray</p>
                                              <p>Quantity: 1</p>
                                          </td>
                                          <td className="opacity-h">15.05.2022</td>
                                          <td className="bold">₾55.00</td>
                                      </tr>
                                      <tr>
                                          <td>
                                              <p>Small Chair</p>
                                              <p>Color: gray</p>
                                              <p>Quantity: 1</p>
                                          </td>
                                          <td className="opacity-h">15.05.2022</td>
                                          <td className="bold">₾318.00</td>
                                      </tr>*/}
                                  </table>
                              </div>
                              <div className="history-pagination">
                                  <nav aria-label="pagination">
                                      <ul className="pagination">

                                          {linksPrev(orders.links)}
                                          {/*<li>
                                              <Link href="/">
                                                  <span className="visuallyhidden"> </span>1
                                              </Link>
                                          </li>
                                          <li>
                                              <Link href="/" aria-current="page">
                                                  <span className="visuallyhidden"> </span>2
                                              </Link>
                                          </li>
                                          <li>
                                              <Link href="/">
                                                  <span className="visuallyhidden"> </span>3
                                              </Link>
                                          </li>
                                          <li>
                                              <Link href="/">
                                                  <span className="visuallyhidden"> </span>4
                                              </Link>
                                          </li>*/}
                                          {links(orders.links)}
                                          {/*<li>
                                              <Link href="/">
                                                  <span aria-hidden="true">»</span>
                                                  <span className="visuallyhidden">
                          This takes you to the last page
                        </span>
                                              </Link>
                                          </li>*/}
                                          {linksNext(orders.links)}
                                      </ul>
                                  </nav>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </Layout>

  );
};

export default OrderHistory;
