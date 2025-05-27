import GuestLayout from "@/Layouts/GuestLayout";
import { Card } from "@/Components/card";
import PageLayout from "@/Layouts/PageLayout";
import { Phone } from "lucide-react";
import Maps from "@/Components/Maps";
import { Link, usePage } from "@inertiajs/react";

export default function EventPage({
  title,
  data,
}: {
  title: string;
  data: any;
}) {
  const { globalDirektori }: any = usePage().props;

  return (
    <GuestLayout>
      <PageLayout title={title}>
        <div className="max-w-6xl mx-auto">
          <div className="grid grid-cols-5 gap-5">
            <div className="col-span-5 lg:col-span-3">
              <Card className="p-6 lg:p-8 lg:px-9 flex flex-rpw gap-4 justify-between items-center">
                <Maps
                  name={data.nama}
                  latitude={data.latitude}
                  longitude={data.longitude}
                />
              </Card>
            </div>
            <div className="col-span-5 lg:col-span-2">
              <Card className="p-6 lg:p-8 lg:px-9 flex flex-rpw gap-4 justify-between items-center">
                <div>
                  <p className="font-sen text-lg font-bold leading-tight">
                    {data.nama}
                  </p>
                  <p className="text-sm my-4 mb-6">{data.alamat}</p>
                  <p className="text-sm flex items-center space-x-1.5 tracking-wide">
                    <Phone size={12} />{" "}
                    <span>{data.telp ?? "No phone data"}</span>
                  </p>
                </div>
              </Card>

              <Card className="mt-6 p-6 lg:p-8 lg:px-9">
                <p className="text-[#1D3D61] font-sen text-lg font-bold leading-tight uppercase">
                  Direktori
                </p>
                <div className="mt-4">
                  <div className="flex flex-wrap">
                    {globalDirektori.map((item: any, i: any) => (
                      <Link
                        key={i}
                        className="mr-1 mb-1 font-sen hover:bg-opacity-90 text-xs px-4 rounded py-2 bg-yellow-600 text-white font-semibold uppercase tracking-wider"
                        href={`/direktori/${item.slug}`}
                      >
                        {item.nama}
                      </Link>
                    ))}
                  </div>
                </div>
              </Card>
            </div>
          </div>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
