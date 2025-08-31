import { useState } from "react";
import { Card } from "@/Components/card";
import { Button } from "@/Components/button";
import { Input } from "@/Components/ui/input";
import {
  FileText,
  Loader2,
  Calendar,
  Eye,
  Clock,
  CheckCircle,
} from "lucide-react";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/Components/ui/dialog";
import axios from "axios";

export default function CardCekPengajuanKeberatan() {
  const [nik, setNik] = useState("");
  const [results, setResults] = useState<any[]>([]);
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setResults([]);

    try {
      const res = await axios.post(route("cek-pengajuan-keberatan"), {
        nik: nik,
      });
      // console.log(res.data.result);
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
        Cek Status Pengajuan Keberatan
      </h2>
      <p className="text-sm text-gray-600 mb-6">
        Masukkan Nomor KTP yang digunakan saat mengajukan keberatan informasi
        publik untuk melihat status pengajuan Anda.
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
          {results.map((item, idx) => {
            if (item.status === "notfound") {
              return (
                <Card
                  key={idx}
                  className="p-4 border-l-4 border-gray-400 bg-gray-50"
                >
                  <div className="flex items-start gap-3">
                    <FileText className="hidden lg:inline w-6 h-6 text-gray-500" />
                    <div>
                      <p className="font-semibold text-gray-700">
                        Data Tidak Ditemukan
                      </p>
                      <p className="text-sm text-gray-600">{item.catatan}</p>
                    </div>
                  </div>
                </Card>
              );
            }

            return (
              <Card
                key={idx}
                className={`p-4 border-l-4 ${
                  item.status === "Selesai"
                    ? "border-green-600 bg-green-50"
                    : "border-yellow-600 bg-yellow-50"
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

                  {/* Status */}
                  <div className="flex items-start gap-3 justify-between">
                    <div className="flex items-start gap-3">
                      {item.status === "Selesai" ? (
                        <>
                          <CheckCircle className="hidden lg:inline w-6 h-6 text-green-600" />
                          <div>
                            <p className="font-semibold text-green-700">
                              Selesai
                            </p>
                            <p className="text-sm text-gray-700">
                              {item.catatan ??
                                "Pengajuan keberatan telah selesai."}
                            </p>
                          </div>
                        </>
                      ) : (
                        <>
                          <Clock className="hidden lg:inline w-6 h-6 text-yellow-600" />
                          <div>
                            <p className="font-semibold text-yellow-700">
                              Pending
                            </p>
                            <p className="text-sm text-gray-700">
                              Pengajuan keberatan Anda masih dalam proses.
                            </p>
                          </div>
                        </>
                      )}
                    </div>

                    {/* Tombol Detail */}
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

                      <DialogContent className="max-w-md max-h-[90vh] overflow-y-auto rounded-2xl shadow-lg scrollbar-elegant">
                        <DialogHeader>
                          <DialogTitle className="text-lg font-semibold border-b pb-2">
                            Detail Pengajuan Keberatan
                          </DialogTitle>
                        </DialogHeader>

                        <div className="space-y-2 mt-3 text-sm">
                          {/* Nomor Registrasi */}
                          <div className="flex justify-between border-b pb-2">
                            <span className="text-gray-600 font-medium">
                              Nomor Registrasi
                            </span>
                            <span className="font-semibold">
                              {item.nomor_registrasi}
                            </span>
                          </div>

                          {/* Nomor KTP */}
                          <div className="flex justify-between border-b pb-2">
                            <span className="text-gray-600 font-medium">
                              Nomor KTP
                            </span>
                            <span>{item.nomor_ktp}</span>
                          </div>

                          {/* Nama Pemohon */}
                          <div className="flex justify-between border-b pb-2">
                            <span className="text-gray-600 font-medium">
                              Nama Pemohon
                            </span>
                            <span>{item.nama_pemohon}</span>
                          </div>

                          {/* Alamat Pemohon */}
                          <div className="border-b pb-2">
                            <span className="text-gray-600 font-medium block">
                              Alamat Pemohon
                            </span>
                            <p className="mt-1 text-gray-800">
                              {item.alamat_pemohon}
                            </p>
                          </div>

                          {/* Pekerjaan */}
                          <div className="flex justify-between border-b pb-2">
                            <span className="text-gray-600 font-medium">
                              Pekerjaan
                            </span>
                            <span>{item.pekerjaan}</span>
                          </div>

                          {/* No HP Pemohon */}
                          <div className="flex justify-between border-b pb-2">
                            <span className="text-gray-600 font-medium">
                              No HP Pemohon
                            </span>
                            <span>{item.no_hp_pemohon}</span>
                          </div>

                          {/* Data Kuasa Pemohon (jika ada) */}
                          {item.nama_kuasa_pemohon && (
                            <>
                              <div className="flex justify-between border-b pb-2">
                                <span className="text-gray-600 font-medium">
                                  Kuasa Pemohon
                                </span>
                                <span>{item.nama_kuasa_pemohon}</span>
                              </div>
                              <div className="border-b pb-2">
                                <span className="text-gray-600 font-medium block">
                                  Alamat Kuasa
                                </span>
                                <p className="mt-1 text-gray-800">
                                  {item.alamat_kuasa_pemohon}
                                </p>
                              </div>
                              <div className="flex justify-between border-b pb-2">
                                <span className="text-gray-600 font-medium">
                                  No HP Kuasa
                                </span>
                                <span>{item.no_hp_kuasa_pemohon}</span>
                              </div>
                            </>
                          )}

                          {/* Tujuan Penggunaan */}
                          <div className="border-b pb-2">
                            <span className="text-gray-600 font-medium block">
                              Tujuan Penggunaan
                            </span>
                            <p className="mt-1 text-gray-800">
                              {item.tujuan_penggunaan}
                            </p>
                          </div>

                          {/* Alasan */}
                          <div className="border-b pb-2">
                            <span className="text-gray-600 font-medium block">
                              Alasan
                            </span>
                            <p className="mt-1 text-gray-800">{item.alasan}</p>
                          </div>

                          {/* Kasus Posisi */}
                          <div className="border-b pb-2">
                            <span className="text-gray-600 font-medium block">
                              Kasus Posisi
                            </span>
                            <p className="mt-1 text-gray-800">
                              {item.kasus_posisi}
                            </p>
                          </div>

                          {/* Tanggal Diajukan */}
                          <div className="flex justify-between border-b pb-2">
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

                          {/* Status */}
                          <div className="flex justify-between items-start border-b pb-2">
                            <span className="text-gray-600 font-medium">
                              Status
                            </span>
                            <span
                              className={`font-semibold px-2 py-1 rounded-full text-xs ${
                                item.status === "Selesai"
                                  ? "bg-green-100 text-green-700"
                                  : "bg-yellow-100 text-yellow-700"
                              }`}
                            >
                              {item.status}
                            </span>
                          </div>

                          {/* Catatan & Lampiran jika selesai */}
                          {item.status === "Selesai" && (
                            <>
                              <div className="border-b pb-2">
                                <span className="text-gray-600 font-medium block">
                                  Catatan
                                </span>
                                <p className="mt-1 text-gray-800">
                                  {item.catatan ?? "-"}
                                </p>
                              </div>

                              {item.lampiran && (
                                <div className="pt-2">
                                  <a
                                    href={`/storage/${item.lampiran}`}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="inline-flex items-center text-blue-600 hover:underline font-medium"
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
                  </div>
                </div>
              </Card>
            );
          })}
        </div>
      )}
    </Card>
  );
}
