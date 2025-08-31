import GuestLayout from "@/Layouts/GuestLayout";
import PaginationNav from "@/Components/PaginationNav";
import PageLayout from "@/Layouts/PageLayout";
import { Card } from "@/Components/card";
import parse from "html-react-parser";

export default function Twibbon({ title, data }: { title: string; data: any }) {
  return (
    <GuestLayout>
      <PageLayout title={title}>
        <div className="max-w-7xl mx-auto">
          <div className="grid grid-cols-3 gap-4 lg:gap-7">
            {data.data.map((item: any, i: any) => (
              <div key={i} className="col-span-3 lg:col-span-1">
                <Card className="p-3 bg-white/90 backdrop-blur">
                  <img
                    className="w-full rounded-lg"
                    src={`/storage/${item.img}`}
                    alt="img"
                  />
                  <div className="mt-4 p-3 py-1">
                    <p className="text-base font-bold font-sen uppercase">
                      {item.title}
                    </p>
                    <div className="mt-1 text-sm prose prose-sm">
                      {parse(item.deskripsi)}
                    </div>
                    <p className="mt-3 text-sm font-medium">
                      <span className="text-black/60">Tagline :</span>{" "}
                      {item.slogan}
                    </p>
                    <button className="mt-4 bg-[#173454] hover:bg-opacity-90 text-white text-sm rounded w-full px-4 py-2 font-sen uppercase font-medium tracking-wider">
                      Buat
                    </button>
                  </div>
                </Card>
              </div>
            ))}
          </div>
          <div className="mt-8">
            <PaginationNav links={data.links} />
          </div>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
