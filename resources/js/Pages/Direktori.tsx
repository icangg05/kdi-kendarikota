import GuestLayout from "@/Layouts/GuestLayout";
import { Card } from "@/Components/card";
import PageLayout from "@/Layouts/PageLayout";
import { Map, Phone } from "lucide-react";
import { Link } from "@inertiajs/react";
import PaginationNav from "@/Components/PaginationNav";

export default function Direktori({
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
            {data.data.length == 0 ? (
              <Card className="col-span-2 p-6 lg:p-8 lg:px-9 flex flex-row gap-4 justify-between items-center h-full">
                <p className="mx-auto text-sm text-black/70">Belum ada data.</p>
              </Card>
            ) : (
              data.data.map((item: any, i: any) => (
                <div key={i} className="col-span-2 lg:col-span-1">
                  <Card className="p-6 lg:p-8 lg:px-9 flex flex-row gap-4 justify-between items-center h-full">
                    <div>
                      <p className="font-sen text-base font-bold leading-tight">
                        {item.nama}
                      </p>
                      <p className="text-xs mt-2 mb-4">{item.alamat}</p>
                      <p className="text-xs flex items-center space-x-1.5 tracking-wide">
                        <Phone size={12} />{" "}
                        <span>{item.telp ?? "No phone data"}</span>
                      </p>
                    </div>
                    <div>
                      <Link href={`/direktori/lokasi/${item.id}`}>
                        <Map className="size-[40px] lg:size-[52px] text-white bg-gradient-to-b from-yellow-400/80 to-yellow-700/80 hover:from-yellow-400/95 hover:to-yellow-700/95 rounded-full p-2.5 lg:p-3" />
                      </Link>
                    </div>
                  </Card>
                </div>
              ))
            )}
          </div>

          <div className="mt-12 relative z-[99]">
            <PaginationNav links={data.links} />
          </div>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
