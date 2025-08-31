import GuestLayout from "@/Layouts/GuestLayout";
import { Card } from "@/Components/card";
import PageLayout from "@/Layouts/PageLayout";
import { CalendarDays, Navigation } from "lucide-react";
import PaginationNav from "@/Components/PaginationNav";

export default function EventPage({
  title,
  data,
}: {
  title: string;
  data: any;
}) {
  return (
    <GuestLayout>
      <PageLayout title={title}>
        <div className="max-w-6xl mx-auto">
          <div className="grid grid-cols-2 gap-5">
            {data.data.map((item: any, i: any) => (
              <div key={i} className="col-span-2 lg:col-span-1">
                <Card className="p-6 lg:p-8 lg:px-9 flex flex-col lg:flex-row gap-6 lg:gap-10 justify-between items-center h-full">
                  <div className="flex w-full lg:w-[140px] flex-col items-center text-center">
                    <p>
                      <Navigation className="size-[40px] lg:size-[52px] text-white bg-gradient-to-b from-yellow-400/80 to-yellow-700/80 rounded-full p-2.5 lg:p-3" />
                    </p>
                    <p className="mt-5 lg:mt-4 text-sm font-bold">
                      {item.lokasi}
                    </p>
                  </div>
                  <div className="flex-1 w-full">
                    <p className="font-sen text-base font-bold leading-tight">
                      {item.nama}
                    </p>
                    <p className="text-xs mt-2 lg:mt-3 mb-4">
                      {item.deskripsi}
                    </p>
                    <p className="text-xs flex items-center space-x-1.5 tracking-wide">
                      <CalendarDays size={12} /> <span>{item.tanggal}</span>
                    </p>
                  </div>
                </Card>
              </div>
            ))}
          </div>

          <div className="mt-12 relative z-[99]">
            <PaginationNav links={data.links} />
          </div>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
