// import Swiper core and required modules
import { Autoplay, EffectFade } from "swiper/modules";
import { Swiper, SwiperSlide } from "swiper/react";

import { Button } from "./ui/aceternity/moving-border";
import { TextGenerateEffect } from "./ui/aceternity/text-generate-effect";
import FormSearch from "./FormSearch";

const Hero = ({ slider }: any) => {
  return (
    <section className="relative h-[55vh] lg:h-[92vh] bg-cover bg-bottom">
      <div className="absolute inset-0 z-[99] h-full flex justify-center items-center">
        <div className="text-center">
          <div className="mb-5">
            <Button
              borderRadius="4px"
              duration={3500}
              className="border-none text-xs lg:text-sm bg-[#23529A] tracking-wider text-white uppercase font-sen font-light"
            >
              Selamat datang di website
            </Button>
          </div>
          <TextGenerateEffect
            className="p-text max-w-4xl font-extrabold text-white text-2xl lg:text-5xl leading-tight lg:leading-[53px] font-sen"
            duration={1}
            filter={true}
            words={"Portal Resmi Pemerintah Daerah Kota Kendari"}
          />

          <p className="p-text text-sm lg:text-base mx-auto mt-7 lg:mt-10 max-w-3xl text-slate-300 leading-relaxed">
            Kami siap untuk melayani masyarakat demi Terwujudnya Kota Kendari
            Tahun 2029 sebagai Kota Layak Huni yang Semakin Maju, Berdaya Saing,
            Adil, Sejahtera, dan Berkelanjutan.
          </p>
        </div>

        <div className="absolute w-[90%] lg:w-[40rem] bg-white shadow-lg rounded-[40px] px-0 py-3.5 lg:px-6 lg:py-5 -bottom-8 lg:-bottom-12">
          <FormSearch />
        </div>
      </div>

      <div className="h-full absolute z-[98] inset-0 bg-gradient-to-b from-black/45 to-black/85"></div>
      <Swiper
        modules={[Autoplay, EffectFade]}
        slidesPerView={1}
        loop
        autoplay={{
          delay: 3500,
          disableOnInteraction: false,
        }}
        effect="fade"
        speed={1500}
      >
        {slider.map((item: any, i: any) => (
          <SwiperSlide key={i}>
            <img
              src={`/storage/${item.image}`}
              alt="img"
              className="h-[55vh] lg:h-[92vh] w-full object-cover object-center"
            />
          </SwiperSlide>
        ))}
      </Swiper>
    </section>
  );
};

export default Hero;
