import GuestLayout from "@/Layouts/GuestLayout";
import PaginationNav from "@/Components/PaginationNav";
import PageLayout from "@/Layouts/PageLayout";
import { GlowingEffect } from "@/Components/ui/aceternity/glowing-effect";

export default function AllSubDomain({
  title,
  data,
}: {
  title: string;
  data: any;
}) {
  return (
    <GuestLayout>
      <PageLayout title={title}>
        <div className="max-w-7xl mx-auto">
          <div className="grid grid-cols-6 gap-4 lg:gap-5">
            {data.data.map((item: any, i: any) => (
              <div
                key={i}
                className={`bg-white/90 backdrop-blur relative text-center col-span-3 lg:col-span-1 border rounded-xl lg:rounded-3xl py-3 pb-10 lg:py-4 lg:pb-10`}
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

            <div className="mt-4 col-span-6">
              <PaginationNav links={data.links} />
            </div>
          </div>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
