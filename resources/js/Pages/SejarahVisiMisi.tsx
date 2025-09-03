import GuestLayout from "@/Layouts/GuestLayout";
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/Components/card";
import parse from "html-react-parser";
import PageLayout from "@/Layouts/PageLayout";
import { ArrowBigUp, Calendar } from "lucide-react";
import { formatTanggalIndo } from "@/lib/utils";

export default function SejarahVisiMisi({ title, data, isRuangLingkup }: any) {
  return (
    <GuestLayout>
      <PageLayout title={title}>
        <div className="mx-auto max-w-3xl">
          <Card className="p-0 lg:px-3 lg:py-2 shadow-2xl shadow-blue-500/20">
            {!isRuangLingkup && (
              <>
                <CardHeader>
                  <CardTitle className="text-base lg:text-lg font-bold">
                    {title}
                  </CardTitle>
                </CardHeader>
                <CardContent className="prose prose-sm prose-zinc">
                  {parse(data.isi)}
                </CardContent>
              </>
            )}

            {isRuangLingkup && (
              <>
                <CardHeader className="flex flex-col space-y-3">
                  {/* Judul */}
                  <h1 className="text-2xl lg:text-2xl font-extrabold text-[#173454]">
                    {data.judul}
                  </h1>

                  {/* Tanggal */}
                  <div className="flex items-center text-gray-500 text-sm">
                    <Calendar className="w-4 h-4 mr-1" />
                    <span>
                      {data.tanggal_publish
                        ? formatTanggalIndo(data.tanggal_publish)
                        : "-"}
                    </span>
                  </div>

                  <hr />
                  {/* Sampul */}
                  {data.sampul && (
                    <img
                      src={`/storage/${data.sampul}`}
                      alt="Sampul"
                      className="rounded-xl shadow-md max-h-[400px] object-cover"
                    />
                  )}
                </CardHeader>

                <CardContent className="prose prose-sm lg:prose-base prose-zinc max-w-none">
                  {parse(data.konten)}
                </CardContent>
              </>
            )}

            <CardFooter className="flex flex-col lg:flex-row space-y-3 lg:space-y-0 justify-between">
              <a
                aria-label="link"
                href="#"
                className="flex items-center space-x-1 text-sm hover:underline font-medium"
              >
                <ArrowBigUp className="w-[18px]" />
                <span>Kembali ke atas</span>
              </a>
            </CardFooter>
          </Card>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
