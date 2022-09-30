import { useEffect } from "react";
import React, { useRef, useState } from "react";

const Input = ({ label, type, id, value, onChange }) => {
  const inputRef = useRef();
  const labelRef = useRef();
  const [valued, setValued] = useState(false);

  const onChange2 = (e) => {
    if (inputRef.current.value !== "") {
      setValued(true);
    }
    console.log(valued);
    onChange(e);
  };

    useEffect(
        () => {
            if (inputRef.current.value !== "") {
                setValued(true);
            } else {
                setValued(false);
            }
        },
    );

  return (
    <div className="col-3 input-effect">
      <input
        onChange={onChange2}
        ref={inputRef}
        className="effect-19"
        type={type}
        id={id}
        value={value}
        placeholder=""
      />
      <label className={valued ? "hasValue" : ""} ref={labelRef}>
        {label}
      </label>
      <span className="focus-border">
        <i></i>
      </span>
    </div>
  );
};

export default Input;
