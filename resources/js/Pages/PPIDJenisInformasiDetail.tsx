import GuestLayout from "@/Layouts/GuestLayout";
import PageLayout from "@/Layouts/PageLayout";
import { Card } from "@/Components/card";
import { Link } from "@inertiajs/react";
import { ArrowLeft } from "lucide-react";
import { formatTanggalIndo, titleCase } from "@/lib/utils";

export default function DetailDokumen({
  title,
  jenisInformasi,
  data,
}: {
  title: string;
  jenisInformasi: string;
  data: any;
}) {
  return (
    <GuestLayout>
      <PageLayout title={"PPID - " + title}>
        <div className="mx-auto max-w-6xl">
          {/* Header */}
          <Card className="p-6 mb-6">
            <div className="flex flex-col lg:flex-row justify-between items-start">
              <div>
                <h1 className="text-xl lg:text-2xl font-bold text-[#1B3C60] leading-[1.15] lg:leading-[1.25]">
                  {data.judul}
                </h1>
                <div className="flex items-center gap-6 mt-2 text-sm text-gray-600">
                  {/* Total Unduhan */}
                  <div className="flex items-center gap-1">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      className="h-4 w-4 text-gray-600"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"
                      />
                    </svg>
                    <span>{Number(data.total_unduh.toLocaleString('id-ID'))} Unduhan</span>
                  </div>

                  {/* Total Dilihat */}
                  <div className="flex items-center gap-1">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      className="h-4 w-4 text-gray-600"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                      />
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                      />
                    </svg>
                    <span>{Number(data.total_lihat.toLocaleString('id-ID'))} Kali Dilihat</span>
                  </div>
                </div>
              </div>

              <a
                href={
                  data.lampiran ? route("downloadDokumenPPID", data.id) : "#"
                }
                download
                className={`${!data.lampiran ? 'pointer-events-none opacity-45' : ''} mt-4 lg:mt-0 bg-[#1B3C60] text-sm lg:text-base text-white px-4 py-2 rounded-md shadow-md flex items-center gap-2 transition`}
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  className="size-4 lg:size-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"
                  />
                </svg>
                Download File
              </a>
            </div>
          </Card>

          {/* Body */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {/* Info Dokumen */}
            <div>
              <Link
                href={route("menuPPIDJenisInformasi", jenisInformasi)}
                className="mb-2 bg-gray-600 text-xs text-white px-4 py-2 rounded-md shadow-md flex justify-center items-center gap-2 transition hover:bg-gray-700"
              >
                <ArrowLeft className="w-4 h-4" />
                Kembali
              </Link>

              <Card className="p-6 h-fit">
                <dl className="space-y-3 text-sm">
                  <div>
                    <dt className="font-semibold text-gray-700">
                      Nama Dokumen
                    </dt>
                    <dd className="text-gray-600">{data.judul ?? "-"}</dd>
                  </div>
                  <div>
                    <dt className="font-semibold text-gray-700">
                      Tanggal Publish
                    </dt>
                    <dd className="text-gray-600">
                      {data.tanggal_publish
                        ? formatTanggalIndo(data.tanggal_publish)
                        : "-"}
                    </dd>
                  </div>
                  <div>
                    <dt className="font-semibold text-gray-700">
                      Kategori Dokumen
                    </dt>
                    <dd className="text-gray-600">
                      {titleCase(data.kategori)}
                    </dd>
                  </div>
                  <div>
                    <dt className="font-semibold text-gray-700">OPD</dt>
                    <dd className="text-gray-600">{data.user?.name ?? "-"}</dd>
                  </div>
                </dl>
              </Card>
            </div>

            {/* Preview Dokumen */}
            <div className="md:col-span-2">
              <Card className="p-4">
                <h3 className="text-center font-semibold mb-2">
                  Preview Dokumen
                </h3>

                {data.lampiran ? (
                  <iframe
                    src={`/storage/${data.lampiran}`}
                    className="w-full h-[550px] lg:h-[600px] border rounded-md"
                  />
                ) : (
                  <div className="bg-gray-50 w-full h-[240px] border rounded-md flex flex-col items-center justify-center text-gray-500">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      className="h-12 w-12 mb-2 text-gray-400"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      strokeWidth={1.5}
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M9 13h6m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"
                      />
                    </svg>
                    <p className="text-sm">Dokumen tidak tersedia</p>
                  </div>
                )}
              </Card>
            </div>
          </div>
        </div>
      </PageLayout>
    </GuestLayout>
  );
}
