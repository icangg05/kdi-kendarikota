import Hero from "@/Components/Hero";
import News from "@/Components/News";
import Pejabat from "@/Components/Pejabat";
import SubDomain from "@/Components/SubDomain";
import { Card } from "@/Components/card";
import Walikota from "@/Components/Walikota";
import GuestLayout from "@/Layouts/GuestLayout";
import { useEffect, useState } from "react";

import { Autoplay, EffectFade, Navigation } from "swiper/modules";
import { Swiper, SwiperSlide } from "swiper/react";
import Fancybox from "@/Components/Fancybox";
import { CircleArrowLeft, CircleArrowRight } from "lucide-react";
import MarqueeText from "@/Components/MarqueeText";

export default function Welcome({
  youtube,
  pejabat,
  infografis,
  twibbon,
  slider,
  banner,
}: any) {
  const [widgetLoading, setWidgetLoading] = useState(true);
  const [widgetError, setWidgetError] = useState(false);
  const [countWidget, setCountWidget] = useState(0);

  useEffect(() => {
    const iframe = document.querySelector("#gpr-kominfo-widget-body");
    if (iframe) {
      setWidgetLoading(false);
      setWidgetError(false);
    }

    setInterval(() => {
      const iframe = document.querySelector("#gpr-kominfo-widget-body");
      if (iframe) {
        setWidgetLoading(false);
        setWidgetError(false);
      }
    }, 2000);
  }, []);

  useEffect(() => {
    setWidgetLoading(true);
    setWidgetError(false);

    const script = document.createElement("script");
    script.src = "https://widget.kominfo.go.id/gpr-widget-kominfo.min.js";
    script.async = true;

    // Handler ketika script berhasil dimuat
    script.onload = () => {
      // Cek apakah container body widget sudah ada
      const checkWidget = setInterval(() => {
        const iframe = document.querySelector("#gpr-kominfo-widget-body");
        if (iframe) {
          console.log("Widget Kominfo berhasil dirender");
          clearInterval(checkWidget);
        }
      }, 500);
    };

    // Handler ketika script gagal dimuat
    script.onerror = () => {
      console.error("Gagal memuat script widget Kominfo");
      setWidgetLoading(false);
      setWidgetError(true);
    };

    document.body.appendChild(script);

    return () => {
      document.body.removeChild(script);
    };
  }, [countWidget]);

  return (
    <GuestLayout>
      <Hero slider={slider} />
      <Walikota banner={banner} />

      {/* Teks berjalan */}
      <MarqueeText />

      <News
        widgetError={widgetError}
        setWidgetError={setWidgetError}
        setCountWidget={setCountWidget}
        widgetLoading={widgetLoading}
        setWidgetLoading={setWidgetLoading}
      />
      <div className="container pb-5">
        <div className="grid grid-cols-10 gap-0 lg:gap-10">
          <div className="col-span-10 lg:col-span-7">
            <SubDomain />
          </div>

          <div className="col-span-10 lg:col-span-3 flex flex-col gap-5 lg:gap-8">
            {/* Pejabat Pemerintah */}
            <div>
              <div className="mb-5 lg:mb-6">
                <h1 className="mb-0.5 font-sen text-xl font-bold">
                  Pejabat Pemerintah
                </h1>
                <p className="text-xs lg:text-sm italic">
                  Pejabat Pemerintah Daerah Kota Kendari
                </p>
              </div>
              <Card className="p-5">
                <Swiper
                  modules={[Autoplay, EffectFade]}
                  slidesPerView={1}
                  loop
                  autoplay={{
                    delay: 3500,
                    disableOnInteraction: false,
                  }}
                  speed={1000}
                  effect="fade"
                >
                  {pejabat.map((item: any, i: any) => (
                    <SwiperSlide key={i} className="relative group">
                      <img
                        className="transition ease-out brightness-[0.9] group-hover:brightness-50 border aspect-[3/4] object-cover object-top w-full"
                        src={
                          item.foto
                            ? `/storage/${item.foto}`
                            : "/img/default/foto-pejabat.png"
                        }
                        alt="img"
                        loading="lazy"
                      />
                      <div className="p-5 font-sen text-start text-white absolute -bottom-[50%] duration-500 transition-all ease-out group-hover:bottom-0">
                        <p className="font-bold text-base">{item.nama}</p>
                        <p className="font-normal text-sm">
                          {item.jabatan.nama}
                        </p>
                      </div>
                    </SwiperSlide>
                  ))}
                </Swiper>
              </Card>
            </div>
            {/* Infografis */}
            <div className="p-1 lg:p-0">
              <div className="flex items-center justify-between mb-3">
                <h1 className="font-sen text-xl font-bold">Infografis</h1>
                {/* Tombol Next dan Prev */}
                <div className="flex gap-1">
                  <button
                    aria-label="prev button"
                    className="swiper-button-prev-infografis text-sky-700/70"
                  >
                    <CircleArrowLeft />
                  </button>
                  <button
                    aria-label="next button"
                    className="swiper-button-next-infografis text-sky-700/70"
                  >
                    <CircleArrowRight />
                  </button>
                </div>
              </div>
              <Fancybox
                options={{
                  Carousel: {
                    infinite: false,
                    Navigation: false,
                  },
                }}
              >
                <Swiper
                  modules={[Navigation]}
                  slidesPerView={1}
                  loop
                  navigation={{
                    nextEl: ".swiper-button-next-infografis",
                    prevEl: ".swiper-button-prev-infografis",
                  }}
                >
                  {infografis.map((item: any, i: number) => (
                    <SwiperSlide key={i}>
                      <Card className="py-5">
                        <a
                          aria-label="link"
                          data-fancybox="gallery"
                          href={location.origin + `/storage/${item.img}`}
                        >
                          <img
                            className="w-full lg:w-[94%] mx-auto transition ease-out group-hover:brightness-50 rounded-none lg:rounded-lg border"
                            src={
                              item.img
                                ? `/storage/${item.img}`
                                : "/img/default/foto-pejabat.png"
                            }
                            alt="img"
                            loading="lazy"
                          />
                        </a>
                      </Card>
                    </SwiperSlide>
                  ))}
                </Swiper>
              </Fancybox>
            </div>
          </div>
        </div>
      </div>

      <Pejabat twibbon={twibbon} youtube={youtube} />
    </GuestLayout>
  );
}
