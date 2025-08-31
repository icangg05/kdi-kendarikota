import { Button } from "@/Components/button";
import { useForm, usePage } from "@inertiajs/react";
import { useEffect, useRef, useState } from "react";

export const FormInput = ({
  label,
  error,
  className,
  ...props // tangkap semua props lain (type, name, value, onChange, required, disabled, dll)
}: any) => {
  return (
    <div>
      {label && (
        <label
          htmlFor={props.id || props.name}
          className="block text-sm font-medium mb-1"
        >
          {label} {props.required ? "*" : ""}
        </label>
      )}
      <input
        {...props} // spread semua attribute biar jalan (disabled, required, dll)
        className={`w-full border rounded-md p-2 text-sm focus:outline-none focus:ring-1 ${
          error ? "border-red-500 focus:ring-red-500" : "focus:ring-[#1a4577a4]"
        } transition ${className || ""}`}
      />
      {error && <div className="text-red-500 text-xs mt-1">{error}</div>}
    </div>
  );
};

export const TextAreaInput = ({
  label,
  error,
  className,
  ...props // tangkap semua props (name, value, onChange, rows, required, disabled, dll)
}: any) => {
  return (
    <div>
      {label && (
        <label
          htmlFor={props.id || props.name}
          className="block text-sm font-medium mb-1"
        >
          {label} {props.required ? "*" : ""}
        </label>
      )}
      <textarea
        {...props} // spread semua attribute biar jalan
        rows={props.rows || 3}
        className={`w-full border rounded-md p-2 text-sm focus:outline-none focus:ring-1 ${
          error ? "border-red-500 focus:ring-red-500" : "focus:ring-[#1a4577a4]"
        } transition ${className || ""}`}
      />
      {error && <div className="text-red-500 text-xs mt-1">{error}</div>}
    </div>
  );
};


