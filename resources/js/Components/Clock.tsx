import { useState, useEffect } from "react";

const Clock = ({ className = "" }: { className?: string }) => {
  const [time, setTime] = useState(getTime());

  useEffect(() => {
    const interval = setInterval(() => {
      setTime(getTime());
    }, 1000);

    return () => clearInterval(interval);
  }, []);

  function getTime() {
    const now = new Date().toLocaleString("en-US", {
      timeZone: "Asia/Makassar",
      hour12: false,
    });

    const date = new Date(now);
    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");
    const seconds = String(date.getSeconds()).padStart(2, "0");

    return `${hours}:${minutes}:${seconds}`;
  }

  return <span className={`${className} font-mono`}>{time} WITA</span>;
};

export default Clock;
