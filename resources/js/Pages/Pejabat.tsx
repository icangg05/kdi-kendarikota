import GuestLayout from "@/Layouts/GuestLayout";
import { Card } from "@/Components/card";
import PaginationNav from "@/Components/PaginationNav";
import PageLayout from "@/Layouts/PageLayout";

export default function Pejabat({
  title,
  pejabat,
}: {
  title: string;
  pejabat: any;
}) {
  return (
    <GuestLayout>
      <PageLayout title={title}>
        <div className="max-w-6xl mx-auto grid grid-cols-4 gap-6 lg:gap-7">
          {pejabat.data.map((item: any, i: any) => (
            <div key={i} className="px-6 lg:px-0 col-span-4 lg:col-span-1">
              <Card className="shadow-[0px_4px_16px_rgba(17,17,26,0.1),_0px_8px_24px_rgba(17,17,26,0.1),_0px_16px_56px_rgba(17,17,26,0.1)] rounded-3xl px-6 py-7 h-full w-full bg-blue-200 bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-0 border border-white/30">
                <img
                  src={
                    item.foto
                      ? `/storage/${item.foto}`
                      : "/img/default/foto-pejabat.png"
                  }
                  alt="img"
                  className="w-full border border-white/30 rounded-2xl aspect-[3/3.5] object-cover object-top"
                />
                <div className="mt-3 text-center">
                  <p className="font-bold text-sm font-sen">{item.nama}</p>
                  <p className="mt-1 text-[#173454] uppercase text-xs font-extrabold tracking-wide">
                    {item.jabatan.nama}
                  </p>
                  <p className="mt-2 text-sm font-medium tracking-wide">
                    {item.opd?.nama}
                  </p>
                </div>
              </Card>
            </div>
          ))}
        </div>

        <div className="mt-12">
          <PaginationNav links={pejabat.links} />
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
