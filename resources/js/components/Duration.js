import * as React from "react";
import Box from "@mui/material/Box";
import Slider from "@mui/material/Slider";

function valuetext(value) {
  return `${value}°C`;
}

export default function DiscreteSlider() {
  return (
    <div className="flex items-center  ">
      <div className="opacity-59">6</div>
      <Box className="mx-3 lg:w-72 w-40">
        <Slider
          aria-label="Temperature"
          defaultValue={30}
          getAriaValueText={valuetext}
          valueLabelDisplay="auto"
          step={10}
          marks
          min={10}
          max={110}
        />
      </Box>
      <div className="opacity-59">48</div>
      <div className="bg-custom-zinc-200 py-2 px-3 rounded ml-4">36 month</div>
    </div>
  );
}
