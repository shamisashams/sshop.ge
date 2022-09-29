import { useEffect } from "react";
import { useRef, useState } from "react";

const Input = ({ label, type, id }) => {
  const inputRef = useRef();
  const labelRef = useRef();
  const [valued, setValued] = useState(false);

  const onChange = () => {
    if (inputRef.current.value !== "") {
      setValued(true);
    }
    console.log(valued);
  };

  return (
    <div className="col-3 input-effect">
      <input
        onChange={onChange}
        ref={inputRef}
        className="effect-19"
        type={type}
        id={id}
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
