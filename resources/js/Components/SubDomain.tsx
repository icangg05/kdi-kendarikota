import { Link, usePage } from "@inertiajs/react";
import { GlowingEffect } from "./ui/aceternity/glowing-effect";

const SubDomain = () => {
  const { aplikasi }: any = usePage().props;

  return (
    <section className="py-12 pb-16 pt-0">
      <div>
        <div className="mb-6">
          <p className="font-sen text-xl lg:text-3xl font-bold">Akses Cepat</p>
          <p className="text-xs lg:text-sm italic">
            Terhubung ke berbagai layanan melalui tautan berikut
          </p>
        </div>

        <div className="grid grid-cols-6 gap-4 lg:gap-5">
          {aplikasi.map((item: any) => (
            <div
              key={item.id}
              className={`relative text-center col-span-3 border rounded-xl lg:rounded-3xl py-3 pb-10 lg:py-4 lg:pb-10 ${
                location.pathname == "/" ? "lg:col-span-2" : "lg:col-span-1"
              }`}
            >
              <GlowingEffect
                blur={0}
                borderWidth={2}
                spread={80}
                glow={true}
                disabled={false}
                proximity={64}
                inactiveZone={0.01}
              />
              <div className="mx-auto flex items-center justify-center border-2 border-[#1A5590]/15 size-16 lg:size-20 p-3 lg:p-3.5 rounded-full">
                <img
                  src={
                    item.icon
                      ? `/storage/${item.icon}`
                      : "/img/default/icon-aplikasi.png"
                  }
                  alt="img"
                  className="object-cover object-center"
                  loading="lazy"
                />
              </div>
              <p className="text-xs lg:text-sm font-bold uppercase my-2 mb-3 lg:mb-4 font-sen">
                {item.nama}
              </p>
              <div className="absolute bottom-3 w-full">
                <a
                  aria-label="link"
                  href={item.link}
                  target="_blank"
                  className="hover:bg-opacity-90 w-[80%] transition inline-block text-[9px] lg:text-[10px] font-bold uppercase rounded lg:rounded-xl px-5 py-2 bg-main text-white "
                >
                  Kunjungi
                </a>
              </div>
            </div>
          ))}

          <div className="mt-4 text-center col-span-6">
            <Link
              href={"/all-sub-domain"}
              className="mt-3 bg-white border px-6 py-2.5 rounded text-black text-xs lg:text-sm transition ease-out hover:bg-gray-100"
            >
              Lihat lainnya
            </Link>
          </div>
        </div>
      </div>
    </section>
  );
};

export default SubDomain;
