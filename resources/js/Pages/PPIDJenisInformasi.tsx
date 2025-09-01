import GuestLayout from "@/Layouts/GuestLayout";
import PageLayout from "@/Layouts/PageLayout";
import { Card } from "@/Components/card";
import { Link, useForm } from "@inertiajs/react";
import { formatTanggalIndo } from "@/lib/utils";
import PaginationNav from "@/Components/PaginationNav";

export default function JenisInformasiPublik({
  title,
  jenisInformasi,
  data,
  filters
}: any) {
  const {
    data: form,
    setData,
    get,
  } = useForm({
    search: filters.search || "",
  });

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    get(route("menuPPIDJenisInformasi", jenisInformasi), {
      preserveState: true,
      preserveScroll: true,
      replace: true,
    });
  };

  return (
    <GuestLayout>
      <PageLayout title={"PPID - " + title}>
        <Card className="mx-auto max-w-6xl rounded-2xl shadow-md p-6">
          {/* Header + Search */}
          <form
            onSubmit={handleSearch}
            className="flex flex-col lg:flex-row gap-4 justify-between items-center mb-4"
          >
            <div>
              <h2 className="text-xl font-semibold">Daftar {title}</h2>
              <p className="text-sm text-gray-500">Daftar dokumen informasi</p>
            </div>
            <input
              type="text"
              placeholder="Search"
              value={form.search}
              onChange={(e) => setData("search", e.target.value)}
              className="w-full lg:w-fit px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-[#2f6cb3a4] text-sm"
            />
          </form>

          {/* Table */}
          <div className="overflow-x-scroll lg:overflow-auto">
            <table className="mt-5 w-full text-sm border-collapse">
              <thead>
                <tr className="bg-[#1B3C60] text-white text-left rounded-2xl">
                  <th className="px-4 py-3 w-12">No.</th>
                  <th className="px-4 py-3">Judul Dokumen Informasi</th>
                  <th className="px-4 py-3">Total Unduhan</th>
                  <th className="px-4 py-3">Total Lihat</th>
                  <th className="px-4 py-3 text-center w-32">Tampilkan</th>
                </tr>
              </thead>
              <tbody>
                {data.data.length > 0 ? (
                  data.data.map((item: any, index: number) => (
                    <tr
                      key={item.id}
                      className="border-b last:border-none hover:bg-gray-50 transition"
                    >
                      <td className="px-4 py-3">{data.from + index}.</td>
                      <td className="px-4 py-3">
                        <Link
                          href={route("menuPPIDJenisInformasiDetail", {
                            jenisInformasi: jenisInformasi,
                            slug: item.slug,
                          })}
                          className="font-semibold text-[#1B3C60] hover:underline cursor-pointer"
                        >
                          {item.judul}
                        </Link>
                        <div className="text-sm text-gray-600">
                          {item.user?.name ?? "-"}
                        </div>
                        <div className="text-xs text-gray-500">
                          {item.tanggal_publish
                            ? formatTanggalIndo(item.tanggal_publish)
                            : "-"}
                        </div>
                      </td>
                      <td className="px-4 py-3 text-gray-600">
                        {Number(item.total_unduh.toLocaleString('id-ID'))} kali
                      </td>
                      <td className="px-4 py-3 text-gray-500">
                        {Number(item.total_lihat.toLocaleString('id-ID'))} kali
                      </td>
                      <td className="px-4 py-3 text-center">
                        <Link
                          href={route("menuPPIDJenisInformasiDetail", {
                            jenisInformasi: jenisInformasi,
                            slug: item.slug,
                          })}
                          className="px-4 py-1 border rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition"
                        >
                          Lihat
                        </Link>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td
                      colSpan={5}
                      className="px-4 py-6 text-center text-gray-500 italic"
                    >
                      Belum ada dokumen
                    </td>
                  </tr>
                )}
              </tbody>
            </table>

            <div className="mt-4 col-span-6">
              <PaginationNav links={data.links} />
            </div>
          </div>
        </Card>
      </PageLayout>
    </GuestLayout>
  );
}
