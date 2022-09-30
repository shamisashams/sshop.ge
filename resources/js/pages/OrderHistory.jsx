import React from "react";
//import { Link } from "react-router-dom";
import { Link } from '@inertiajs/inertia-react'
import CabinetNav from "../components/CabinetNav";
import Layout from "@/Layouts/Layout";

const OrderHistory = ({seo}) => {
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
                                          <th>Product</th>
                                          <th>Date</th>
                                          <th>Price</th>
                                      </tr>
                                      <tr>
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
                                      </tr>
                                  </table>
                              </div>
                              <div className="history-pagination">
                                  <nav aria-label="pagination">
                                      <ul className="pagination">
                                          <li>
                                              <Link href="/">
                                                  <span aria-hidden="true">«</span>
                                                  <span className="visuallyhidden">
                          This takes you to the first page
                        </span>
                                              </Link>
                                          </li>
                                          <li>
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
                                          </li>
                                          <li>
                                              <Link href="/">
                                                  <span aria-hidden="true">»</span>
                                                  <span className="visuallyhidden">
                          This takes you to the last page
                        </span>
                                              </Link>
                                          </li>
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
