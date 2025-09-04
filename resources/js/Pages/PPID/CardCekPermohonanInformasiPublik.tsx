import { useState } from "react";
import { Card } from "@/Components/card";
import { Button } from "@/Components/button";
import { Input } from "@/Components/ui/input";
import {
  FileText,
  XCircle,
  CheckCircle,
  Loader2,
  Calendar,
  Eye,
  Clock,
} from "lucide-react";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/Components/ui/dialog";
import axios from "axios";
import { Link } from "@inertiajs/react";

export default function CekStatusPermohonanInformasiPublik() {
  const [nik, setNik] = useState("");
  const [results, setResults] = useState<any[]>([]);
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setResults([]);

    try {
      const res = await axios.post(route("cek-permohonan"), { nik: nik });
      setResults(res.data.result);
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
    }
  };

  return (
    <Card className="rounded-2xl shadow-md p-6">
      <h2 className="text-lg font-semibold mb-2">
        Cek Status Permohonan Informasi Publik
      </h2>
      <p className="text-sm text-gray-600 mb-6">
        Masukkan Nomor KTP yang digunakan saat mengajukan permohonan informasi
        publik untuk melihat status permohonan Anda.
      </p>

      {/* Form */}
      <form onSubmit={handleSubmit} className="flex flex-col sm:flex-row gap-3">
        <Input
          type="text"
          placeholder="Masukkan Nomor KTP"
          value={nik}
          onChange={(e) => setNik(e.target.value)}
          className="flex-1 no-spinner text-sm py-2 lg:py-1"
          maxLength={16}
          readOnly={loading}
          required
        />
        <Button
          type="submit"
          className="bg-[#1B3C60] hover:bg-[#254a73] text-white px-6 flex items-center justify-center gap-2"
          disabled={loading}
        >
          {loading ? (
            <>
              <Loader2 className="w-4 h-4 animate-spin" /> Memeriksa...
            </>
          ) : (
            "Cek Status"
          )}
        </Button>
      </form>

      {/* Hasil */}
      {!loading && results.length > 0 && (
        <div className="mt-6 space-y-4">
          {results.map((item, idx) => (
            <Card
              key={idx}
              className={`p-4 border-l-4 ${
                item.status === "Disetujui"
                  ? "border-green-600 bg-green-50"
                  : item.status === "Ditolak"
                  ? "border-red-600 bg-red-50"
                  : item.status === "Pending"
                  ? "border-yellow-600 bg-yellow-50"
                  : "border-gray-500 bg-gray-50"
              }`}
            >
              <div className="flex flex-col gap-2">
                {/* Tanggal diajukan */}
                {item.tanggal_diajukan && (
                  <div className="flex items-center text-xs text-gray-600">
                    <Calendar className="w-4 h-4 mr-1" />
                    <span>
                      Diajukan:{" "}
                      {new Date(item.tanggal_diajukan).toLocaleDateString(
                        "id-ID",
                        {
                          day: "2-digit",
                          month: "short",
                          year: "numeric",
                        }
                      )}
                    </span>
                  </div>
                )}

                {/* Status + Catatan */}
                <div className="flex items-start gap-3 justify-between">
                  <div className="flex items-start gap-3">
                    {item.status === "Disetujui" && (
                      <>
                        <CheckCircle className="hidden lg:inline w-6 h-6 text-green-600" />
                        <div>
                          <p className="font-semibold text-green-700">
                            Disetujui
                          </p>
                          <p className="text-sm text-gray-700">
                            {item.catatan}
                          </p>
                        </div>
                      </>
                    )}
                    {item.status === "Ditolak" && (
                      <>
                        <XCircle className="hidden lg:inline w-6 h-6 text-red-600" />
                        <div>
                          <p className="font-semibold text-red-700">Ditolak</p>
                          <p className="text-sm text-gray-700">
                            {item.catatan}
                          </p>
                          <Link
                            href={route("form-keberatan", { no_registrasi: item.nomor_registrasi })} // sesuaikan dengan route yang kamu punya
                            className="inline-flex items-center text-sm font-medium text-blue-600 hover:underline"
                          >
                            Ajukan Keberatan
                          </Link>
                        </div>
                      </>
                    )}
                    {item.status === "Pending" && (
                      <>
                        <Clock className="hidden lg:inline w-6 h-6 text-yellow-600" />
                        <div>
                          <p className="font-semibold text-yellow-700">
                            Sedang Diproses
                          </p>
                          <p className="text-sm text-gray-700">
                            Silahkan cek secara berkala permohonan Anda.
                          </p>
                        </div>
                      </>
                    )}

                    {item.status === "notfound" && (
                      <div>
                        <p className="text-sm text-gray-700">{item.catatan}</p>
                      </div>
                    )}
                  </div>

                  {/* Tombol Detail */}
                  {item.status !== "notfound" && (
                    <Dialog>
                      <DialogTrigger asChild>
                        <Button
                          variant="outline"
                          size="sm"
                          className="border flex items-center gap-1 text-xs"
                        >
                          <Eye className="w-4 h-4" />{" "}
                          <span className="hidden lg:inline">Detail</span>
                        </Button>
                      </DialogTrigger>

                      <DialogContent className="max-w-md rounded-2xl shadow-lg">
                        <DialogHeader>
                          <DialogTitle className="text-lg font-semibold border-b pb-2">
                            Detail Permohonan
                          </DialogTitle>
                        </DialogHeader>

                        <div className="space-y-1 mt-3">
                          {/* No Registrasi */}
                          <div className="flex justify-between items-start border-b pb-2">
                            <span className="text-gray-600 font-medium">
                              Nomor Registrasi Permohonan
                            </span>
                            <span className="font-semibold">
                              {item.nomor_registrasi}
                            </span>
                          </div>

                          {/* Pemohon */}
                          <div className="flex justify-between items-start border-b pb-2">
                            <span className="text-gray-600 font-medium">
                              Pemohon
                            </span>
                            <span className="font-semibold">
                              {item.nama_pemohon}
                            </span>
                          </div>

                          {/* Tanggal */}
                          <div className="flex justify-between items-start border-b pb-2">
                            <span className="text-gray-600 font-medium">
                              Tanggal
                            </span>
                            <span>
                              {new Date(
                                item.tanggal_diajukan
                              ).toLocaleDateString("id-ID", {
                                day: "2-digit",
                                month: "long",
                                year: "numeric",
                              })}
                            </span>
                          </div>

                          {/* Rincian */}
                          <div className="border-b pb-2">
                            <span className="text-gray-600 font-medium block">
                              Rincian Informasi
                            </span>
                            <p className="mt-1 text-gray-800 text-sm">
                              {item.rincian_informasi}
                            </p>
                          </div>

                          {/* Tujuan */}
                          <div className="border-b pb-2">
                            <span className="text-gray-600 font-medium block">
                              Tujuan Permohonan
                            </span>
                            <p className="mt-1 text-gray-800 text-sm">
                              {item.tujuan_permohonan}
                            </p>
                          </div>

                          {/* Status */}
                          <div className="flex justify-between items-start border-b pb-2">
                            <span className="text-gray-600 font-medium">
                              Status
                            </span>
                            <span
                              className={`font-semibold px-2 py-1 rounded-full text-xs ${
                                item.status === "Disetujui"
                                  ? "bg-green-100 text-green-700"
                                  : item.status === "Ditolak"
                                  ? "bg-red-100 text-red-700"
                                  : item.status === "Pending"
                                  ? "bg-yellow-100 text-yellow-700"
                                  : "bg-gray-100 text-gray-700"
                              }`}
                            >
                              {item.status}
                            </span>
                          </div>

                          {/* Hanya tampil kalau !== Pending */}
                          {item.status !== "Pending" && (
                            <>
                              {/* Catatan */}
                              <div className="border-b pb-2">
                                <span className="text-gray-600 font-medium block">
                                  Catatan
                                </span>
                                <p className="mt-1 text-gray-800 text-sm">
                                  {item.catatan ?? "-"}
                                </p>
                              </div>

                              {/* Lampiran */}
                              {item.lampiran && (
                                <div className="pt-2">
                                  <a
                                    href={`/storage/${item.lampiran}`}
                                    target="_blank"
                                    className="inline-flex items-center text-blue-600 hover:underline text-sm font-medium"
                                  >
                                    <FileText className="w-4 h-4 mr-1" /> Unduh
                                    Dokumen
                                  </a>
                                </div>
                              )}
                            </>
                          )}
                        </div>
                      </DialogContent>
                    </Dialog>
                  )}
                </div>
              </div>
            </Card>
          ))}
        </div>
      )}
    </Card>
  );
}