export default function FormInputPermohonan() {
  const [captcha, setCaptcha] = useState("");
  const [captchaInput, setCaptchaInput] = useState("");
  const { flash }: any = usePage().props;

  const { data, setData, post, reset, processing, errors } = useForm({
    nama_pemohon: "",
    nomor_ktp: "",
    foto_ktp: null as File | null,
    nomor_pengesahan: "",
    alamat: "",
    pekerjaan: "",
    no_hp: "",
    email: "",
    rincian_informasi: "",
    tujuan_permohonan: "",
    cara_memperoleh_informasi: "",
    mendapatkan_salinan: "",
    cara_mendapatkan_salinan: "",
  });

  const generateCaptcha = () => {
    const chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcefghijklmnopqrstuvwxyz";
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

  const fileInputRef = useRef<HTMLInputElement | null>(null);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (captchaInput !== captcha) {
      alert("Captcha salah ❌, silakan coba lagi");
      generateCaptcha();
      return;
    }

    post(route("ppid-form-permohonan"), {
      forceFormData: true,
      onSuccess: () => {
        reset(); // reset semua field inertia
        generateCaptcha();
        window.scrollTo({ top: 0, behavior: "smooth" });

        // reset file input secara manual
        if (fileInputRef.current) {
          fileInputRef.current.value = "";
        }
      },
    });
  };

  return (
    <div>
      {/* Flash success message */}
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
          <FormInput
            label="Nama Pemohon (Pribadi/Badan Hukum)"
            name="nama_pemohon"
            value={data.nama_pemohon}
            onChange={(e: any) => setData("nama_pemohon", e.target.value)}
            required
            error={errors.nama_pemohon}
          />

          <FormInput
            label="Nomor KTP"
            name="nomor_ktp"
            value={data.nomor_ktp}
            onChange={(e: any) => setData("nomor_ktp", e.target.value)}
            required
            error={errors.nomor_ktp}
          />

          <div>
            <label className="block text-sm font-medium mb-1">
              Upload Foto KTP *
            </label>
            <input
              type="file"
              ref={fileInputRef}
              onChange={(e: any) => setData("foto_ktp", e.target.files[0])}
              accept="image/*"
              required
              className={errors.foto_ktp ? "border-red-500" : ""}
            />
            {errors.foto_ktp && (
              <div className="text-red-500 text-xs mt-1">{errors.foto_ktp}</div>
            )}
          </div>

          <FormInput
            label="Nomor Pengesahan (Badan Hukum)"
            name="nomor_pengesahan"
            value={data.nomor_pengesahan}
            onChange={(e: any) => setData("nomor_pengesahan", e.target.value)}
            error={errors.nomor_pengesahan}
          />

          <TextAreaInput
            label="Alamat"
            name="alamat"
            value={data.alamat}
            onChange={(e: any) => setData("alamat", e.target.value)}
            required
            rows={4}
            error={errors.alamat}
          />

          <FormInput
            label="Pekerjaan"
            name="pekerjaan"
            value={data.pekerjaan}
            onChange={(e: any) => setData("pekerjaan", e.target.value)}
            required
            error={errors.pekerjaan}
          />

          <FormInput
            label="No. HP"
            name="no_hp"
            value={data.no_hp}
            onChange={(e: any) => setData("no_hp", e.target.value)}
            required
            error={errors.no_hp}
          />

          <FormInput
            label="Email"
            name="email"
            value={data.email}
            onChange={(e: any) => setData("email", e.target.value)}
            required
            error={errors.email}
          />
        </div>

        {/* Kolom Kanan */}
        <div className="space-y-4">
          <TextAreaInput
            label="Rincian Informasi yang Dibutuhkan"
            name="rincian_informasi"
            value={data.rincian_informasi}
            onChange={(e: any) => setData("rincian_informasi", e.target.value)}
            required
            rows={4}
            error={errors.rincian_informasi}
          />

          <TextAreaInput
            label="Tujuan Permohonan Informasi"
            name="tujuan_permohonan"
            value={data.tujuan_permohonan}
            onChange={(e: any) => setData("tujuan_permohonan", e.target.value)}
            required
            rows={4}
            error={errors.tujuan_permohonan}
          />

          {/* Radio buttons */}
          <div>
            <label className="block text-sm font-medium mb-1">
              Cara Memperoleh Informasi *
            </label>
            <div className="space-y-1 text-sm">
              {["Melihat", "Membaca", "Mendengarkan", "Mencatat"].map((c) => (
                <label key={c} className="flex items-center gap-2">
                  <input
                    type="radio"
                    name="cara_memperoleh_informasi"
                    value={c}
                    checked={data.cara_memperoleh_informasi === c}
                    onChange={(e) =>
                      setData("cara_memperoleh_informasi", e.target.value)
                    }
                    required
                  />
                  {c}
                </label>
              ))}
            </div>
            {errors.cara_memperoleh_informasi && (
              <div className="text-red-500 text-xs">
                {errors.cara_memperoleh_informasi}
              </div>
            )}
          </div>

          <div>
            <label className="block text-sm font-medium mb-1">
              Mendapatkan Salinan Informasi *
            </label>
            <div className="space-y-1 text-sm">
              {["Hardcopy", "Softcopy"].map((s) => (
                <label key={s} className="flex items-center gap-2">
                  <input
                    type="radio"
                    name="mendapatkan_salinan"
                    value={s}
                    checked={data.mendapatkan_salinan === s}
                    onChange={(e) =>
                      setData("mendapatkan_salinan", e.target.value)
                    }
                    required
                  />
                  {s}
                </label>
              ))}
            </div>
            {errors.mendapatkan_salinan && (
              <div className="text-red-500 text-xs">
                {errors.mendapatkan_salinan}
              </div>
            )}
          </div>

          <div>
            <label className="block text-sm font-medium mb-1">
              Cara Mendapatkan Salinan Informasi *
            </label>
            <select
              value={data.cara_mendapatkan_salinan}
              onChange={(e) =>
                setData("cara_mendapatkan_salinan", e.target.value)
              }
              className={`w-full border rounded-md p-2 text-sm focus:outline-none focus:ring-1 ${
                errors.cara_mendapatkan_salinan
                  ? "border-red-500 focus:ring-red-500"
                  : "focus:ring-[#1a4577a4]"
              } transition`}
              required
            >
              <option value="">-- Pilih Cara --</option>
              <option value="Mengambil Langsung">Mengambil Langsung</option>
              <option value="Kurir">Kurir</option>
              <option value="POS">POS</option>
              <option value="Fax">Fax</option>
              <option value="Email">Email</option>
              <option value="WhatsApp">WhatsApp</option>
            </select>
            {errors.cara_mendapatkan_salinan && (
              <div className="text-red-500 text-xs">
                {errors.cara_mendapatkan_salinan}
              </div>
            )}
          </div>

          {/* Captcha */}
          <div>
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
        </div>

        {/* Submit */}
        <div className="md:col-span-2 flex justify-end">
          <Button
            type="submit"
            disabled={processing}
            className="bg-[#1B3C60] text-white px-6 py-2 rounded-md"
          >
            {processing ? "Mengirim..." : "KIRIM PERMOHONAN"}
          </Button>
        </div>
      </form>
    </div>
  );
}
