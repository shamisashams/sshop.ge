import React, { useState } from "react";
import Box from "@mui/material/Box";
import Slider from "@mui/material/Slider";
import { Link, usePage } from '@inertiajs/inertia-react'

function valuetext(value) {
  return `${value}°C`;
}
export default function RangeSlider({appliedFilters}) {

    const { filter } = usePage().props;
    let min, max;

    if(appliedFilters.hasOwnProperty('price')){
        min = appliedFilters['price'][0];
        max = appliedFilters['price'][1];
    } else {
        min = 0;
        max = filter.price.max
    }


    const [value, setValue] = useState([min, max]);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  return (
    <>
      <div className="flex justify-between items-center mb-5">
        <div>
          <p className="opacity-70 text-sm mb-2">Min</p>
          <div className="rounded bg-custom-zinc-300 w-24 text-center py-1 mr-5">
            {value[0]} ₾
          </div>
        </div>
        <div>
          <p className="opacity-70 text-sm mb-2">Max</p>
          <div className="rounded bg-custom-zinc-300 w-24 text-center py-1">
            {value[1]} ₾
          </div>
        </div>
      </div>
      <Box sx={{ width: 300 }}>
        <Slider
          getAriaLabel={() => "Temperature range"}
          value={value}
          onChange={handleChange}
          getAriaValueText={valuetext}
        />
      </Box>
    </>
  );
}
