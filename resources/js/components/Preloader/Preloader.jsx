import React, { useState, useEffect } from "react";
import "./Preloader.css";
import PropTypes from "prop-types";
import LinearProgress from "@mui/material/LinearProgress";
import Typography from "@mui/material/Typography";
import Box from "@mui/material/Box";

const Preloader = () => {
    function LinearProgressWithLabel(props) {
        return (
            <Box className="progress">
                <Box sx={{ minWidth: 35 }}>
                    <Typography
                        variant="body2"
                        color="text.secondary"
                    >{`${Math.round(props.value)}%`}</Typography>
                </Box>
                <Box sx={{ width: "100%", mr: 1 }}>
                    <LinearProgress variant="determinate" {...props} />
                </Box>
            </Box>
        );
    }

    LinearProgressWithLabel.propTypes = {
        /**
         * The value of the progress indicator for the determinate and buffer variants.
         * Value between 0 and 100.
         */
        value: PropTypes.number.isRequired,
    };
    const [progress, setProgress] = useState(0);

    useEffect(() => {
        const timer = setInterval(() => {
            setProgress((prevProgress) =>
                prevProgress >= 100 ? 100 : prevProgress + 1
            );
        }, 30);
        return () => {
            clearInterval(timer);
        };
    }, []);

    return (
        <div
            id="preloader"
            className="fixed left-0 top-0 bg-white w-screen h-screen "
        >
            <div className="wrapper h-full flex items-center justify-center flex-col">
                <div className="container w-fit h-fit relative">
                    <img
                        className="img-1"
                        src="/client/assets/images/preloader/1.png"
                        alt=""
                    />
                    {/* imgs */}
                    <img
                        className="imgs img-2"
                        src="/client/assets/images/preloader/2.png"
                        alt=""
                    />
                    <img
                        className="imgs img-3"
                        src="/client/assets/images/preloader/3.png"
                        alt=""
                    />
                    <img
                        className="imgs img-4"
                        src="/client/assets/images/preloader/4.png"
                        alt=""
                    />
                    <img
                        className="imgs img-5"
                        src="/client/assets/images/preloader/5.png"
                        alt=""
                    />
                    <img
                        className="imgs img-6"
                        src="/client/assets/images/preloader/5.png"
                        alt=""
                    />
                    <img
                        className="imgs img-7"
                        src="/client/assets/images/preloader/6.png"
                        alt=""
                    />
                </div>
                <div className="text-center max-w-lg mx-auto md:mt-20 mb-20 md:mb-0">
                    <div className="bold md:mb-3">
                        Getting ready for comfort shopping
                    </div>
                    <Box sx={{ width: "100%" }}>
                        <LinearProgressWithLabel value={progress} />
                    </Box>
                </div>
            </div>
        </div>
    );
};

export default Preloader;
