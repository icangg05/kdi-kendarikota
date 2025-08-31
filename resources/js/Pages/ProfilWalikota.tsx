import GuestLayout from "@/Layouts/GuestLayout";
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/Components/card";
import PageLayout from "@/Layouts/PageLayout";
import parse from "html-react-parser";
import { ArrowBigUp } from "lucide-react";

export default function ProfilWalikota({
  title,
  data,
}: {
  title: string;
  data: any;
}) {
  return (
    <GuestLayout>
      <PageLayout title={title}>
        <div className="mx-auto max-w-5xl">
          <div className="grid grid-cols-6 gap-5">
            <div className="col-span-6 lg:col-span-2">
              <Card className="shadow-2xl shadow-blue-500/20">
                <CardContent className="pt-6">
                  <img
                    className="border rounded w-full"
                    src={
                      data?.foto
                        ? `/storage/${data.foto}`
                        : "/img/default/foto-pejabat.png"
                    }
                    alt="img"
                  />
                </CardContent>
                <CardFooter className="flex flex-col">
                  <p className="text-lg font-bold font-sen">
                    {data?.nama ? data.nama : "No name"}
                  </p>
                  <p className="tracking-wide text-sm text-main font-extrabold uppercase">
                    {data?.jabatan.nama}
                  </p>
                </CardFooter>
              </Card>
            </div>
            <div className="col-span-6 lg:col-span-4">
              <Card className="p-0 lg:px-3 lg:py-2 shadow-2xl shadow-blue-500/20">
                <CardHeader>
                  <CardTitle className="text-base lg:text-lg font-bold">
                    Biodata Lengkap
                  </CardTitle>
                </CardHeader>
                <CardContent className="prose prose-sm prose-zinc">
                  {parse(data?.keterangan ? data.keterangan : "No data")}
                </CardContent>
                <CardFooter className="flex flex-col lg:flex-row space-y-3 lg:space-y-0 justify-between">
                  <a
                    aria-label="link"
                    href="#"
                    className="flex items-center space-x-1 text-sm hover:underline font-medium"
                  >
                    <ArrowBigUp className="w-[18px]" />
                    <span> Kembali ke atas</span>
                  </a>
                </CardFooter>
              </Card>
            </div>
          </div>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
