import { Button } from "@/Components/button";
import { Loader2, RefreshCcw } from "lucide-react";
import {
  FormInput,
  TextAreaInput,
} from "../PPIDFormPermohonan/FormInputPermohonan";
import { useEffect, useState } from "react";
import { useForm, usePage } from "@inertiajs/react";
import axios from "axios";

export default function FormInputPengajuan() {
  const [captcha, setCaptcha] = useState("");
  const [captchaInput, setCaptchaInput] = useState("");
  const { flash }: any = usePage().props;

  const { data, setData, post, reset, processing, errors } = useForm({
    nomor_registrasi: "",
    tujuan_penggunaan: "",
    nama_pemohon: "",
    alamat_pemohon: "",
    pekerjaan: "",
    no_hp_pemohon: "",
    kasus_posisi: "",
    nama_kuasa_pemohon: "",
    alamat_kuasa_pemohon: "",
    no_hp_kuasa_pemohon: "",
    alasan: "",
  });

  const generateCaptcha = () => {
    const chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
    let result = "";
    for (let i = 0; i < 6; i++) {
      result += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    setCaptcha(result);
    setCaptchaInput("");
  };

  useEffect(() => {
    generateCaptcha();
  }, []);

  // ambil query string dari URL
  useEffect(() => {
    const params = new URLSearchParams(window.location.search);
    const noReg = params.get("no_registrasi");
    if (noReg) {
      setData("nomor_registrasi", noReg.toUpperCase());
    }
  }, []);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (captchaInput !== captcha) {
      alert("Captcha salah ❌, silakan coba lagi");
      generateCaptcha();
      return;
    }

    post(route("ppid-form-keberatan"), {
      onSuccess: () => {
        reset();
        generateCaptcha();
        setResults("");
        window.scrollTo({ top: 0, behavior: "smooth" });
      },
    });
  };

  // logika cekPermohonan tetap
  const [results, setResults] = useState<any>("");
  const [loading, setLoading] = useState(false);

  const cekPermohonan = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setResults("");

    try {
      const res = await axios.post(route("get-permohonan"), {
        nomor_registrasi: data.nomor_registrasi.toUpperCase(),
      });

      setResults(res.data.result);

      if (res.data.result.status == "notfound") {
        resetForm();
        return;
      }

      const dataPermohonan = res.data.result.data;
      // console.log(dataPermohonan.tujuan_permohonan)
      if (res.data.result.status != "notfound") {
        data.tujuan_penggunaan = dataPermohonan.tujuan_permohonan;
        data.nama_pemohon = dataPermohonan.nama_pemohon;
        data.alamat_pemohon = dataPermohonan.alamat;
        data.pekerjaan = dataPermohonan.pekerjaan;
        data.no_hp_pemohon = dataPermohonan.no_hp;
      }
    } catch (error) {
      console.error(error);
    } finally {
      setLoading(false);
    }
  };

  const resetForm = () => {
    // data.nomor_registrasi = "";
    data.tujuan_penggunaan = "";
    data.nama_pemohon = "";
    data.alamat_pemohon = "";
    data.pekerjaan = "";
    data.no_hp_pemohon = "";
    data.kasus_posisi = "";
    data.nama_kuasa_pemohon = "";
    data.alamat_kuasa_pemohon = "";
    data.no_hp_kuasa_pemohon = "";
    data.alasan = "";
  };

  return (
    <>
      {flash.success && (
        <div className="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300">
          {flash.success}
        </div>
      )}

      <form
        onSubmit={handleSubmit}
        className="grid grid-cols-1 md:grid-cols-2 gap-6"
      >
        {/* Kolom Kiri */}
        <div className="space-y-4">
          {/* Nomor Registrasi (pakai cekPermohonan) */}
          <div>
            <FormInput
              disabled={results !== "" && results?.status === true}
              maxLength="12"
              className="uppercase"
              label="No Registrasi Permohonan Informasi"
              name="nomor_registrasi"
              value={data.nomor_registrasi}
              onChange={(e: any) => setData("nomor_registrasi", e.target.value)}
              required
              error={errors.nomor_registrasi}
            />
            <div className="flex justify-between items-center gap-2">
              <div className="mt-2 flex gap-1">
                <Button
                  disabled={
                    loading || (results !== "" && results?.status === true)
                  }
                  onClick={cekPermohonan}
                  variant="default"
                  size="sm"
                  className="bg-[#1B3C60] border items-center gap-1 text-xs"
                >
                  {loading ? (
                    <>
                      <Loader2 className="w-4 h-4 animate-spin" /> Memeriksa...
                    </>
                  ) : (
                    "Cek Permohonan"
                  )}
                </Button>
                <Button
                  type="button"
                  onClick={() => {
                    data.nomor_registrasi = "";
                    setResults("");
                    resetForm();
                  }}
                  variant="outline"
                  size="sm"
                  className="items-center text-xs"
                  disabled={loading}
                >
                  <RefreshCcw />
                </Button>
              </div>
              {results?.catatan && (
                <span
                  className={`text-xs text-end ${
                    results.status === true
                      ? "text-green-700" // kalau status = true → hijau
                      : results.status === "Selesai"
                      ? "text-blue-700" // kalau status = selesai → biru
                      : "text-red-700" // default → merah
                  }`}
                >
                  {results.catatan}
                </span>
              )}
            </div>
          </div>

          <TextAreaInput
            disabled={
              results === "" ||
              results?.status === "notfound" ||
              results.status === "Selesai"
            }
            label="Tujuan Penggunaan Informasi"
            name="tujuan_penggunaan"
            value={data.tujuan_penggunaan}
            onChange={(e: any) => setData("tujuan_penggunaan", e.target.value)}
            required
            error={errors.tujuan_penggunaan}
          />

          <div>
            <p className="text-[#1A3C61] text-sm font-bold uppercase">
              INDENTITAS PEMOHON
            </p>
            <div className="h-0.5 w-12 bg-[#1A3C61]"></div>
          </div>

          <FormInput
            disabled={
              results === "" ||
              results?.status === "notfound" ||
              results.status === "Selesai"
            }
            label="Nama Pemohon"
            name="nama_pemohon"
            value={data.nama_pemohon}
            onChange={(e: any) => setData("nama_pemohon", e.target.value)}
            required
            error={errors.nama_pemohon}
          />

          <TextAreaInput
            disabled={
              results === "" ||
              results?.status === "notfound" ||
              results.status === "Selesai"
            }
            label="Alamat"
            name="alamat"
            value={data.alamat_pemohon}
            onChange={(e: any) => setData("alamat_pemohon", e.target.value)}
            required
            rows={3}
            error={errors.alamat_pemohon}
          />

          <FormInput
            disabled={
              results === "" ||
              results?.status === "notfound" ||
              results.status === "Selesai"
            }
            label="Pekerjaan"
            name="pekerjaan"
            value={data.pekerjaan}
            onChange={(e: any) => setData("pekerjaan", e.target.value)}
            required
            error={errors.pekerjaan}
          />

          <FormInput
            disabled={
              results === "" ||
              results?.status === "notfound" ||
              results.status === "Selesai"
            }
            label="No.Tlp/HP"
            name="no_hp"
            value={data.no_hp_pemohon}
            onChange={(e: any) => setData("no_hp_pemohon", e.target.value)}
            required
            error={errors.no_hp_pemohon}
          />

          <TextAreaInput
            disabled={
              results === "" ||
              results?.status === "notfound" ||
              results.status === "Selesai"
            }
            label="Kasus Posisi"
            name="kasus_posisi"
            value={data.kasus_posisi}
            onChange={(e: any) => setData("kasus_posisi", e.target.value)}
            required
            rows={3}
            error={errors.kasus_posisi}
          />
        </div>

        {/* Kolom Kanan */}
        <div className="space-y-4">
          <div>
            <p className="text-[#1A3C61] text-sm font-bold uppercase">
              INDENTITAS KUASA PEMOHON
            </p>
            <div className="h-0.5 w-12 bg-[#1A3C61]"></div>
          </div>

          <FormInput
            disabled={
              results === "" ||
              results?.status === "notfound" ||
              results.status === "Selesai"
            }
            label="Nama Kuasa Pemohon"
            name="nama_kuasa_pemohon"
            value={data.nama_kuasa_pemohon}
            onChange={(e: any) => setData("nama_kuasa_pemohon", e.target.value)}
            required
            error={errors.nama_kuasa_pemohon}
          />

          <TextAreaInput
            disabled={
              results === "" ||
              results?.status === "notfound" ||
              results.status === "Selesai"
            }
            label="Alamat Kuasa Pemohon"
            name="alamat_kuasa"
            value={data.alamat_kuasa_pemohon}
            onChange={(e: any) =>
              setData("alamat_kuasa_pemohon", e.target.value)
            }
            required
            rows={3}
            error={errors.alamat_kuasa_pemohon}
          />

          <FormInput
            disabled={
              results === "" ||
              results?.status === "notfound" ||
              results.status === "Selesai"
            }
            label="No.Tlp/HP Kuasa Pemohon"
            name="no_hp_kuasa_pemohon"
            value={data.no_hp_kuasa_pemohon}
            onChange={(e: any) =>
              setData("no_hp_kuasa_pemohon", e.target.value)
            }
            required
            error={errors.no_hp_kuasa_pemohon}
          />

          {/* Alasan */}
          <div>
            <label className="block text-sm font-medium mb-1">
              Alasan Pengajuan Keberatan *
            </label>
            <div className="space-y-1 text-sm">
              {[
                "Permohonan informasi ditolak",
                "Informasi berkala tidak disediakan",
                "Permintaan informasi tidak ditanggapi",
                "Permintaan informasi ditanggapi tidak sebagaimana yang diminta",
                "Permintaan informasi tidak dipenuhi",
                "Biaya yang dikenakan tidak wajar",
                "Informasi disampaikan melebihi jangka waktu yang ditentukan",
              ].map((al) => (
                <label
                  key={al}
                  className={`${
                    results === "" ||
                    results?.status === "notfound" ||
                    results.status === "Selesai"
                      ? "pointer-events-none opacity-60"
                      : ""
                  } flex items-center gap-2`}
                >
                  <input
                    type="radio"
                    name="alasan"
                    value={al}
                    checked={data.alasan === al}
                    onChange={(e) => setData("alasan", e.target.value)}
                    required
                  />
                  {al}
                </label>
              ))}
            </div>
            {errors.alasan && (
              <div className="text-red-500 text-xs">{errors.alasan}</div>
            )}
          </div>

          {/* Captcha */}
          <div className="select-none">
            <div className="mb-1 flex justify-between">
              <label className="block text-sm font-medium">Ketik kode</label>
              <button
                type="button"
                onClick={generateCaptcha}
                className="text-sm text-blue-500 underline"
              >
                Refresh
              </button>
            </div>
            <div className="flex items-center gap-2 mb-2">
              <div className="bg-gray-200 px-4 py-2 rounded font-mono tracking-widest text-lg">
                {captcha}
              </div>
              <input
                type="text"
                value={captchaInput}
                onChange={(e) => setCaptchaInput(e.target.value)}
                className="w-full border rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1a4577a4] transition"
                required
              />
            </div>
          </div>
          {/* <div>
          <label className="block text-sm font-medium mb-1">
            Hari/Tanggal Tanggapan Atas Keberatan Akan Diberikan *
          </label>
          <input
            type="date"
            name="tanggal_tanggapan"
            value={data.tanggal_tanggapan}
            onChange={(e) => setData("tanggal_tanggapan", e.target.value)}
            className="w-full border rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1a4577a4] transition"
            required
          />
          {errors.tanggal_tanggapan && (
            <div className="text-red-500 text-xs">
              {errors.tanggal_tanggapan}
            </div>
          )}
        </div> */}
        </div>

        {/* Submit */}
        <div className="md:col-span-2 flex justify-end">
          <Button
            type="submit"
            disabled={
              processing ||
              results === "" ||
              results?.status === "notfound" ||
              results.status === "Selesai"
            }
            className="bg-[#1B3C60] text-white px-6 py-2 rounded-md"
          >
            {processing ? "Mengirim..." : "KIRIM PERMOHONAN"}
          </Button>
        </div>
      </form>
    </>
  );
}
