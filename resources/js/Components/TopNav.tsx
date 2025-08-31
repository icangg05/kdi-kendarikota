import { useEffect, useState } from "react";
import Clock from "./Clock";
import {
  MapPin,
  Clock as ClockIcon,
  Facebook,
  Instagram,
  Youtube,
} from "lucide-react";

const Topnav = () => {
  // https://www.tiktok.com/@kendarikota.go.id
  const icons = [
    {
      link: "https://www.facebook.com/people/Kendarikota/100083031531002/",
      icon: <Facebook className="w-[13px]" />,
    },
    {
      link: "https://www.instagram.com/kendarikotagoid/",
      icon: <Instagram className="w-[13px]" />,
    },
    {
      link: "https://www.youtube.com/@kendarikotagoid9481/featured",
      icon: <Youtube className="w-[13px]" />,
    },
  ];

  // Handle scrool nav
  const [isScrolled, setIsScrolled] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 400);
    };

    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  return (
    <div
      className={`hidden lg:block backdrop-blur bg-[#1A3C61]/95 z-[997] top-0 transform translate-y-[0px] fixed w-full text-white transition-all ease-out ${
        isScrolled && "!translate-y-[-35px]"
      }`}
    >
      <div className="py-1.5 pb-2 container flex items-center justify-between">
        <div className="flex items-center gap-7">
          <p className="font-sen text-xs text-white/90 flex items-center space-x-1">
            <MapPin className="w-[10px] text-white/80" />
            <span>Kendari, Sulawesi Tenggara</span>
          </p>

          <p className="text-xs text-white/90 flex items-center space-x-1">
            <ClockIcon className="w-[10px] text-white/80" />
            <Clock className="text-xs" />
          </p>
        </div>

        <div className="flex space-x-1.5 text-[10px]">
          {icons.map((item, i) => (
            <a
              aria-label="link"
              target="_blank"
              href={item.link}
              key={i}
              className="size-5 border border-white/30 inline-flex justify-center items-center rounded-full text-white/80 hover:text-white/90"
            >
              {item.icon}
            </a>
          ))}
        </div>
      </div>
    </div>
  );
};

export default Topnav;
